# Backend Documentation

This file contains the main documentation for the backend system. Its purpose is to explain the structure, logic, and request-handling flow of the backend in a clear and organized way for developers.

---

## Backend Architecture

The backend follows the **MVC (Model–View–Controller)** architecture.  
Each layer has a specific responsibility to keep the code clean, maintainable, and scalable.

The layers include:

- **View:** The front-end pages sending user requests.
- **Controller:** Receives user requests and forwards them to the appropriate service.
- **Service:** Contains the business logic and processes data received by the controller.
- **Repository:** Handles all database queries and communicates with the database.
- **Model:** Represents the data structure used to work with database records.

---

## Models Structure

Two types of models are used in the system to simplify data handling:

### 1. Raw Model  
This model corresponds directly to a single row in a database table.  
When created, it only contains the fields of that specific table record.

### 2. Extended Model  
This model is designed for convenience when more complete user information is needed.  
In addition to the user’s main data, it also includes related information such as:

- shopping cart
- products in the cart
- transactions
- orders  
- and other linked data

This means an extended model returns **all data associated with the user**, not just the base table.

---

## User Login System

To identify a logged-in user across requests, the backend uses **JWT-based authentication**.

### Login Process:

1. The user logs into their account.
2. The server generates a **JWT token** containing essential user information.
3. The token is stored in the user's browser cookie.
4. For each incoming request, the server verifies the JWT token to confirm user identity.

### Data stored inside the JWT:

- **Account ID (UUID)**
- **Datetime (Token generation timestamp)**

---

## Shopping & Checkout Strategy

The purchase process consists of several steps to ensure accuracy and prevent issues like double purchases or concurrency problems.

### 1. Shopping Cart Creation
Users add one or more products to their shopping cart before starting the checkout process.

### 2. Checkout Session
When the user proceeds to checkout:

- A **session** is created to indicate the user is currently in the checkout process.
- Product stock is immediately reduced to prevent multiple users from purchasing the same item simultaneously.

### 3. Transaction Creation
When the user clicks the **Pay** button:

- A **transaction record** is created.
- The user is redirected to the payment page.

### 4. Finalizing the Purchase
After the payment finishes (successful or unsuccessful):

- An **order record** is created for each product.
- The shopping cart is deleted.
- The checkout session is cleared.
- The transaction status is updated accordingly.

# **Backend Routers Documentation**

This document provides a complete overview of all backend routers and their associated controllers. Each controller exposes a set of URL-based services, primarily using the **GET** method, and expects specific query parameters to determine which action to execute.

All controllers follow a unified request pattern:

* Each request **must include a `req` parameter**, whose numeric value determines the specific service being executed.
* If `req` is missing, invalid, or does not match any known service, the system **performs no operation** and **redirects the user to the home page**.
* After every operation (success or failure), the controller performs a **redirect**.
  To define the redirect target, include a `redirect` parameter containing the destination URL.
* If any error occurs during service execution, the error message will be appended to the redirect URL under the parameter `error`.

Some services also require additional identifiers such as the authenticated **user ID**, passed through the URL as `user`.

---

# **Controllers Overview**

* **accounts** — Manages user profile, account state, and role operations.
* **products** — Handles product lifecycle and seller operations.
* **carts** — Controls the user’s shopping cart.
* **transactions** — Manages wallet operations and transaction states.
* **shopping** — Handles final purchase processing.

---

# **1. Accounts Controller**

**Note:** All account services require the `user` parameter (user ID).

---

### **req(CONTROLLER_ACCOUNT_UPDATE)**

Updates one or more user profile fields. Every provided parameter overwrites its corresponding field in the database.

**Optional Parameters:**
`username`, `email`, `fname`, `lname`, `phone`, `zipcode`, `address`,
`card_number`, `card_terminal`, `instagram`, `telegram`

---

### **req(CONTROLLER_ACCOUNT_BLOCK)**

Blocks the specified user account.

⚠ **Bug:** No authentication is performed. Anyone with the user ID can trigger this action.

---

### **req(CONTROLLER_ACCOUNT_REMOVE)**

Deletes the specified user account.

⚠ **Bug:** No authentication validation exists.

---

### **req(CONTROLLER_ACCOUNT_UPGRADE)**

Upgrades the user’s role.

⚠ **Bug:** No authentication validation exists.

---

### **req(CONTROLLER_ACCOUNT_DOWNGRADE)**

Downgrades the user’s role.

⚠ **Bug:** No authentication validation exists.

---

### **req(CONTROLLER_ACCOUNT_SELLER_REQUEST)**

Submits a request to upgrade the user role to "seller".

⚠ **Bug:** No authentication validation exists.

---

### **req(CONTROLLER_ACCOUNT_SELLER_ACCEPT)**

Approves a user's seller request.

⚠ **Bug:** No authentication validation exists.

---

### **req(CONTROLLER_ACCOUNT_SELLER_REJECT)**

Rejects a user's seller request.

⚠ **Bug:** No authentication validation exists.

---

# **2. Products Controller**

**Note:** All product services require the `user` parameter.

---

### **req(CONTROLLER_PRODUCT_ADD)**

Creates a new product.

**Required Parameters:**
`type`, `name`, `description`, `count`, `price`, `offer`,
`color`, `material`, `size`

**Allowed Roles:**
Seller, Admin

---

### **req(CONTROLLER_PRODUCT_UPDATE)**

Updates fields of an existing product.

**Optional Parameters:**
`type`, `name`, `description`, `count`, `price`, `offer`,
`color`, `material`, `size`

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_SUSPEND)**

Moves the product to a suspended state.

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_REMOVE)**

Deletes the product.

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_RESTORE)**

Restores a previously removed or suspended product.

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_ACCEPT)**

Marks a product as accepted.

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_REJECT)**

Marks a product as rejected.

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_INC)**

Increases the product stock count.

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_PRODUCT_DEC)**

Decreases the product stock count.

**Allowed Roles:**
Seller (Owner), Admin

---

# **3. Carts Controller**

**Note:** All cart services require the `user` parameter.

---

### **req(CONTROLLER_CART_ADD_CART)**

Adds a specific product variant to the user’s cart.

**Parameters:**
`product (uuid)`, `color (uuid)`, `material (uuid)`, `size (uuid)`, `count`

---

### **req(CONTROLLER_CART_REMOVE_CART)**

Removes a product from the cart.

**Parameters:**
`product (uuid)`

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_CART_EMPTY_CART)**

Clears all items from the user's cart.

---

### **req(CONTROLLER_CART_INC_PRODUCT_COUNT)**

Increases the count of a product inside the cart.

**Parameters:**
`product (uuid)`

**Allowed Roles:**
Seller (Owner), Admin

---

### **req(CONTROLLER_CART_DEC_PRODUCT_COUNT)**

Decreases the count of a product inside the cart.

**Parameters:**
`product (uuid)`

**Allowed Roles:**
Seller (Owner), Admin

---

# **4. Transactions Controller**

**Note:** All services require the `user` parameter.

---

### **req(CONTROLLER_TRANSACTION_CHARGE)**

Adds credit to the user’s wallet.

**Parameters:**
`amount`, `tcode (optional)`

---

### **req(CONTROLLER_TRANSACTION_EXCHANGE)**

Withdraws money from the user’s wallet.

**Parameters:**
`amount`

---

### **req(CONTROLLER_TRANSACTION_REMOVE)**

Deletes a transaction entry.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

### **req(CONTROLLER_TRANSACTION_OPEN)**

Marks a transaction as **open**.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

### **req(CONTROLLER_TRANSACTION_CLOSE)**

Marks a transaction as **closed**.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

### **req(CONTROLLER_TRANSACTION_STATUS_PAID)**

Sets transaction status to **paid**.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

### **req(CONTROLLER_TRANSACTION_STATUS_NOT_PAID)**

Sets transaction status to **not paid**.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

### **req(CONTROLLER_TRANSACTION_STATUS_SUSPENDED)**

Sets transaction status to **suspended**.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

### **req(CONTROLLER_TRANSACTION_STATUS_CONFIRM)**

Sets transaction status to **confirmed**.

**Parameters:**
`transaction (uuid)`

**Allowed Roles:**
Owner, Admin

---

# **5. Shopping Controller**

**Note:** Requires the `user` parameter.

---

### **req(CONTROLLER_ORDER_PURCHE)**

Processes the user's final order and initiates the purchase.

**Parameters:**

* `payment-method` (`PAYMENT_METHOD_WALLET` | `PAYMENT_METHOD_ONLINE`)
* `address`
* `zipcode`
* `phone`

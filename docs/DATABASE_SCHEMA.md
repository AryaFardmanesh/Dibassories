# 🗄️ Database Schema Documentation

This document describes the database structure used in this project.  
It defines all tables, their columns, relationships, and enumerated values.  
> **Note:** This database is designed for an academic project and is focused on clarity and normalization, not production-scale optimization.

---

## Tables Overview
All available tables are as follows:

| Name | Description |
|------|-------------|
| accounts | Save user accounts |
| accounts_confirm | Request for account verification |
| products | All available products |
| products_color | Product color |
| products_material | Product material |
| products_size | Product size |
| shopping_carts | Save user's shopping cart |
| cart_sessions | Create a session while purchasing a product |
| orders | Order registration |
| transactions | Save transactions |

---

## 📘 Tables Details

### **accounts**
Stores all user information, including authentication and contact data.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Unique account identifier |
| username | varchar(64) | UNIQUE, INDEX, NOT NULL | Login username |
| password | varchar(64) | NOT NULL | Hashed password |
| email | varchar(320) | UNIQUE, NOT NULL | User email address |
| fname | varchar(32) | NOT NULL | First name |
| lname | varchar(32) | NOT NULL | Last name |
| phone | varchar(12) | UNIQUE, NOT NULL | Phone number |
| pangirno | varchar(16) | UNIQUE, NOT NULL | National ID |
| address | varchar(512) | NOT NULL | Full address |
| zipcode | varchar(16) | NOT NULL | Postal code |
| card_number | varchar(16) | NOT NULL | Bank card number |
| card_terminal | varchar(32) | NOT NULL | Sheba's number |
| wallet_balance | decimal(12,2) | DEFAULT 0 | User’s wallet balance |
| instagram | varchar(128) | DEFAULT NULL | Optional Instagram link |
| telegram | varchar(128) | DEFAULT NULL | Optional Telegram link |
| role | tinyint | DEFAULT 0 | User role (see Roles section) |
| status | tinyint | DEFAULT 0 | Account status (see Status section) |
| created_at | datetime | DEFAULT current_timestamp | Record creation time |

---

### **accounts_confirm**
Stores pending confirmations for new accounts.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Confirmation ID |
| user | varchar(32) | UNIQUE, INDEX, NOT NULL | References `accounts.id` |
| created_at | datetime | DEFAULT current_timestamp | Creation time |

---

### **products**
Contains product details listed by sellers.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Product ID |
| owner | varchar(32) | INDEX, NOT NULL | References `accounts.id` (seller) |
| type | tinyint | INDEX, NOT NULL | Product type (see Product Types) |
| name | varchar(128) | NOT NULL | Product name |
| description | varchar(512) | NOT NULL | Product description |
| image | varchar(2048) | NOT NULL | Product image URL |
| count | int | NOT NULL | Quantity available |
| price | decimal(12,2) | NOT NULL | Base price |
| offer | tinyint | DEFAULT NULL | Optional discount indicator |
| status | tinyint | DEFAULT 1 | Product status |
| created_at | datetime | DEFAULT current_timestamp | Creation time |

---

### **products_color**
Available color variations for products.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Color ID |
| product | varchar(32) | INDEX, NOT NULL | References `products.id` |
| color_name | varchar(32) | NOT NULL | Color name (e.g., “Gold”) |
| color_hex | varchar(6) | NOT NULL | HEX color code |

---

### **products_material**
Materials used in a product.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Material ID |
| product | varchar(32) | INDEX, NOT NULL | References `products.id` |
| material | varchar(32) | NOT NULL | Material name (e.g., “Silver”) |

---

### **products_size**
Product sizes.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Size ID |
| product | varchar(32) | INDEX, NOT NULL | References `products.id` |
| size | varchar(32) | NOT NULL | Size value (e.g., “M”, “L”, “10mm”) |

---

### **shopping_carts**
Stores the active cart items for each user.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Cart ID |
| owner | varchar(32) | UNIQUE, INDEX, NOT NULL | References `accounts.id` |
| product | varchar(32) | NOT NULL | References `products.id` |
| product_color | varchar(32) | NOT NULL | References `products_color.id` |
| product_size | varchar(32) | NOT NULL | References `products_size.id` |
| product_material | varchar(32) | NOT NULL | References `products_material.id` |
| count | int | NOT NULL | Quantity |
| created_at | datetime | DEFAULT current_timestamp | Creation time |

---

### **cart_sessions**
Represents a user's cart session state.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Session ID |
| owner | varchar(32) | INDEX, NOT NULL | References `accounts.id` |
| status | tinyint | DEFAULT 3 | Session status (see Status section) |
| created_at | datetime | DEFAULT current_timestamp | Creation time |

---

### **orders**
Stores all placed orders (one order per product).

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Order ID |
| owner | varchar(32) | INDEX, NOT NULL | References `accounts.id` (buyer) |
| provider | varchar(32) | INDEX, NOT NULL | References `accounts.id` (seller) |
| product | varchar(32) | NOT NULL | References `products.id` |
| count | int | NOT NULL | Quantity purchased |
| total | decimal(12,2) | NOT NULL | Total price at purchase time |
| phone | varchar(12) | UNIQUE, NOT NULL | Phone number |
| address | varchar(512) | NOT NULL | Full address |
| zipcode | varchar(16) | NOT NULL | Postal code |
| status | tinyint | DEFAULT 5 | Order status (see Status section) |
| created_at | datetime | DEFAULT current_timestamp | Creation time |

---

### **transactions**
Tracks wallet transactions for each account.

| Column | Type | Attributes | Description |
|--------|------|-------------|--------------|
| id | varchar(32) | **PRIMARY KEY** | Transaction ID |
| wallet | varchar(32) | INDEX, NOT NULL | References `accounts.id` |
| amount | decimal(12,2) | NOT NULL | Transaction amount |
| type | tinyint | DEFAULT 0 | Transaction type (see Transaction Types) |
| status | tinyint | NOT NULL | Transaction status |
| created_at | datetime | DEFAULT current_timestamp | Creation time |

---

## 🧮 Enumerations

### **Roles**
| Code | Role |
|------|------|
| 10 | Customer |
| 20 | Seller |
| 30 | Admin |

### **Status**
| Code | Meaning |
|------|----------|
| 0 | OK |
| 1 | SUSPENDED |
| 2 | REMOVED |
| 3 | NOT_PAID |
| 4 | PAID |
| 5 | OPENED |
| 6 | CONFIRM |
| 7 | SEND |
| 8 | CLOSED |

### **Product Types**
| Code | Type |
|------|------|
| 0 | Ring |
| 1 | Necklace |
| 2 | Earring |

### **Transaction Types**
| Code | Type |
|------|------|
| 0 | BUY |
| 1 | CHARGE |
| 2 | EXCHANGE |

---

## 🧩 Notes
- All `id` fields are stored as `varchar(32)` unique identifiers.
- `created_at` automatically stores the record’s creation timestamp.
- The schema uses **snake_case** naming for all tables and columns.
- Every foreign key relationship is noted in parentheses.

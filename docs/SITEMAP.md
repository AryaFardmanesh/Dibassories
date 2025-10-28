# 🌐 Dibassories — Site Map & Page Overview

This document outlines the **site structure** and the **available actions** for each user role in the Dibassories online store project.

---

## 👥 User Roles

| Role | Description |
|------|-------------|
| **Customer** | Regular user who can browse, purchase, and manage their profile and cart. |
| **Seller** | Registered user with access to add, manage, and update their products. |
| **Admin** | Site administrator responsible for managing accounts, products, and orders. |

---

## 🗺️ Sitemap Overview

### 1. **Login**
- **Purpose:** Authenticate existing users.
- **Access:** Public (unauthenticated users).
- **Actions:**
  - Log in with username and password.
  - Redirect to role-specific dashboard (Customer → Homepage, Seller → Panel, Admin → Dashboard).

---

### 2. **Sign Up**
- **Purpose:** Register a new account.
- **Access:** Public (unauthenticated users).
- **Actions:**
  - Create a new account.

---

### 3. **Landing Page (Homepage)**
- **Purpose:** Display main site overview and featured products.
- **Access:** Public (all users).
- **Actions:**
  - Browse featured products.

---

### 4. **Products**
- **Purpose:** Show all available products.
- **Access:** Public (all users).
- **Actions:**
  - View product list.
  - Filter or search products by category, price.
  - Select product for detailed view.

---

### 5. **Product**
- **Purpose:** Display full information of a specific product.
- **Access:** Public (all users).
- **Actions (authenticated users):**
  - Add to cart / remove from cart.
  - Save product for later.

---

### 6. **Profile**
- **Purpose:** Display and manage user account details.
- **Access:** Authenticated users.
- **Actions:**
  - View and update account information.
  - View shopping cart.
  - Remove items from cart.
  - Checkout pruche cart (redirect to checkout page)

---

### 7. **Panel (Seller/Admin)**
- **Purpose:** Management area for product and order operations.
- **Access:** Authenticated user (Seller/Admin).
- **Actions:**
  - Add new product.
  - Edit or remove existing product.
  - View order information.
  - Update order status.

---

### 8. **Checkout**
- **Purpose:** Finalize and confirm purchases.
- **Access:** Authenticated user (Seller/Admin).
- **Actions:**
  - View shopping cart items.
  - Remove or update items.
  - Complete checkout process.

---

### 9. **Dashboard (Admin)**
- **Purpose:** Administration panel for managing the platform.
- **Access:** Authenticated user (Admin).

#### 📁 Subsections:

| Section | Description | Admin Actions |
|----------|--------------|----------------|
| **Accounts** | Manage all user accounts. | View, search, block users, remove users. |
| **Confirm Account** | Approve or reject Seller account requests. | Approve / reject. |
| **Products** | Display all listed products. | Filter, review, unconfirm or remove. |
| **Confirm Product** | Review and approve new products before publishing. | Approve / reject. |
| **Transactions** | View user transactions | View |
| **Orders** | Manage customer orders. | View and update order details. |

---

## ⚙️ Summary of User Actions

| Page | Customer | Seller | Admin |
|------|-----------|---------|--------|
| **Login / Sign Up** | ✅ | ✅ | ✅ |
| **Landing Page** | ✅ | ✅ | ✅ |
| **Products** | ✅ Filter / View | ✅ | ✅ |
| **Product** | ✅ Add / Remove / Save | ✅ Edit | ✅ Moderate |
| **Profile** | ✅ Manage Info / Cart | ✅ | ✅ |
| **Panel** | ❌ | ✅ Add / Edit / Orders | ✅ |
| **Checkout** | ✅ | ✅ | ✅ |
| **Dashboard** | ❌ | ❌ | ✅ Manage All |

---

# AgriAdvisory Hub

A full-stack web application that serves as a smart farming assistant — combining crop advisory, farmer registration, and an agricultural marketplace in a single responsive interface.

## What It Does

- Lets farmers register with their land and service details
- Displays agricultural products (seeds, fertilizers, tools) from a MySQL database, with a static fallback catalogue if the database is empty
- Provides a shopping cart that persists across pages using browser LocalStorage
- Delivers real-time UI feedback through a custom toast notification system (no browser alerts)

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML5, CSS3, JavaScript (ES6+) |
| Fonts | Inter — Google Fonts |
| Backend | PHP 8.x, MySQLi |
| Database | MySQL (via XAMPP) |
| Server | Apache (XAMPP local environment) |

## Project Files

```
agriadvisoryhub/
├── index.html          — Landing page with feature overview
├── register.html       — Farmer registration form
├── products.html       — Agricultural products marketplace
├── checkout.html       — Shopping cart and order review
├── style.css           — Complete design system (dark theme, glassmorphism, animations)
├── script.js           — All frontend logic (registration, products, cart, toasts)
├── db_connect.php      — MySQL database connection
├── register.php        — POST endpoint: saves farmer data to DB
├── get_products.php    — GET endpoint: returns products as JSON
├── delete_cart.php     — Server-side cart item deletion helper
├── images/             — Product images (generated, local)
│   ├── seeds_paddy.png
│   ├── fertilizer_npk.png
│   ├── garden_tools.png
│   ├── sprayer_pump.png
│   ├── drip_irrigation.png
│   └── soil_tester.png
├── README.md           — This file
├── PROJECT_REPORT.md   — Full project report and architecture
└── CODE_EXPLANATION.md — Line-by-line code documentation
```

## Product Catalogue (Static Fallback)

The site ships with 6 built-in agricultural products that render even without a database connection:

| Product | Price (INR) |
|---------|------------|
| Premium Paddy Seeds 1 kg | Rs. 249 |
| NPK Fertilizer 5 kg | Rs. 595 |
| Stainless Steel Hand Tool Set | Rs. 385 |
| Knapsack Sprayer 16 L | Rs. 990 |
| Drip Irrigation Kit (50 plants) | Rs. 1,250 |
| Digital Soil pH and Moisture Tester | Rs. 749 |

## How to Run

**Requirements**: XAMPP (Apache + MySQL + PHP)

```bash
# 1. Place the project in XAMPP web root
/Applications/XAMPP/xamppfiles/htdocs/agriadvisoryhub/

# 2. Start Apache and MySQL via XAMPP Control Panel

# 3. Create the database in phpMyAdmin
http://localhost/phpmyadmin

# 4. Run these SQL statements to set up tables:

CREATE DATABASE IF NOT EXISTS agriadvisory;
USE agriadvisory;

CREATE TABLE IF NOT EXISTS farmers (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  fullname   VARCHAR(255),
  email      VARCHAR(255),
  phone      VARCHAR(20),
  password   VARCHAR(255),
  address    TEXT,
  land_area  VARCHAR(50),
  service    VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS products (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  name   VARCHAR(255),
  price  DECIMAL(10,2),
  image  VARCHAR(500)
);

# 5. Open the site
http://localhost/agriadvisoryhub/
```

> The products page works without a database — the static fallback catalogue loads automatically if the server is unavailable or the products table is empty.

---

*Built for farmers, by farmers. AgriAdvisory Hub — 2026*

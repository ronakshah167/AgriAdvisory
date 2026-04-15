# 🚜 AgriAdvisory Hub — Complete Setup, Database & Deployment Guide

Welcome to the **AgriAdvisory Hub** — a premium digital ecosystem for modern farmers. This guide covers **everything**: prerequisites, manual database creation, viewing your data via phpMyAdmin, and deploying the application — all without running any scripts.

---

## 📌 Technology Stack

| Layer        | Technology                     |
| ------------ | ------------------------------ |
| **Frontend** | HTML, CSS, JavaScript          |
| **Backend**  | PHP (served via Apache/XAMPP)  |
| **Database** | MySQL (bundled with XAMPP)     |
| **Server**   | Apache HTTP Server (via XAMPP) |

---

## 🗄️ Database Overview

| Property              | Value                                              |
| --------------------- | -------------------------------------------------- |
| **Database Engine**   | MySQL (via XAMPP's bundled MariaDB)                |
| **Database Name**     | `agriadvisory`                                     |
| **Host**              | `localhost`                                        |
| **Port**              | `3306` (default MySQL port)                        |
| **Username**          | `root`                                             |
| **Password**          | *(empty — no password by default)*                 |
| **Management Tool**   | phpMyAdmin (bundled with XAMPP)                    |

### Tables

The database has **two main tables**:

#### 1. `farmers` — Stores registered user accounts

| Column       | Type                          | Description                         |
| ------------ | ----------------------------- | ----------------------------------- |
| `id`         | `INT AUTO_INCREMENT`          | Primary key                         |
| `fullname`   | `VARCHAR(255) NOT NULL`       | Farmer's full name                  |
| `email`      | `VARCHAR(255) NOT NULL UNIQUE`| Login email (must be unique)        |
| `phone`      | `VARCHAR(20)`                 | Phone number                        |
| `password`   | `VARCHAR(255) NOT NULL`       | Bcrypt-hashed password              |
| `address`    | `TEXT`                        | Farm/home address                   |
| `land_area`  | `VARCHAR(50)`                 | Size of farming land                |
| `service`    | `VARCHAR(100)`                | Preferred advisory service          |
| `created_at` | `TIMESTAMP`                   | Auto-set on registration            |

#### 2. `orders` — Stores marketplace checkout orders

| Column          | Type                          | Description                    |
| --------------- | ----------------------------- | ------------------------------ |
| `id`            | `INT AUTO_INCREMENT`          | Primary key                    |
| `customer_name` | `VARCHAR(255)`                | Buyer's name                   |
| `phone`         | `VARCHAR(20)`                 | Buyer's phone                  |
| `address`       | `TEXT`                        | Delivery address               |
| `items`         | `TEXT`                        | JSON string of ordered items   |
| `total`         | `DECIMAL(10,2)`               | Order total in ₹               |
| `status`        | `VARCHAR(50) DEFAULT 'pending'`| Order status                 |
| `created_at`    | `TIMESTAMP`                   | Auto-set on order placement    |

---

## 🛠️ Prerequisites

1. **Download & Install XAMPP** from [https://www.apachefriends.org](https://www.apachefriends.org/index.html)
2. Ensure you have a **modern web browser** (Chrome, Firefox, Edge, Safari)
3. No other software is needed — XAMPP bundles Apache, MySQL, PHP, and phpMyAdmin

---

## 🚀 Manual Deployment — Step by Step

### Step 1: Place the Project Files

Copy the entire `agriadvisoryhub` folder into XAMPP's web root:

| OS        | Path                                                        |
| --------- | ----------------------------------------------------------- |
| **macOS** | `/Applications/XAMPP/xamppfiles/htdocs/agriadvisoryhub`     |
| **Windows** | `C:\xampp\htdocs\agriadvisoryhub`                         |
| **Linux** | `/opt/lampp/htdocs/agriadvisoryhub`                         |

### Step 2: Start XAMPP Services

1. **Open XAMPP Control Panel**
   - **macOS**: Open `/Applications/XAMPP/manager-osx.app` (or search "XAMPP" in Spotlight)  
   - **Windows**: Open `C:\xampp\xampp-control.exe`
   - **Linux**: Run `sudo /opt/lampp/lampp start`

2. **Start these two modules**:
   - ✅ **Apache** — Click "Start" next to Apache
   - ✅ **MySQL** — Click "Start" next to MySQL

3. **Verify they are running**: Both should show a green indicator or "Running" status.

> [!IMPORTANT]
> Both Apache and MySQL **must** be running for the application to work. If MySQL fails to start, check if another MySQL instance is using port 3306.

### Step 3: Create the Database Manually via phpMyAdmin

Instead of running a setup script, you can create the database and tables entirely through the phpMyAdmin web interface.

#### 3a. Open phpMyAdmin

1. Open your browser
2. Navigate to: **http://localhost/phpmyadmin**
3. You will see the phpMyAdmin dashboard

#### 3b. Create the Database

1. Click the **"Databases"** tab at the top
2. In the **"Create database"** field, type: `agriadvisory`
3. Set the collation dropdown to: `utf8mb4_general_ci`
4. Click **"Create"**
5. ✅ You should see `agriadvisory` appear in the left sidebar

#### 3c. Create the `farmers` Table

1. Click on **`agriadvisory`** in the left sidebar to select it
2. Click the **"SQL"** tab at the top
3. Paste the following SQL and click **"Go"**:

```sql
CREATE TABLE IF NOT EXISTS farmers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    address TEXT,
    land_area VARCHAR(50),
    service VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. ✅ You should see a green success message: *"MySQL returned an empty result set"*

#### 3d. Create the `orders` Table

1. Still on the **"SQL"** tab (with `agriadvisory` selected)
2. Paste the following SQL and click **"Go"**:

```sql
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    items TEXT,
    total DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. ✅ You should see a green success message

#### 3e. Verify Everything is Set Up

1. Click **`agriadvisory`** in the left sidebar
2. You should see **both tables** listed:
   - `farmers`
   - `orders`
3. Click on each table name to see its structure (columns, types, etc.)

> [!TIP]
> You can also run both SQL statements at once by pasting them together (separated by a semicolon) into a single SQL query in the SQL tab.

### Step 4: Access the Application

Open your browser and go to:

👉 **http://localhost/agriadvisoryhub/index.html**

---

## 🔍 How to View & Manage Your Database (phpMyAdmin)

phpMyAdmin is a **web-based MySQL management tool** bundled with XAMPP. Here's how to use it:

### Opening phpMyAdmin

1. Make sure **MySQL is running** in XAMPP
2. Open your browser and go to: **http://localhost/phpmyadmin**
3. You will see the phpMyAdmin home screen with all databases listed on the left

### Viewing Your Data

| What you want to do                | How to do it                                                                                       |
| ---------------------------------- | -------------------------------------------------------------------------------------------------- |
| **See all databases**              | Look at the left sidebar — all databases are listed there                                          |
| **Open your database**             | Click `agriadvisory` in the left sidebar                                                           |
| **See all tables**                 | After selecting the database, the tables (`farmers`, `orders`) appear in the main area             |
| **View table structure (columns)** | Click a table name → Click the **"Structure"** tab                                                 |
| **Browse all data (rows)**         | Click a table name → Click the **"Browse"** tab — this shows all rows in a paginated table view    |
| **Search/filter data**             | Click a table name → Click the **"Search"** tab — set filters on any column                        |
| **Run custom SQL queries**         | Click the **"SQL"** tab → type your query → click **"Go"**                                         |
| **Export data (CSV/SQL)**          | Click a table → **Export** tab → choose format (CSV, SQL, etc.) → click **Go**                     |
| **Delete a specific row**          | In the **Browse** tab, click the red **"Delete"** link next to any row                             |
| **Edit a specific row**            | In the **Browse** tab, click the **"Edit"** link next to any row                                   |

### Useful SQL Queries You Can Run

Open the **SQL** tab in phpMyAdmin (with `agriadvisory` selected) and run any of these:

```sql
-- View all registered farmers
SELECT id, fullname, email, phone, land_area, service, created_at FROM farmers;

-- View all orders
SELECT * FROM orders ORDER BY created_at DESC;

-- Count total registered farmers
SELECT COUNT(*) AS total_farmers FROM farmers;

-- Count total orders
SELECT COUNT(*) AS total_orders FROM orders;

-- Find a specific farmer by email
SELECT * FROM farmers WHERE email = 'example@email.com';

-- View orders from today
SELECT * FROM orders WHERE DATE(created_at) = CURDATE();

-- View pending orders
SELECT * FROM orders WHERE status = 'pending';
```

---

## 📁 Project File Reference

| File                | Purpose                                           |
| ------------------- | ------------------------------------------------- |
| `index.html`        | Main homepage / landing page                      |
| `register.html`     | Farmer registration form                          |
| `login.html`        | Farmer login form                                 |
| `privacy.html`      | Privacy & data preference management              |
| `products.html`     | Product marketplace listing                       |
| `checkout.html`     | Order checkout page                               |
| `soil.html`         | Soil health analysis tool                         |
| `weather.html`      | Weather advisory tool                             |
| `advisory.html`     | Crop advisory page                                |
| `style.css`         | Full design system (earthy, glassmorphism)         |
| `script.js`         | Frontend logic (cart, animations, API calls)       |
| `db_connect.php`    | Database connection config (host, user, password) |
| `setup_db.php`      | Automated DB setup script (optional alternative)  |
| `register.php`      | Backend: handles farmer registration              |
| `login.php`         | Backend: handles farmer login & sessions          |
| `place_order.php`   | Backend: saves checkout orders to DB              |
| `get_products.php`  | Backend: fetches product data as JSON             |
| `delete_cart.php`   | Backend: removes items from cart                  |

---

## 🔗 Database Connection Details (for reference)

The file `db_connect.php` contains the connection configuration:

```php
<?php
$conn = new mysqli("localhost", "root", "", "agriadvisory");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
```

| Parameter    | Value         | Notes                                     |
| ------------ | ------------- | ----------------------------------------- |
| **Host**     | `localhost`   | Always localhost for XAMPP                 |
| **Username** | `root`        | Default XAMPP MySQL user                  |
| **Password** | *(empty)*     | No password by default                    |
| **Database** | `agriadvisory`| Must be created before running the app    |

> [!WARNING]
> The default setup uses `root` with no password. This is fine for local development but **never** deploy to a public server with these credentials. For production, create a dedicated MySQL user with a strong password.

---

## ❓ Troubleshooting

| Problem                              | Solution                                                                                |
| ------------------------------------ | --------------------------------------------------------------------------------------- |
| **"Connection Failed" error**        | Ensure MySQL is started in XAMPP Control Panel                                          |
| **phpMyAdmin won't load**            | Check that both Apache and MySQL are running                                            |
| **Database `agriadvisory` not found**| Follow Step 3b above to create it manually                                              |
| **Registration fails**               | Check if the email is already registered (duplicate emails are blocked)                 |
| **Tables don't exist**               | Re-run the SQL in Steps 3c and 3d via phpMyAdmin                                       |
| **Port 3306 already in use**         | Stop any other MySQL instances, or change XAMPP MySQL port in `my.ini`/`my.cnf`         |
| **Welcome bar not showing**          | Accept the cookie consent banner at the bottom of the page                              |
| **Changes not reflecting**           | Clear browser cache or hard refresh (`Cmd+Shift+R` on Mac / `Ctrl+F5` on Windows)      |
| **Apache won't start (port 80)**     | Stop any other web servers (like Nginx) or change Apache port in `httpd.conf`           |

---

## 🧪 Quick Verification Checklist

After completing all steps above, verify everything works:

- [ ] XAMPP Apache is running (green indicator)
- [ ] XAMPP MySQL is running (green indicator)
- [ ] `http://localhost/phpmyadmin` loads successfully
- [ ] Database `agriadvisory` exists in phpMyAdmin sidebar
- [ ] Tables `farmers` and `orders` exist inside `agriadvisory`
- [ ] `http://localhost/agriadvisoryhub/index.html` loads the homepage
- [ ] Registering a new farmer at `register.html` succeeds
- [ ] The new farmer appears in the `farmers` table in phpMyAdmin (Browse tab)
- [ ] Logging in at `login.html` with the registered credentials works
- [ ] Placing an order via `checkout.html` creates a row in the `orders` table

---

**Built with ❤️ for sustainable farming.**  
*AgriAdvisory Hub — From Soil to Harvest, We've Got You Covered.*

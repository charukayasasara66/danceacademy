# 🎭 Academy Management System (AMS)

A full-stack web application designed for the **Dayan Kahandawala Academy of Dance** to manage student enrollments, class scheduling, and financial reporting.

![Project Status](https://img.shields.io/badge/Status-Completed-success)
![Tech Stack](https://img.shields.io/badge/PHP-8.0+-777bb4)
![Database](https://img.shields.io/badge/MySQL-8.0-4479a1)

## 🌟 Key Features
* **Role-Based Access Control (RBAC):** Distinct dashboards for Directors (Admin), Staff, and Students.
* **Financial Reporting:** Automated generation of monthly income reports using SQL Joins.
* **Class Scheduling:** Dynamic filtering of classes by Branch (Horana, Gampaha, Kaduwela) and Grade.
* **Student Portal:** Secure view for students to check their own payment history and due dates.
* **Secure Architecture:**
    * Protected against SQL Injection using **Prepared Statements**.
    * **IDOR Protection** prevents students from viewing others' data.
    * Session-based authentication with password hashing.

## 🛠️ Installation & Setup

### 1. Prerequisites
* A local server (XAMPP, WAMP) or a live cPanel host.
* PHP 7.4 or higher.
* MySQL database.

### 2. Database Setup
1.  Create a new database (e.g., `academy_db`).
2.  Import the provided `database_backup.sql` file.
    * *Note: This SQL file contains dummy data for demonstration purposes.*

### 3. Configuration
1.  Locate the file `db_connect.sample.php`.
2.  Rename it to **`db_connect.php`**.
3.  Open the file and update your credentials:
    ```php
    $servername = "localhost";
    $username   = "YOUR_DB_USER";
    $password   = "YOUR_DB_PASS";
    $dbname     = "academy_db";
    ```

### 4. Admin Login (Demo)
* **Username:** `admin`
* **Password:** (You will need to create a user manually in the database or use the registration form if enabled).

## 📂 Project Structure
* `/api` - PHP endpoints for AJAX requests (Search, Payments, Reports).
* `/css` - Custom styling with a Dark/Gold premium theme.
* `/dashboard` - Role-specific views.
* `db_connect.sample.php` - Template for database connection.

---
*Built by [Your Name] - 2026*
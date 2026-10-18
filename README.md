# GemDesk - Jewelry Shop Management System

A custom MVC Web Application built using PHP 7.4, PDO, MySQL, and vanilla CSS for managing jewelry store operations.

## Features
- **Authentication**: Secure login system with session management.
- **Dashboard**: Live statistics and low-stock inventory alerts.
- **Category Management**: Create, view, and safely manage product categories.
- **Product & Inventory Management**: Full CRUD operations with search, filtering, and stock monitoring.
- **Customer Directory**: Customer profile management and search.
- **POS / Sales Checkout**: Multi-item cart checkout with atomic database transactions (`beginTransaction`/`commit`/`rollBack`) and automatic stock reduction.
- **Invoices & History**: Print-ready sales invoices and transaction logs.
- **Sales Reports**: Custom date-range revenue filtering and analytics.

## Tech Stack
- **Backend**: PHP 7.4 (Vanilla, Custom MVC Architecture)
- **Database**: MySQL (PDO Extension)
- **Frontend**: HTML5, CSS3 (Luxury Palette Design), Vanilla JavaScript
- **Server**: WAMP Server (Apache)

## Installation & Setup Instructions
1. Copy the `GemDesk` folder to your WAMP server directory: `C:\wamp64\www\GemDesk`.
2. Open phpMyAdmin (`http://localhost/phpmyadmin`) and create a new database named `jewelry_shop_db`.
3. Import the `database.sql` file provided in the project root into `jewelry_shop_db`.
4. Start WAMP services and navigate to `http://localhost/GemDesk/` in your browser.
5. **Default Admin Login Credentials**:
   - **Username**: `admin`
   - **Password**: `admin123`
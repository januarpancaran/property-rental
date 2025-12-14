<p align="center">
  <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a>
</p>

<h1 align="center">Property Rental Platform</h1>

<p align="center">
  <strong>A modern property management and rental platform built with Laravel</strong>
</p>

<p align="center">
  <a href="https://github.com/januarpancaran/property-rental/blob/main/LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="MIT License"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-v8.2%2B-blue.svg" alt="PHP v8.2+"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-Latest-red.svg" alt="Laravel"></a>
  <a href="#"><img src="https://img.shields.io/badge/Node.js-v18%2B-green.svg" alt="Node.js v18+"></a>
</p>

---

## 📋 About

This is a comprehensive property rental platform that enables landlords and tenants to manage bookings, payments, contracts, and maintenance requests. The platform includes integrated payment processing, real-time notifications, and a user-friendly interface for property management.

## ✨ Features

- **Property Management** - Create and manage properties with photos and details
- **Booking System** - Reserve properties with availability calendar
- **Payment Integration** - Secure payment processing and transaction tracking
- **Contracts** - Digital contract management for bookings
- **Maintenance Requests** - Efficient maintenance scheduling and tracking
- **Notifications** - Real-time email notifications for bookings, payments, and maintenance
- **User Roles** - Role-based access control (Admin, Landlord, Tenant)

## 🚀 Quick Start

### Prerequisites

Before getting started, ensure you have the following installed:

- **PHP** >= v8.2
- **Composer** - PHP package manager
- **Node.js** >= v18.0
- **MySQL** - Database server

### Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/januarpancaran/property-rental.git
    cd property-rental
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Set up environment configuration**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure your `.env` file**

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=property_db
    DB_USERNAME=root
    DB_PASSWORD=

    # Payment Gateway Configuration
    PAYMENT_API_KEY=your_api_key
    PAYMENT_BASE_URL=https://payment-dummy.doovera.com/api/v1
    PAYMENT_WEBHOOK_SECRET=your_webhook_secret
    PAYMENT_EXPIRED_HOURS=24
    ```

5. **Run database migrations**

    ```bash
    php artisan migrate:fresh --seed
    ```

6. **Create storage link**

    ```bash
    php artisan storage:link
    ```

7. **Start the development servers**

    Option A - Run commands separately:

    ```bash
    npm run dev          # Frontend build
    php artisan serve    # Laravel server
    php artisan queue:work  # Queue worker
    ngrok http 8000      # Expose local server (for webhooks)
    ```

    Option B - Run all at once:

    ```bash
    npx concurrently "npm run dev" "php artisan serve" "php artisan queue:work" "ngrok http 8000"
    ```

    Your application will be available at `http://localhost:8000`

## 🔐 Authentication & Roles

The platform uses role-based access control:

- **Admin** - Full platform management
- **Landlord** - Manage properties and bookings
- **Tenant** - Browse and book properties

## 💳 Payment Integration

The platform integrates with a payment gateway for secure transactions. Configure your payment credentials in the `.env` file.

## 📧 Notifications

Automated email notifications are sent for:

- Booking confirmations
- Payment receipts
- Maintenance updates
- Contract status changes

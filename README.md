## 🏠 Sakani — Apartment Booking Application

> Apartment rental booking platform built with **Laravel** (backend + Filament admin dashboard) and a **mobile application** for tenants and apartment owners.

---

### 📖 About the Project

**Sakani** is a comprehensive residential apartment booking platform. It connects **tenants** looking for apartments to rent with **apartment owners** who want to list their properties — all through a seamless mobile experience backed by a powerful web-based admin panel.

The platform covers the full booking lifecycle: from user registration and identity verification, through browsing and filtering listings, to booking management, cancellations, modifications, and reviews. Every action in the system goes through a structured approval workflow — registrations are reviewed by the system Admin, and booking requests must be approved by apartment owners before they are considered confirmed.

---

### ✨ Features

#### 🔐 Authentication & User Management
- Mobile registration via **phone number** as either a **Tenant** or **Apartment Owner**
- Required personal profile completion: first name, last name, profile photo, date of birth, and ID photo
- Login / Logout from the mobile app
- All new registrations require **Admin approval** before the user can access the app

#### 🏢 Apartment Browsing
- Browse apartments and view full specifications
- Filter by **governorate**, **city**, **price**, and other custom criteria

#### 📅 Booking System
- Book an apartment for a specific period with **no scheduling conflicts**
- Apartment owner must **approve** booking requests before they are confirmed
- Modify existing bookings (requires owner approval)
- Cancel bookings
- View all bookings: past, current, and cancelled

#### ⭐ Rates
#### 🔔 Notifications 
#### 🌍 Multi-language Support 
#### 🌙 Dark / Light Mode
#### ❤️ Favorites 
#### 🖥️ Admin Dashboard (Filament)

---

### 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP) |
| Admin Dashboard | Laravel Filament |
| Mobile App | *(Flutter)* |
| Database | MySQL |
| Auth | Laravel Sanctum  |
| Testing | Postman |

---

### 🚀 Getting Started

#### Prerequisites
- PHP >= 8.1
- Composer
- pip
- MySQL

#### Installation

```bash
# 1. Clone the repository
git clone https://github.com/Hala-Erksousi/Sakani.git
cd Sakani/Sakani

# 2. Install PHP dependencies
composer install

# 3. Set up environment
php artisan key:generate

# 4. Configure your database,then run migrations
php artisan migrate --seed

# 5. Start the development server
php artisan serve
```

#### Access the Admin Dashboard
```
URL: http://localhost:8000/admin
```
> The admin panel is powered by **Laravel Filament** and allows the system admin to manage users, approve registrations, and oversee all platform activity.

---

### 👥 User Roles

| Role | Description |
|---|---|
| **Admin** | Manages the platform via Filament dashboard. Approves/rejects registrations and manages users. |
| **Tenant** | Browses, filters, and books apartments. Can review, cancel, and message owners. |

---

Have ideas to improve Sakani? Don't hesitate to reach out or submit a pull request — all contributions are welcome!

---

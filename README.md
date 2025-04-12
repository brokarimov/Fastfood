<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">🍔 FastFood Management System</h1>

<p align="center">
  Laravel • Livewire • MySQL • GitHub Actions • AdminLTE
</p>

---

## 📝 About the Project

A real-time restaurant and staff management system. Orders are taken by waiters, prepared by chefs, and tracked step-by-step. Includes attendance tracking and a salary calculation system based on work time or KPI performance.

---

## 🔑 Authentication

- Login only (for authorized employees)
- Role and Permission system (Admin / Chef / Waiter)
- Attendance recorded on login/logout

---

## 🧾 Order Workflow

- Waiters place orders by adding items to a cart
- Quantity can be adjusted using `+` / `–` buttons
- Total amount is calculated dynamically
- Order is sent to the kitchen (real-time)
- Chefs mark each item as "Ready"
- When all items are ready, the status changes automatically
- Waiters deliver completed orders

---

## ⏱️ Attendance System

- Daily presence auto-recorded on login
- Logout marks the end of shift
- Admins can correct attendance manually if needed
- Indicators:
  - ✅ Green checkmark = full shift
  - ✅ + number = extra hours
  - ❌ Red = incomplete shift
  - ❌ – number = missing hours
  - ⚠️ Zebra icon = late arrival

---

## 💵 Salary Module

- **Fixed Salary**: Penalized for lateness or missed time
- **KPI Based**: Calculated from total orders handled

---

## 🧩 CRUD Features

- 🍔 Food Categories
- 🥘 Foods
- 👥 Departments
- 👨 Employees
- 👤 Users

---

## 📈 Reports & Filters

- Filter by date for attendance and salary reports
- Order status updated in real-time
- Role-based dashboard views

<p float="left">
  <img src="./screenshots/Screenshot 2025-04-13 050452.png" width="48%" />
  <img src="./screenshots/Screenshot 2025-04-13 053428.png" width="48%" />
  <img src="./screenshots/Screenshot 2025-04-13 051254.png" width="48%" />
  <img src="./screenshots/Screenshot 2025-04-13 051350.png" width="48%" />
  <img src="./screenshots/Screenshot 2025-04-13 052854.png" width="48%" />
  <img src="./screenshots/Screenshot 2025-04-13 052910.png" width="48%" />
  <img src="./screenshots/Screenshot 2025-04-13 052917.png" width="48%" />
    
</p>

---

## ⚙️ Technologies Used

- Laravel
- Livewire
- MySQL
- Bootstrap
- AdminLTE
- Git / GitHub Actions

---

## 🚀 Getting Started

```bash
git clone https://github.com/your-username/fastfood-management.git
cd fastfood-management

composer install

cp .env.example .env
php artisan key:generate

php artisan migrate --seed

php artisan serve

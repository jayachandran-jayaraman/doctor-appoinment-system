**Doctor-Patient Appointment System**

A secure, role-based web application for managing doctor-patient appointments, built with PHP (CodeIgniter 3), MySQL, and JavaScript.

## Tech Stack

- **Backend:** PHP CodeIgniter (MVC Architecture)
- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5
- **Database:** MySQL

## Roles

| Role | Description |
|------|-------------|
| **Admin** | Manages doctors, patients, and all appointments |
| **Doctor** | Views scheduled appointments and updates status |
| **Patient** | Registers, books, and tracks appointments |

## Features

- Secure login with role-based access control
- Patient registration and profile management
- Doctor listing and appointment booking
- Appointment status tracking (Pending / Confirmed / Cancelled / Rescheduled)
- Admin dashboard to manage users and appointments
- Doctor dashboard to manage assigned appointments

## Setup

### 1. Database

```bash
mysql -u your_user -p < database.sql
```

Update credentials in `application/config/database.php` if needed.

### 2. Run the application

Point your web server document root to the project folder, or use PHP built-in server:

```bash
php -S localhost:8000
```

Visit: `http://localhost:8000`

## Default Routes

| URL | Description |
|-----|-------------|
| `/` | Landing page |
| `/index/login` | Patient login |
| `/index/signup` | Patient registration |
| `/login` | Admin / Doctor login |
| `/admin/doctor_signup` | Admin / Doctor registration |

## Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@medcare.com | admin123 |
| Doctor | doctor@medcare.com | doctor123 |
| Patient | patient@medcare.com | patient123 |

## Project Structure

```
application/
├── controllers/
│   ├── Admin.php           # Admin & Doctor auth & dashboards
│   ├── Admincontroller.php # Admin data views (patients, doctors, appointments)
│   ├── Index.php           # Patient portal
│   ├── Patient_register.php# Appointment booking
│   └── Doctor_controller.php# Appointment status updates
├── models/
│   ├── User_model.php
│   ├── Doctor_model.php
│   └── Patient_model.php
└── views/
    ├── admin/pages/        # Admin & Doctor views
    ├── user/               # Patient views
    └── template/           # Shared layouts
```

# 🥔 AgriStack — Irish Potato Marketplace
Built for educational purposes — Musanze, Rwanda, 2026.

# Web-Ass-2-group-3-II-A

> **Connecting Musanze farmers directly to Rwanda's bulk buyers.**

AgriStack is a cooperative harvest listing and bulk order management system built for Irish potato farmers and cooperatives in Musanze District, Rwanda. It eliminates middlemen, enables transparent pricing, and connects farmers directly with aggregators and bulk buyers.

---

## 🗂️ Table of Contents
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Setup Instructions](#setup-instructions)
- [Database Import Guide](#database-import-guide)
- [Demo Accounts](#demo-accounts)
- [Team & Git](#team--git)

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🔐 Role-based Auth | Farmer, Buyer, Admin with separate dashboards |
| 📋 Harvest Listings | Full CRUD for cooperative harvest listings |
| 📦 Bulk Bookings | Workflow: Pending → Approved → Collected |
| 💰 Live Estimator | JavaScript qty × price total calculator |
| 📊 Admin Dashboard | Today's listings, booked value, top sectors |
| 🔍 Audit Log | Complete table of all platform actions |
| 📱 Responsive UI | Works on mobile, tablet, desktop |

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.0+ (MVC, no framework) |
| Database | MySQL 8.0 / MariaDB 10.4 |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Fonts | Google Fonts (Fraunces + DM Sans) |
| Server | Apache (XAMPP / Laragon / WAMP) |

---

## 📁 Project Structure

```
agristack/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── ListingController.php
│   │   ├── BookingController.php
│   │   ├── AdminController.php
│   │   └── DashboardController.php
│   ├── models/
│   │   ├── User.php
│   │   ├── Listing.php
│   │   ├── Booking.php
│   │   └── AuditLog.php
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── listings/
│       ├── bookings/
│       ├── farmer/
│       ├── buyer/
│       └── admin/
├── config/
│   └── database.php
├── index.php
├── assets/
│   ├── css/style.css
│   └── js/main.js
├── database/
│   └── schema.sql
├── docs/
│   ├── problem.md
│   ├── stakeholders.md
│   ├── user-stories.md
│   ├── scope.md
│   ├── uistyle.md
│   ├── page-map.md
│   ├── testing.md
│   ├── AI-usage.md
│   └── wireframes/
└── README.md
```

---

## ⚙️ Setup Instructions

### Prerequisites
- XAMPP, Laragon, or any Apache + PHP 8.0+ + MySQL stack
- PHP extensions: `mysqli`, `session`
- A web browser (Chrome/Firefox recommended)

### Step 1 — Clone / Copy the Project

```bash
git clone https://github.com/your-team/agristack.git
```

Copy to your web root:

```
XAMPP: C:/xampp/htdocs/agristack
Laragon: C:/laragon/www/agristack
```

---

### Step 2 — Import the Database

Follow the instructions in **Database Import Guide** below.

---

### Step 3 — Configure Database Connection

Open:

```
config/database.php
```

Update:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'agristack_db');
```

---

### Step 4 — Update BASE_URL

```php
define('BASE_URL', 'http://localhost/agristack/public');
```

---

### Step 5 — Start Apache & MySQL

Start your **XAMPP/Laragon/WAMP** control panel and ensure both services are running.

---

### Step 6 — Open the Application

```
http://localhost/agristack/public/index.php
```

---

## 🗄️ Database Import Guide

### Option A — phpMyAdmin (Recommended)

1. Open `http://localhost/phpmyadmin`
2. Create database **agristack_db**
3. Select the database
4. Click **Import**
5. Upload `database/schema.sql`
6. Click **Go**

---

### Option B — MySQL Command Line

```bash
mysql -u root -p
CREATE DATABASE agristack_db;
EXIT;

mysql -u root -p agristack_db < database/schema.sql
```

---

## 👤 Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@agristack.rw | password |
| Farmer | jean@agristack.rw | password |
| Farmer | diane@agristack.rw | password |
| Buyer | robert@agristack.rw | password |
| Buyer | agnes@agristack.rw | password |

⚠️ Change passwords in production.

---

# 👥 Team & Git

## Git Workflow

- Minimum **25 commits**
- Each member minimum **3 commits**
- Branch strategy: `main` + feature branches
- Commit message examples:
  - `feat: add harvest listing`
  - `fix: booking quantity validation`
  - `docs: update README`

---

## 👨‍💻 Group Members & Roles

| Name | Registration Number | Role | Responsibilities |
|-----|-----|-----|-----|
| **Gihozo Patience** | 25/30654 | Frontend Developer | UI design, CSS styling, responsive pages |
| **Nayituriki Simeon** | 25/30692 | Tech Lead & Backend Developer | MVC architecture, routing system, database logic |
| **Iyabose Ishimwe Nicole** | 25/30365 | QA & Documentation | Testing, documentation, reporting |
| **Umurerwa Alliance** | 25/30681 | Backend Developer | Controllers, authentication, admin features |
| **Dushimimana Salme** | 25/28419 | UI/UX Designer | Interface design, usability improvements |
| **Gafar Mouatsm Babikir** | 25/28635 | Full Stack Developer | Booking system, dashboard statistics |

---

## 🌐 Live Deployment

Live URL:

```
https://agristack.your-host.com
```

Hosting options:
- InfinityFree
- Hostinger
- Railway

---

## 📄 License

Built for **educational purposes**  
Musanze District, Rwanda — **2026**
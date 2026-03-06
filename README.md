# 🥔 AgriStack — Irish Potato Marketplace

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
- [Screenshots](#screenshots)
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
│   ├── controllers/          # Business logic
│   │   ├── AuthController.php
│   │   ├── ListingController.php
│   │   ├── BookingController.php
│   │   ├── AdminController.php
│   │   └── DashboardController.php
│   ├── models/               # Database queries (prepared statements)
│   │   ├── User.php
│   │   ├── Listing.php
│   │   ├── Booking.php
│   │   └── AuditLog.php
│   └── views/                # HTML templates (no SQL here)
│       ├── layouts/          # header.php, footer.php, sidebar.php
│       ├── auth/             # login.php, register.php
│       ├── listings/         # index, show, create, edit
│       ├── bookings/         # index, create
│       ├── farmer/           # dashboard.php
│       ├── buyer/            # dashboard.php
│       └── admin/            # dashboard, listings, orders, users, audit
├── config/
│   └── database.php          # DB config + singleton connection
├── public/
│   └── index.php             # Front controller / router
├── assets/
│   ├── css/style.css         # Full stylesheet
│   └── js/main.js            # Live estimator + UI interactions
├── database/
│   └── schema.sql            # Full schema + seed data
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
# If using Git:
git clone https://github.com/your-team/agristack.git

# Copy to your web root:
# XAMPP: C:/xampp/htdocs/agristack
# Laragon: C:/laragon/www/agristack
```

### Step 2 — Import the Database
See [Database Import Guide](#database-import-guide) below.

### Step 3 — Configure Database Connection
Open `config/database.php` and update:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // your MySQL username
define('DB_PASS', '');            // your MySQL password
define('DB_NAME', 'agristack_db');
```

### Step 4 — Update BASE_URL
In `config/database.php`, set your base URL:
```php
define('BASE_URL', 'http://localhost/agristack/public');
```

### Step 5 — Start Apache & MySQL
Start your XAMPP/Laragon/WAMP control panel and ensure both Apache and MySQL are running.

### Step 6 — Open the Application
Navigate to: `http://localhost/agristack/public/index.php`

---

## 🗄️ Database Import Guide

### Option A — phpMyAdmin (Recommended)
1. Open `http://localhost/phpmyadmin`
2. Click **New** to create a database named `agristack_db`
3. Select `agristack_db`, click the **Import** tab
4. Click **Choose File**, select `database/schema.sql`
5. Click **Go** / **Import**

### Option B — MySQL Command Line
```bash
mysql -u root -p
# Enter your password
CREATE DATABASE agristack_db;
EXIT;

mysql -u root -p agristack_db < database/schema.sql
```

### Option C — TablePlus / DBeaver
1. Connect to `localhost:3306`
2. Create database `agristack_db`
3. Run SQL file: `database/schema.sql`

---

## 👤 Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@agristack.rw | password |
| Farmer | jean@agristack.rw | password |
| Farmer | diane@agristack.rw | password |
| Buyer | robert@agristack.rw | password |
| Buyer | agnes@agristack.rw | password |

> ⚠️ **Note:** The seed data uses `password` as the password for all demo accounts. In production, change all passwords immediately.

---

## 👥 Team & Git

### Git Workflow
- Minimum **25 commits** with meaningful messages
- Every team member minimum **3 commits**
- Branch strategy: `main` (stable) + feature branches
- Commit message format: `feat: add listing approval`, `fix: booking qty validation`, `docs: add user stories`

### Team Roles
| Member | Role | Responsibilities |
|--------|------|-----------------|
| Member 1 | Tech Lead | MVC architecture, routing, models |
| Member 2 | Frontend | CSS, views, responsive design |
| Member 3 | Backend | Controllers, auth, admin features |
| Member 4 | QA/Docs | Testing, documentation, deployment |
| Member 5 | Full Stack | Booking system, dashboard stats |

---

## 🌐 Live Deployment
**Live URL:** [https://agristack.your-host.com](https://agristack.your-host.com)

*Deployed on: InfinityFree / Hostinger / Railway (update with actual URL)*

---

## 📄 License
Built for educational purposes — Musanze, Rwanda, 2024.

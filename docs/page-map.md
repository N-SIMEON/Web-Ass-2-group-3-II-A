# Page Map — AgriStack

## URL Structure
All routes use `public/index.php?page=X&action=Y`

---

## Route Map

```
/ (index.php)
├── ?page=login                    — Login form
├── ?page=register                 — Registration form
├── ?page=logout                   — Logout (redirect)
│
├── ?page=dashboard                — Role-based dashboard
│   ├── (farmer)  → farmer/dashboard.php
│   └── (buyer)   → buyer/dashboard.php
│
├── ?page=listings
│   ├── (default)                  — Listing index (farmer: own; buyer: approved)
│   ├── &action=show&id=N          — Listing detail view
│   ├── &action=create             — New listing form (farmer only)
│   ├── &action=store [POST]       — Save new listing
│   ├── &action=edit&id=N          — Edit form (farmer own only)
│   ├── &action=update [POST]      — Save changes
│   └── &action=delete&id=N       — Delete listing (farmer own, non-approved)
│
├── ?page=bookings
│   ├── (default)                  — Bookings list
│   ├── &action=create&listing_id=N — New booking form (buyer only)
│   ├── &action=store [POST]       — Save booking
│   ├── &action=cancel&id=N       — Cancel pending booking (buyer)
│   └── &action=collect&id=N      — Mark approved booking collected (buyer)
│
└── ?page=admin                    — Admin only
    ├── (default)                  — Admin dashboard
    ├── &action=listings           — All listings review
    ├── &action=approve&id=N      — Approve listing
    ├── &action=reject&id=N       — Reject listing
    ├── &action=orders             — All orders review
    ├── &action=approve-order&id=N — Approve booking
    ├── &action=users              — User management
    └── &action=audit              — Audit log
```

---

## Page Descriptions

| Page | Access | Description |
|------|--------|-------------|
| Login | Public | Username/password login form |
| Register | Public | Role-based registration (Farmer or Buyer) |
| Dashboard | Auth | Role-specific dashboard with stats |
| Listings Index | Auth | Grid/table of listings (role-filtered) |
| Listing Show | Auth | Full listing detail with booking CTA |
| Create Listing | Farmer | Form with live value estimator |
| Edit Listing | Farmer | Pre-filled edit form |
| Bookings Index | Buyer/Admin | Orders table with status filter |
| Create Booking | Buyer | Order form with live total estimator |
| Admin Dashboard | Admin | Platform-wide stats + quick actions |
| Admin Listings | Admin | Approve/reject listings table |
| Admin Orders | Admin | Approve orders table |
| Admin Users | Admin | User registry table |
| Admin Audit | Admin | Full audit log table |

---

## Navigation Flow Diagrams

### Farmer Flow
```
Login → Farmer Dashboard → Create Listing → (Admin Approves) → Listing Live
                         → View My Listings → Edit/Delete (if pending)
```

### Buyer Flow
```
Login → Buyer Dashboard → Browse Market → View Listing → Book Now → My Orders → Mark Collected
```

### Admin Flow
```
Login → Admin Dashboard → Review Listings → Approve/Reject
                        → Review Orders   → Approve
                        → View Users
                        → View Audit Log
```

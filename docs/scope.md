# Scope & Requirements — AgriStack

## In Scope (Phase 1)

### Functional Requirements

| ID | Feature | Priority |
|----|---------|---------|
| FR-01 | User registration (farmer, buyer) | Must Have |
| FR-02 | User login with role-based routing | Must Have |
| FR-03 | Harvest listing CRUD (farmer) | Must Have |
| FR-04 | Listing approval workflow (admin) | Must Have |
| FR-05 | Bulk booking request (buyer) | Must Have |
| FR-06 | Booking approval workflow (admin) | Must Have |
| FR-07 | Booking status tracking: Pending → Approved → Collected | Must Have |
| FR-08 | Farmer dashboard with listing stats | Must Have |
| FR-09 | Buyer dashboard with order stats | Must Have |
| FR-10 | Admin dashboard with platform stats | Must Have |
| FR-11 | Today's listings counter | Must Have |
| FR-12 | Total booked value display | Must Have |
| FR-13 | Top pickup sectors visualization | Must Have |
| FR-14 | Live JS total estimator (qty × price) on booking form | Must Have |
| FR-15 | Admin audit log table | Must Have |
| FR-16 | Listing search/filter by status | Should Have |
| FR-17 | Booking cancellation (buyer) | Should Have |
| FR-18 | Mark booking as collected (buyer) | Must Have |

---

## Out of Scope (Future Phases)

- Mobile native app (iOS/Android)
- SMS/WhatsApp notifications for approval updates
- Online payment integration (MTN Mobile Money)
- GPS-based pickup tracking
- Harvest quality photo upload and verification
- Price analytics and market trend charts
- Cooperative management tools (member tracking, financials)
- Multi-language support (Kinyarwanda, French)
- Integration with Rwanda Agriculture Board (RAB) database
- Escrow/payment holding functionality

---

## Non-Functional Requirements

### Performance
- NFR-01: Page load time < 3 seconds on 3G connection
- NFR-02: Database queries must use prepared statements (MySQLi)
- NFR-03: Application must handle 100 concurrent users without degradation

### Security
- NFR-04: All passwords hashed with bcrypt (PASSWORD_BCRYPT)
- NFR-05: All SQL queries use MySQLi prepared statements (prevent SQL injection)
- NFR-06: All user input sanitized with `htmlspecialchars()` on output (prevent XSS)
- NFR-07: Role-based access control enforced on all routes
- NFR-08: Session-based authentication with proper session management

### Usability
- NFR-09: Mobile-responsive design (works on 320px+ screen widths)
- NFR-10: Accessible: uses semantic HTML, ARIA labels, readable font sizes (min 14px)
- NFR-11: Consistent UI: same navigation, color scheme, and component patterns across all views
- NFR-12: Error messages must be clear, specific, and actionable

### Reliability
- NFR-13: Graceful error handling for database failures
- NFR-14: Audit log must capture all significant user actions
- NFR-15: Status workflow transitions must be enforced (no skipping steps)

### Maintainability
- NFR-16: MVC architecture with strict separation of concerns
- NFR-17: No SQL queries in views
- NFR-18: Reusable layout partials (header, footer, sidebar)
- NFR-19: Minimum 25 git commits showing team collaboration

### Compatibility
- NFR-20: Must work in Chrome, Firefox, Safari (latest 2 versions)
- NFR-21: PHP 8.0+ required; MySQL 5.7+ / MariaDB 10.4+

---

## Constraints
- Platform must be in English (localization out of scope for v1)
- No cloud hosting budget; must deploy on free-tier hosting (Hostinger, InfinityFree, or local XAMPP)
- Development timeline: 4 weeks
- Team size: 3–5 members

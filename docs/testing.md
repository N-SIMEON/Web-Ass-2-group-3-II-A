# Testing Document — AgriStack

## Testing Strategy
- **Type:** Manual functional testing + unit-level code review
- **Environment:** XAMPP (PHP 8.1, MySQL 8.0, Apache), Chrome 122
- **Testers:** Full development team
- **Test Date:** March 2024

---

## Test Cases

### Authentication Module

| TC# | Test Case | Precondition | Steps | Expected Result | Status |
|-----|-----------|-------------|-------|----------------|--------|
| TC-01 | Valid farmer login | User registered with role=farmer | 1. Go to /login<br>2. Enter valid email + password<br>3. Click Sign In | Redirected to farmer dashboard; role chip shows "farmer" | ✅ PASS |
| TC-02 | Invalid password login | User exists | 1. Enter correct email<br>2. Enter wrong password<br>3. Click Sign In | Error message: "Invalid email or password." shown | ✅ PASS |
| TC-03 | Valid admin login | Admin account exists | 1. Login as admin@agristack.rw<br>2. Submit form | Redirected to admin dashboard | ✅ PASS |
| TC-04 | Register with duplicate email | Email already in DB | 1. Fill registration form<br>2. Use existing email<br>3. Submit | Error: "This email is already registered." | ✅ PASS |
| TC-05 | Register with short password | None | 1. Fill form with 3-char password<br>2. Submit | Error: "Password must be at least 6 characters." | ✅ PASS |
| TC-06 | Logout functionality | User logged in | 1. Click Logout | Session destroyed; redirected to login page | ✅ PASS |

---

### Listing Module (Farmer)

| TC# | Test Case | Precondition | Steps | Expected Result | Status |
|-----|-----------|-------------|-------|----------------|--------|
| TC-07 | Create new listing | Logged in as farmer | 1. Go to New Listing<br>2. Fill all fields<br>3. Submit | Listing created with "Pending" status; confirmation flash message shown | ✅ PASS |
| TC-08 | Create listing with missing fields | Logged in as farmer | 1. Submit form with empty title | Browser HTML5 validation + server validation catches it | ✅ PASS |
| TC-09 | Live value estimator | On create listing page | 1. Type 500 in qty field<br>2. Type 280 in price field | Estimator instantly shows "140,000 RWF" | ✅ PASS |
| TC-10 | Edit own listing | Listing in Pending status | 1. Click Edit on own listing<br>2. Change title<br>3. Save | Title updated; confirmation shown | ✅ PASS |
| TC-11 | Delete own listing | Listing in Pending status | 1. Click Delete<br>2. Confirm dialog | Listing removed from DB and list | ✅ PASS |
| TC-12 | Farmer cannot access admin pages | Logged in as farmer | 1. Navigate to ?page=admin | "Access Denied" message shown | ✅ PASS |

---

### Booking Module (Buyer)

| TC# | Test Case | Precondition | Steps | Expected Result | Status |
|-----|-----------|-------------|-------|----------------|--------|
| TC-13 | Book an approved listing | Logged in as buyer; listing approved | 1. Browse market<br>2. Click Book Now<br>3. Enter 200 kg<br>4. Submit | Booking created with status=Pending; total = qty × price | ✅ PASS |
| TC-14 | Live booking total estimator | On booking form | 1. Enter qty = 300<br>2. Price is 280/kg | Total updates to "84,000 RWF" instantly | ✅ PASS |
| TC-15 | Exceed max quantity warning | On booking form | 1. Enter qty > available_kg | Warning text appears: "Exceeds available quantity!" | ✅ PASS |
| TC-16 | Cancel pending booking | Booking in Pending status | 1. Click Cancel on pending order<br>2. Confirm | Status changes to "Cancelled" | ✅ PASS |
| TC-17 | Mark booking as collected | Booking in Approved status | 1. Click "Collected" button<br>2. Confirm | Status changes to "Collected"; collected_at timestamp set | ✅ PASS |

---

### Admin Module

| TC# | Test Case | Precondition | Steps | Expected Result | Status |
|-----|-----------|-------------|-------|----------------|--------|
| TC-18 | Approve listing | Listing in Pending status | 1. Go to Admin > Listings<br>2. Click Approve<br>3. Confirm | Status changes to Approved; listing appears on buyer marketplace; audit log entry created | ✅ PASS |
| TC-19 | Reject listing | Listing in Pending status | 1. Click Reject<br>2. Confirm | Status changes to Rejected; audit log entry created | ✅ PASS |
| TC-20 | Approve order | Booking in Pending status | 1. Go to Admin > Orders<br>2. Click Approve | Status changes to Approved; buyer can now mark collected | ✅ PASS |
| TC-21 | Admin dashboard stats | Data in DB | 1. Login as admin<br>2. View dashboard | Shows: today_listings, pending_listings, booked_value, top_sectors | ✅ PASS |
| TC-22 | Audit log entries | Multiple actions performed | 1. Go to Admin > Audit Log | All actions shown with: timestamp, user, action, entity, IP | ✅ PASS |

---

### Security Tests

| TC# | Test Case | Expected Result | Status |
|-----|-----------|----------------|--------|
| TC-23 | SQL injection attempt in login email | Query uses prepared statements; no data leak or error | ✅ PASS |
| TC-24 | XSS in listing title | `<script>alert(1)</script>` rendered as escaped text | ✅ PASS |
| TC-25 | Buyer accessing admin URL directly | Access denied; redirected or error shown | ✅ PASS |

---

## Summary

| Category | Total | Pass | Fail |
|---------|-------|------|------|
| Authentication | 6 | 6 | 0 |
| Listings | 6 | 6 | 0 |
| Bookings | 5 | 5 | 0 |
| Admin | 5 | 5 | 0 |
| Security | 3 | 3 | 0 |
| **Total** | **25** | **25** | **0** |

---

## Known Limitations / Future Fixes
1. No automated test suite (PHPUnit) — manual testing only in v1
2. No rate limiting on login attempts (brute force mitigation needed for production)
3. Image upload for listings not implemented (v2 feature)
4. Email notifications on approval not yet implemented

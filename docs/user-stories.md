# User Stories — AgriStack

## Farmer Stories

### US-001: Register as Farmer
**As a** potato farmer in Musanze,  
**I want to** create an account on AgriStack as a farmer/cooperative,  
**So that** I can post my harvest listings and connect with buyers.

**Acceptance Criteria:**
- [ ] Registration form accepts: name, email, phone, password, sector, cooperative name (optional)
- [ ] Email uniqueness is enforced
- [ ] Password minimum 6 characters
- [ ] Role selection: Farmer or Buyer
- [ ] Account is created immediately and user is redirected to login
- [ ] Duplicate email shows error message

---

### US-002: Post a Harvest Listing
**As a** registered farmer,  
**I want to** create a harvest listing with variety, quantity, price, and pickup location,  
**So that** bulk buyers can find and book my harvest.

**Acceptance Criteria:**
- [ ] Form requires: title, variety, quantity (kg), price/kg, pickup sector, harvest date
- [ ] Listing defaults to "Pending" status
- [ ] Farmer receives confirmation that listing was submitted for approval
- [ ] Listing appears on farmer's dashboard immediately (with Pending status)
- [ ] Live value estimator shows qty × price as user types

---

### US-003: Manage My Listings
**As a** farmer,  
**I want to** edit or delete my harvest listings,  
**So that** I can keep information accurate and remove outdated listings.

**Acceptance Criteria:**
- [ ] Farmer can only edit/delete their own listings
- [ ] Approved listings cannot be deleted (protection against active bookings)
- [ ] Edit form pre-fills existing data
- [ ] Delete requires confirmation dialog
- [ ] Changes are saved and reflected immediately

---

### US-004: Track Listing Approval Status
**As a** farmer,  
**I want to** see the approval status of my listings (Pending/Approved/Rejected),  
**So that** I know when my listing is live and visible to buyers.

**Acceptance Criteria:**
- [ ] Dashboard shows status badges: Pending, Approved, Rejected
- [ ] Stats show count per status
- [ ] Admin notes are visible on rejected listings
- [ ] Approved listings show on public marketplace

---

## Buyer Stories

### US-005: Browse Available Harvests
**As a** bulk buyer,  
**I want to** browse all approved harvest listings with pricing and location,  
**So that** I can identify the best supply options for my business.

**Acceptance Criteria:**
- [ ] Only "approved" listings are shown to buyers
- [ ] Each listing shows: variety, quantity, price/kg, sector, farmer/coop
- [ ] Listings can be filtered by status
- [ ] Listing detail page shows full information
- [ ] Price and quantity are clearly displayed

---

### US-006: Place a Bulk Booking Request
**As a** buyer,  
**I want to** submit a bulk booking request specifying quantity and delivery details,  
**So that** I can reserve harvest stock directly from farmers.

**Acceptance Criteria:**
- [ ] Booking form shows listing details (variety, available qty, price/kg)
- [ ] Live total estimator updates as quantity is typed (qty × price/kg)
- [ ] System validates quantity does not exceed available stock
- [ ] Booking submitted with "Pending" status
- [ ] Buyer sees booking in "My Orders" after submission
- [ ] Warning shown if requested quantity exceeds available

---

### US-007: Track My Booking Status
**As a** buyer,  
**I want to** see the status of my orders (Pending → Approved → Collected),  
**So that** I know when to go collect my purchased harvest.

**Acceptance Criteria:**
- [ ] Bookings list shows status for each order
- [ ] Status badges clearly distinguish: Pending, Approved, Collected, Cancelled
- [ ] Buyer can cancel pending orders
- [ ] Buyer can mark approved orders as "Collected"
- [ ] Collected orders show collection timestamp

---

### US-008: Cancel a Pending Booking
**As a** buyer,  
**I want to** cancel my pending booking,  
**So that** I can adjust my purchase plans if needed.

**Acceptance Criteria:**
- [ ] Only "Pending" bookings can be cancelled
- [ ] Cancellation requires confirmation dialog
- [ ] Cancelled status is shown in orders list
- [ ] Approved/Collected bookings cannot be cancelled

---

## Admin Stories

### US-009: Approve or Reject Listings
**As an** admin,  
**I want to** review and approve or reject farmer harvest listings,  
**So that** only quality, verified listings are visible to buyers.

**Acceptance Criteria:**
- [ ] Admin sees all listings with Pending/Approved/Rejected status
- [ ] One-click approve and reject actions available
- [ ] Rejection can include a reason/note
- [ ] Approved listings immediately appear on buyer marketplace
- [ ] Audit log entry created for each approve/reject action

---

### US-010: Approve Bulk Orders
**As an** admin,  
**I want to** approve buyer booking requests,  
**So that** both parties have admin-verified confirmation of the transaction.

**Acceptance Criteria:**
- [ ] Admin sees all pending orders
- [ ] One-click approve action
- [ ] Status changes to "Approved" visible to buyer
- [ ] Audit log records approval with timestamp and admin name

---

### US-011: View Platform Dashboard Stats
**As an** admin,  
**I want to** see real-time statistics on listings, orders, and revenue,  
**So that** I can monitor platform health and usage.

**Acceptance Criteria:**
- [ ] Dashboard shows: today's listings, pending listings, approved listings, pending orders, total booked value, collected orders, farmer count, buyer count
- [ ] Top pickup sectors shown with visual bar chart
- [ ] Stats update on page load (no caching)

---

### US-012: View Audit Log
**As an** admin,  
**I want to** view a full audit log of all platform actions (login, create, approve, cancel),  
**So that** I have a transparent record for dispute resolution and accountability.

**Acceptance Criteria:**
- [ ] Audit log shows: timestamp, user name, action, entity type/ID, IP address, details
- [ ] 100 most recent records shown by default
- [ ] Records are immutable (no edit/delete)
- [ ] Log captures: logins, logouts, listing CRUD, booking CRUD, approvals/rejections

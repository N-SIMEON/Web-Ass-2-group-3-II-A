# Wireframes — AgriStack

## Mobile Wireframes (375px)

### Login Page
```
┌─────────────────────┐
│  🥔 AgriStack       │
│  ─────────────────  │
│                     │
│  Welcome back       │
│  ─────────────────  │
│                     │
│  Email              │
│  ┌─────────────┐   │
│  │             │   │
│  └─────────────┘   │
│                     │
│  Password           │
│  ┌─────────────┐   │
│  │             │   │
│  └─────────────┘   │
│                     │
│  ┌─────────────┐   │
│  │  Sign In →  │   │
│  └─────────────┘   │
│                     │
│  Don't have account?│
│  Register here      │
└─────────────────────┘
```

### Farmer Dashboard (Mobile)
```
┌─────────────────────┐
│ ☰  🥔 AgriStack     │
├─────────────────────┤
│ 🌾 Good morning!    │
│ Manage your listings│
│         [+ New]     │
├─────────────────────┤
│ ┌──────┐ ┌──────┐  │
│ │  3   │ │  1   │  │
│ │Lists │ │Pend. │  │
│ └──────┘ └──────┘  │
│ ┌──────┐ ┌──────┐  │
│ │  2   │ │  0   │  │
│ │Apprd │ │Rejct │  │
│ └──────┘ └──────┘  │
├─────────────────────┤
│ Recent Listings     │
│ ─────────────────   │
│ Victoria Pot...     │
│ ⏳ Pending   [Edit] │
│ ─────────────────   │
│ Gishwati Red        │
│ ✅ Approved         │
└─────────────────────┘
```

### Booking Form (Mobile)
```
┌─────────────────────┐
│ ☰  🥔 AgriStack     │
├─────────────────────┤
│ 📦 Place Bulk Order │
│ [← Back to Market]  │
├─────────────────────┤
│ Booking for:        │
│ Victoria Potatoes   │
│ 🥔 Victoria ⚖️500kg │
│ 280 RWF/kg          │
├─────────────────────┤
│ Quantity (kg) *     │
│ ┌─────────────┐    │
│ │    300      │    │
│ └─────────────┘    │
│ Max: 500 kg         │
│                     │
│ ┌──────────────────┐│
│ │ Order Total       ││
│ │ 84,000 RWF        ││
│ │ 300kg × 280 RWF   ││
│ └──────────────────┘│
│                     │
│ [Submit Booking →]  │
└─────────────────────┘
```

---

## Desktop Wireframes (1280px)

### Admin Dashboard (Desktop)
```
┌────────────────────────────────────────────────────┐
│ 🥔 AgriStack  | Dashboard | Listings | Orders | ... │
├──────────┬─────────────────────────────────────────┤
│ Sidebar  │  ⚙️ Admin Overview                      │
│          │                                          │
│ 📊 Over. │  ┌─────┐ ┌─────┐ ┌─────┐ ┌─────┐      │
│ 📋 List. │  │  4  │ │  2  │ │  8  │ │ 2M  │      │
│ 📦 Order │  │Today│ │Pend │ │Appr │ │Value│      │
│ 👥 Users │  └─────┘ └─────┘ └─────┘ └─────┘      │
│ 🔍 Audit │                                          │
│          │  ┌──────────────┐  ┌──────────────┐    │
│ [Logout] │  │ Top Sectors  │  │ Recent Acts  │    │
│          │  │ Kinigi  ████ │  │ Approved #1  │    │
│          │  │ Cyuve   ██   │  │ by Admin ... │    │
│          │  │ Shingiro█    │  │ Booking #3   │    │
│          │  └──────────────┘  └──────────────┘    │
│          │                                          │
│          │  ⚡ Quick Actions                        │
│          │  [Review Listings] [Approve Orders]      │
└──────────┴─────────────────────────────────────────┘
```

### Marketplace (Desktop - Buyer View)
```
┌────────────────────────────────────────────────────┐
│ 🥔 AgriStack  [Dashboard] [Browse] [My Orders] ...  │
├──────────┬─────────────────────────────────────────┤
│ Sidebar  │  🛒 Marketplace                         │
│          │                                          │
│ 🏠 Dash  │  [All] [Pending] [Approved]  24 listings │
│ 🛒 Brows │                                          │
│ 📦 Order │  ┌──────────┐ ┌──────────┐ ┌──────────┐│
│          │  │  🥔      │ │  🥔      │ │  🥔      ││
│ [Logout] │  │ Victoria │ │ Gishwati │ │ Kinigi W ││
│          │  │ 280 RWF  │ │ 260 RWF  │ │ 250 RWF  ││
│          │  │ 500 kg   │ │ 800 kg   │ │ 1000 kg  ││
│          │  │ Kinigi   │ │ Cyuve    │ │ Shingiro ││
│          │  │[View][Book│ [View][Book│ [View][Book│
│          │  └──────────┘ └──────────┘ └──────────┘│
└──────────┴─────────────────────────────────────────┘
```

### Create Listing (Desktop - Farmer)
```
┌────────────────────────────────────────────────────┐
│ 🥔 AgriStack                                        │
├──────────┬─────────────────────────────────────────┤
│ Sidebar  │  ＋ New Harvest Listing                  │
│          │                                          │
│          │  ┌─────────────────────┐  ┌───────────┐ │
│          │  │ Listing Details     │  │ Estimator │ │
│          │  │                     │  │           │ │
│          │  │ Title: [__________] │  │ 140,000   │ │
│          │  │ Variety: [▼_______] │  │ RWF       │ │
│          │  │ Sector:  [▼_______] │  │           │ │
│          │  │ Qty: [___] P: [___] │  │ 500kg×280 │ │
│          │  │ Harvest: [date____] │  ├───────────┤ │
│          │  │                     │  │ Tips      │ │
│          │  │ Description: [____] │  │ • Fair px │ │
│          │  │                     │  │ • Details │ │
│          │  │ [🌾 Submit Listing] │  └───────────┘ │
│          │  └─────────────────────┘                │
└──────────┴─────────────────────────────────────────┘
```

# UI Style Guide — AgriStack

## Design Philosophy
**Aesthetic Direction:** Earthy Organic Premium — inspired by Rwandan agricultural heritage, volcanic soil, and highland farming. The design balances professionalism with warmth.

---

## Color Palette

| Token | Hex | Usage |
|-------|-----|-------|
| `--soil` | `#2C1A0E` | Primary dark, headings, sidebar |
| `--bark` | `#4A2C17` | Secondary dark |
| `--earth` | `#7A4A2A` | Accent brown |
| `--terracotta` | `#C2683A` | Warning, required marks |
| `--amber` | `#E8A045` | Secondary CTA, pending badges |
| `--harvest` | `#F5C842` | Brand accent (AgriStack yellow) |
| `--sage` | `#5C7A4A` | Mid green |
| `--forest` | `#2D5016` | Primary green, buttons |
| `--leaf` | `#4A7C3F` | Links, hover |
| `--mint` | `#8FBC6A` | Light green accents |
| `--cream` | `#FAF5EC` | Page background, sidebar |
| `--parchment` | `#F0E6CF` | Card backgrounds, chips |
| `--white` | `#FFFFFF` | Card bodies |
| `--mist` | `#F7F3EE` | Page background |
| `--border` | `#E2D5C0` | All borders |

---

## Typography

| Use | Font | Weight | Size |
|-----|------|--------|------|
| Display / Headings | Fraunces (serif) | 300, 600, 900 | h1: 2rem–2.8rem |
| Body / UI | DM Sans (sans-serif) | 300, 400, 600 | 15px base |
| Monospace (audit log) | System monospace | 400 | 0.78rem |

**Import:**
```css
@import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@300;600;900&family=DM+Sans:wght@300;400;600&display=swap');
```

---

## Component Library

### Buttons
- `.btn-primary` — Forest green, white text — Primary actions
- `.btn-amber` — Amber, soil text — Secondary CTAs
- `.btn-danger` — Red, white text — Destructive actions
- `.btn-success` — Green, white text — Confirmations
- `.btn-ghost` — Transparent, bordered — Tertiary actions
- Sizes: default (9px/20px), `.btn-sm`, `.btn-xs`

### Status Badges
- `.badge-pending` — Yellow tint
- `.badge-approved` — Green tint
- `.badge-rejected` — Red tint
- `.badge-collected` — Blue tint
- `.badge-cancelled` — Red tint
- `.badge-farmer` / `.badge-buyer` / `.badge-admin` — Role colors

### Cards
- White background, 18px border-radius, 1px border, subtle shadow
- `.card-header` — Cream background, flex layout
- `.card-body` — 24px padding

### Stat Cards
- Colored top border (3px)
- Fraunces serif number (2rem)
- Absolute positioned emoji icon (faded)

---

## Layout System
- **Auth pages:** Full-viewport split-panel (left: hero, right: form)
- **App pages:** Sticky top navbar (62px) + sidebar (240px) + main content
- **Mobile (<900px):** Sidebar hidden by default, hamburger toggle
- **Max content width:** 1240px centered

---

## Iconography
Uses Unicode emoji as icons throughout for zero-dependency visual richness:
🥔 🌾 📋 📦 🛒 ⚖️ 📍 💰 👥 🔍 ✅ ⏳ ❌

---

## Spacing
- Base unit: 4px
- Common: 8, 12, 16, 20, 24, 32, 48px
- Section separation: 28–32px

---

## Accessibility
- Minimum contrast ratio 4.5:1 for body text
- Focus states visible on all interactive elements
- Semantic HTML: `<nav>`, `<main>`, `<aside>`, `<table>` with `<thead>`/`<tbody>`
- Form labels linked to inputs
- Error messages descriptive and specific

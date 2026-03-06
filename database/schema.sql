-- ============================================================
-- AgriStack Irish Potato Marketplace — Database Schema
-- Musanze, Rwanda
-- ============================================================

CREATE DATABASE IF NOT EXISTS agristack_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agristack_db;

-- ---------------------------------------------------------------
-- USERS (farmers/coops, buyers/aggregators, admins)
-- ---------------------------------------------------------------
CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL UNIQUE,
    phone       VARCHAR(20),
    password    VARCHAR(255)  NOT NULL,
    role        ENUM('farmer','buyer','admin') NOT NULL DEFAULT 'farmer',
    sector      VARCHAR(100)  COMMENT 'Musanze sector/cell location',
    coop_name   VARCHAR(150)  COMMENT 'Cooperative name if applicable',
    is_active   TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------
-- HARVEST LISTINGS  (posted by farmers/coops)
-- ---------------------------------------------------------------
CREATE TABLE listings (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id       INT          NOT NULL,
    title           VARCHAR(200) NOT NULL,
    variety         VARCHAR(100) NOT NULL  COMMENT 'e.g. Victoria, Kinigi, Gishwati',
    quantity_kg     DECIMAL(10,2) NOT NULL,
    price_per_kg    DECIMAL(10,2) NOT NULL,
    pickup_sector   VARCHAR(100) NOT NULL,
    harvest_date    DATE         NOT NULL,
    expiry_date     DATE,
    description     TEXT,
    image_path      VARCHAR(255),
    status          ENUM('pending','approved','rejected','sold') NOT NULL DEFAULT 'pending',
    admin_note      TEXT,
    approved_by     INT,
    approved_at     DATETIME,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id)   REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ---------------------------------------------------------------
-- BULK BOOKING REQUESTS  (placed by buyers)
-- ---------------------------------------------------------------
CREATE TABLE bookings (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    listing_id      INT          NOT NULL,
    buyer_id        INT          NOT NULL,
    qty_requested   DECIMAL(10,2) NOT NULL,
    total_value     DECIMAL(12,2) NOT NULL,
    delivery_address VARCHAR(255),
    pickup_date     DATE,
    notes           TEXT,
    status          ENUM('pending','approved','collected','cancelled') NOT NULL DEFAULT 'pending',
    approved_by     INT,
    approved_at     DATETIME,
    collected_at    DATETIME,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id)  REFERENCES listings(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id)    ON DELETE SET NULL
);

-- ---------------------------------------------------------------
-- AUDIT LOG
-- ---------------------------------------------------------------
CREATE TABLE audit_log (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT,
    user_name   VARCHAR(150),
    action      VARCHAR(255) NOT NULL,
    entity_type VARCHAR(50)  COMMENT 'listing|booking|user',
    entity_id   INT,
    details     TEXT,
    ip_address  VARCHAR(45),
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ---------------------------------------------------------------
-- SEED DATA — Demo accounts
-- ---------------------------------------------------------------

-- Admin (password: admin123)
INSERT INTO users (full_name, email, phone, password, role, sector) VALUES
('Admin Kalisa', 'admin@agristack.rw', '+250788000001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Musanze Centre');

-- Farmers (password: farmer123)
INSERT INTO users (full_name, email, phone, password, role, sector, coop_name) VALUES
('Uwimana Jean', 'jean@agristack.rw', '+250788000002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'farmer', 'Kinigi', 'Kinigi Potato Coop'),
('Mukamana Diane', 'diane@agristack.rw', '+250788000003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'farmer', 'Cyuve', NULL),
('Hakizimana Pierre', 'pierre@agristack.rw', '+250788000004', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'farmer', 'Shingiro', 'Shingiro Farmers Group');

-- Buyers (password: buyer123)
INSERT INTO users (full_name, email, phone, password, role, sector) VALUES
('Nkurunziza Robert', 'robert@agristack.rw', '+250788000005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'Kigali'),
('Mutesi Agnes', 'agnes@agristack.rw', '+250788000006', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'Musanze');

-- Sample listings
INSERT INTO listings (farmer_id, title, variety, quantity_kg, price_per_kg, pickup_sector, harvest_date, description, status, approved_by, approved_at) VALUES
(2, 'Fresh Victoria Potatoes — 500kg Batch', 'Victoria', 500.00, 280.00, 'Kinigi', CURDATE(), 'Clean, sorted, high-yield Victoria variety. Ready for immediate pickup.', 'approved', 1, NOW()),
(3, 'Gishwati Red Potatoes — Bulk Available', 'Gishwati Red', 800.00, 260.00, 'Cyuve', CURDATE(), 'Premium red potatoes from Cyuve highlands. Excellent for export.', 'approved', 1, NOW()),
(4, 'Kinigi White — 1000kg Cooperative Lot', 'Kinigi White', 1000.00, 250.00, 'Shingiro', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 'Cooperative harvest from 12 member farms. Uniform sizing.', 'pending', NULL, NULL);

-- Sample bookings
INSERT INTO bookings (listing_id, buyer_id, qty_requested, total_value, delivery_address, pickup_date, notes, status) VALUES
(1, 5, 300.00, 84000.00, 'Kigali Central Market', DATE_ADD(CURDATE(), INTERVAL 2 DAY), 'Need morning delivery before 10 AM', 'approved'),
(2, 6, 400.00, 104000.00, 'Musanze Town Market', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Regular weekly order', 'pending');

-- Sample audit logs
INSERT INTO audit_log (user_id, user_name, action, entity_type, entity_id, details) VALUES
(1, 'Admin Kalisa', 'Approved listing', 'listing', 1, 'Listing "Fresh Victoria Potatoes" approved'),
(1, 'Admin Kalisa', 'Approved listing', 'listing', 2, 'Listing "Gishwati Red Potatoes" approved'),
(5, 'Nkurunziza Robert', 'Placed booking', 'booking', 1, 'Booked 300kg @ 280 RWF/kg = 84,000 RWF');

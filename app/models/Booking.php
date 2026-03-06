<?php
/**
 * AgriStack — Booking Model
 */
class Booking {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create(array $data): int|false {
        $stmt = $this->db->prepare(
            'INSERT INTO bookings (listing_id, buyer_id, qty_requested, total_value,
             delivery_address, pickup_date, notes, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, "pending")'
        );
        $stmt->bind_param(
            'iiddss',
            $data['listing_id'], $data['buyer_id'],
            $data['qty_requested'], $data['total_value'],
            $data['delivery_address'], $data['pickup_date'], $data['notes']
        );
        return $stmt->execute() ? $this->db->insert_id : false;
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT b.*, l.title AS listing_title, l.variety, l.price_per_kg,
                    l.pickup_sector, uf.full_name AS farmer_name,
                    ub.full_name AS buyer_name, ub.phone AS buyer_phone
             FROM bookings b
             JOIN listings l ON b.listing_id = l.id
             JOIN users uf ON l.farmer_id = uf.id
             JOIN users ub ON b.buyer_id   = ub.id
             WHERE b.id = ? LIMIT 1'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function getByBuyer(int $buyerId): array {
        $stmt = $this->db->prepare(
            'SELECT b.*, l.title AS listing_title, l.variety, l.pickup_sector,
                    l.price_per_kg, uf.full_name AS farmer_name
             FROM bookings b
             JOIN listings l ON b.listing_id = l.id
             JOIN users uf ON l.farmer_id = uf.id
             WHERE b.buyer_id = ? ORDER BY b.created_at DESC'
        );
        $stmt->bind_param('i', $buyerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll(): array {
        $result = $this->db->query(
            'SELECT b.*, l.title AS listing_title, l.variety, l.pickup_sector,
                    uf.full_name AS farmer_name, ub.full_name AS buyer_name
             FROM bookings b
             JOIN listings l ON b.listing_id = l.id
             JOIN users uf ON l.farmer_id = uf.id
             JOIN users ub ON b.buyer_id   = ub.id
             ORDER BY b.created_at DESC'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus(int $id, string $status, ?int $adminId = null): bool {
        if ($status === 'approved') {
            $stmt = $this->db->prepare(
                'UPDATE bookings SET status=?, approved_by=?, approved_at=NOW() WHERE id=?'
            );
            $stmt->bind_param('sii', $status, $adminId, $id);
        } elseif ($status === 'collected') {
            $stmt = $this->db->prepare(
                'UPDATE bookings SET status="collected", collected_at=NOW() WHERE id=?'
            );
            $stmt->bind_param('i', $id);
        } else {
            $stmt = $this->db->prepare('UPDATE bookings SET status=? WHERE id=?');
            $stmt->bind_param('si', $status, $id);
        }
        return $stmt->execute();
    }

    public function cancel(int $id, int $buyerId): bool {
        $stmt = $this->db->prepare(
            'UPDATE bookings SET status="cancelled" WHERE id=? AND buyer_id=? AND status="pending"'
        );
        $stmt->bind_param('ii', $id, $buyerId);
        return $stmt->execute() && $this->db->affected_rows > 0;
    }

    // Stats
    public function totalBookedValue(): float {
        $result = $this->db->query(
            "SELECT COALESCE(SUM(total_value),0) AS total FROM bookings WHERE status IN ('approved','collected')"
        );
        return (float)$result->fetch_assoc()['total'];
    }

    public function pendingCount(): int {
        $result = $this->db->query("SELECT COUNT(*) AS cnt FROM bookings WHERE status='pending'");
        return (int)$result->fetch_assoc()['cnt'];
    }

    public function countByStatus(string $status): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) AS cnt FROM bookings WHERE status=?');
        $stmt->bind_param('s', $status);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['cnt'];
    }
}

<?php
/**
 * AgriStack — Listing Model
 */
class Listing {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(string $status = ''): array {
        if ($status) {
            $stmt = $this->db->prepare(
                'SELECT l.*, u.full_name AS farmer_name, u.sector, u.coop_name
                 FROM listings l JOIN users u ON l.farmer_id = u.id
                 WHERE l.status = ? ORDER BY l.created_at DESC'
            );
            $stmt->bind_param('s', $status);
        } else {
            $stmt = $this->db->prepare(
                'SELECT l.*, u.full_name AS farmer_name, u.sector, u.coop_name
                 FROM listings l JOIN users u ON l.farmer_id = u.id
                 ORDER BY l.created_at DESC'
            );
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getByFarmer(int $farmerId): array {
        $stmt = $this->db->prepare(
            'SELECT l.*, u.full_name AS farmer_name
             FROM listings l JOIN users u ON l.farmer_id = u.id
             WHERE l.farmer_id = ? ORDER BY l.created_at DESC'
        );
        $stmt->bind_param('i', $farmerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT l.*, u.full_name AS farmer_name, u.phone AS farmer_phone,
                    u.coop_name, u.sector AS farmer_sector
             FROM listings l JOIN users u ON l.farmer_id = u.id
             WHERE l.id = ? LIMIT 1'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function create(array $data): int|false {
        $stmt = $this->db->prepare(
            'INSERT INTO listings (farmer_id, title, variety, quantity_kg, price_per_kg,
             pickup_sector, harvest_date, expiry_date, description, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, "pending")'
        );
        $stmt->bind_param(
            'issddsss s',
            $data['farmer_id'], $data['title'], $data['variety'],
            $data['quantity_kg'], $data['price_per_kg'],
            $data['pickup_sector'], $data['harvest_date'],
            $data['expiry_date'], $data['description']
        );
        return $stmt->execute() ? $this->db->insert_id : false;
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE listings SET title=?, variety=?, quantity_kg=?, price_per_kg=?,
             pickup_sector=?, harvest_date=?, expiry_date=?, description=?
             WHERE id=? AND farmer_id=?'
        );
        $stmt->bind_param(
            'ssddssssii',
            $data['title'], $data['variety'], $data['quantity_kg'], $data['price_per_kg'],
            $data['pickup_sector'], $data['harvest_date'], $data['expiry_date'],
            $data['description'], $id, $data['farmer_id']
        );
        return $stmt->execute();
    }

    public function updateStatus(int $id, string $status, int $adminId, string $note = ''): bool {
        $stmt = $this->db->prepare(
            'UPDATE listings SET status=?, approved_by=?, approved_at=NOW(), admin_note=? WHERE id=?'
        );
        $stmt->bind_param('sisi', $status, $adminId, $note, $id);
        return $stmt->execute();
    }

    public function delete(int $id, int $farmerId): bool {
        $stmt = $this->db->prepare('DELETE FROM listings WHERE id=? AND farmer_id=?');
        $stmt->bind_param('ii', $id, $farmerId);
        return $stmt->execute();
    }

    // Dashboard stats
    public function countToday(): int {
        $result = $this->db->query("SELECT COUNT(*) AS cnt FROM listings WHERE DATE(created_at)=CURDATE()");
        return (int)$result->fetch_assoc()['cnt'];
    }

    public function totalApproved(): int {
        $result = $this->db->query("SELECT COUNT(*) AS cnt FROM listings WHERE status='approved'");
        return (int)$result->fetch_assoc()['cnt'];
    }

    public function topPickupSectors(int $limit = 5): array {
        $stmt = $this->db->prepare(
            'SELECT pickup_sector, COUNT(*) AS total_listings, SUM(quantity_kg) AS total_kg
             FROM listings WHERE status="approved"
             GROUP BY pickup_sector ORDER BY total_listings DESC LIMIT ?'
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function pendingCount(): int {
        $result = $this->db->query("SELECT COUNT(*) AS cnt FROM listings WHERE status='pending'");
        return (int)$result->fetch_assoc()['cnt'];
    }
}

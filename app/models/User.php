<?php
/**
 * AgriStack — User Model
 */
class User {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare(
            'SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1'
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function create(array $data): int|false {
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            'INSERT INTO users (full_name, email, phone, password, role, sector, coop_name)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'sssssss',
            $data['full_name'], $data['email'], $data['phone'],
            $hash, $data['role'], $data['sector'], $data['coop_name']
        );
        return $stmt->execute() ? $this->db->insert_id : false;
    }

    public function emailExists(string $email): bool {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getAll(): array {
        $result = $this->db->query('SELECT id, full_name, email, phone, role, sector, coop_name, is_active, created_at FROM users ORDER BY created_at DESC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countByRole(string $role): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) as cnt FROM users WHERE role = ?');
        $stmt->bind_param('s', $role);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['cnt'];
    }
}

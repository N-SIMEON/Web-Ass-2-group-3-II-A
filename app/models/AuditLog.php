<?php
/**
 * AgriStack — Audit Log Model
 */
class AuditLog {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function log(int|null $userId, string $userName, string $action,
                        string $entityType = '', int $entityId = 0, string $details = ''): void {
        $ip   = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $stmt = $this->db->prepare(
            'INSERT INTO audit_log (user_id, user_name, action, entity_type, entity_id, details, ip_address)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('isssiss', $userId, $userName, $action, $entityType, $entityId, $details, $ip);
        $stmt->execute();
    }

    public function getRecent(int $limit = 50): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM audit_log ORDER BY created_at DESC LIMIT ?'
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function count(): int {
        $result = $this->db->query('SELECT COUNT(*) AS cnt FROM audit_log');
        return (int)$result->fetch_assoc()['cnt'];
    }
}

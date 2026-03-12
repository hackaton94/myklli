<?php
/**
 * Classe de gestion de la base de données
 * MYKLI Multi-services
 */

class Database {
    private $conn;
    private static $instance = null;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function insertVisitor($data) {
        $sql = "INSERT INTO visitors (
            ip_address, country, country_code, region, city, 
            latitude, longitude, timezone, isp, user_agent, 
            browser, os, device, referrer, page_url, session_id
        ) VALUES (
            :ip_address, :country, :country_code, :region, :city,
            :latitude, :longitude, :timezone, :isp, :user_agent,
            :browser, :os, :device, :referrer, :page_url, :session_id
        )";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        } catch(PDOException $e) {
            error_log("Insert visitor failed: " . $e->getMessage());
            return false;
        }
    }

    public function getTodayStats() {
        $sql = "SELECT 
            COUNT(*) as total_visits,
            COUNT(DISTINCT ip_address) as unique_visitors,
            COUNT(DISTINCT country) as countries_count
        FROM visitors 
        WHERE DATE(visit_date) = CURDATE()";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetch();
        } catch(PDOException $e) {
            error_log("Get today stats failed: " . $e->getMessage());
            return false;
        }
    }

    public function getCountryStats($limit = 10) {
        $sql = "SELECT 
            country, 
            country_code,
            COUNT(*) as visit_count
        FROM visitors 
        WHERE DATE(visit_date) = CURDATE()
        GROUP BY country, country_code
        ORDER BY visit_count DESC
        LIMIT :limit";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Get country stats failed: " . $e->getMessage());
            return false;
        }
    }

    public function getRecentVisitors($limit = 10) {
        $sql = "SELECT 
            ip_address, country, city, browser, os, visit_date
        FROM visitors 
        ORDER BY visit_date DESC
        LIMIT :limit";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Get recent visitors failed: " . $e->getMessage());
            return false;
        }
    }

    public function logNotification($type, $message, $status = 'sent') {
        $sql = "INSERT INTO notifications_log (notification_type, message, status) 
                VALUES (:type, :message, :status)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':type' => $type,
                ':message' => $message,
                ':status' => $status
            ]);
            return true;
        } catch(PDOException $e) {
            error_log("Log notification failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

-- Base de données pour le tracking des visiteurs
-- MYKLI Multi-services

CREATE DATABASE IF NOT EXISTS mykli_visitors CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE mykli_visitors;

-- Table des visiteurs
CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    country VARCHAR(100),
    country_code VARCHAR(10),
    region VARCHAR(100),
    city VARCHAR(100),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    timezone VARCHAR(50),
    isp VARCHAR(255),
    user_agent TEXT,
    browser VARCHAR(50),
    os VARCHAR(50),
    device VARCHAR(50),
    referrer TEXT,
    page_url TEXT,
    visit_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    session_id VARCHAR(100),
    INDEX idx_ip (ip_address),
    INDEX idx_country (country_code),
    INDEX idx_date (visit_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des statistiques quotidiennes
CREATE TABLE IF NOT EXISTS daily_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stat_date DATE NOT NULL UNIQUE,
    total_visits INT DEFAULT 0,
    unique_visitors INT DEFAULT 0,
    countries JSON,
    top_pages JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (stat_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des notifications envoyées
CREATE TABLE IF NOT EXISTS notifications_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    notification_type ENUM('telegram', 'email', 'whatsapp') NOT NULL,
    message TEXT,
    status ENUM('sent', 'failed') DEFAULT 'sent',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (notification_type),
    INDEX idx_date (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vue pour les statistiques rapides
CREATE OR REPLACE VIEW visitor_stats AS
SELECT 
    DATE(visit_date) as date,
    COUNT(*) as total_visits,
    COUNT(DISTINCT ip_address) as unique_visitors,
    COUNT(DISTINCT country) as countries_count
FROM visitors
GROUP BY DATE(visit_date)
ORDER BY date DESC;

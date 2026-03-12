<?php
/**
 * Script d'installation automatique
 * MYKLI Multi-services - Système de tracking
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<html><head><meta charset='UTF-8'><title>Installation MYKLI Tracking</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
    h1 { color: #2563eb; }
    .step { background: white; padding: 20px; margin: 15px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
</style></head><body>";

echo "<h1>🚀 Installation du Système de Tracking MYKLI</h1>";

// Configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'mykli_visitors';

// Étape 1: Vérifier la connexion MySQL
echo "<div class='step'><h2>Étape 1: Vérification de MySQL</h2>";
try {
    $conn = new PDO("mysql:host=$db_host", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div class='success'>✅ Connexion à MySQL réussie!</div>";
} catch(PDOException $e) {
    echo "<div class='error'>❌ Erreur de connexion MySQL: " . $e->getMessage() . "</div>";
    echo "<div class='info'>💡 Vérifiez que WampServer est démarré (icône verte)</div>";
    exit;
}
echo "</div>";

// Étape 2: Créer la base de données
echo "<div class='step'><h2>Étape 2: Création de la base de données</h2>";
try {
    $conn->exec("CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<div class='success'>✅ Base de données '$db_name' créée avec succès!</div>";
} catch(PDOException $e) {
    echo "<div class='error'>❌ Erreur: " . $e->getMessage() . "</div>";
    exit;
}
echo "</div>";

// Étape 3: Créer les tables
echo "<div class='step'><h2>Étape 3: Création des tables</h2>";
try {
    $conn->exec("USE $db_name");
    
    // Table visitors
    $conn->exec("CREATE TABLE IF NOT EXISTS visitors (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<div class='success'>✅ Table 'visitors' créée</div>";
    
    // Table daily_stats
    $conn->exec("CREATE TABLE IF NOT EXISTS daily_stats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        stat_date DATE NOT NULL UNIQUE,
        total_visits INT DEFAULT 0,
        unique_visitors INT DEFAULT 0,
        countries JSON,
        top_pages JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_date (stat_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<div class='success'>✅ Table 'daily_stats' créée</div>";
    
    // Table notifications_log
    $conn->exec("CREATE TABLE IF NOT EXISTS notifications_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        notification_type ENUM('telegram', 'email', 'whatsapp') NOT NULL,
        message TEXT,
        status ENUM('sent', 'failed') DEFAULT 'sent',
        sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_type (notification_type),
        INDEX idx_date (sent_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<div class='success'>✅ Table 'notifications_log' créée</div>";
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ Erreur lors de la création des tables: " . $e->getMessage() . "</div>";
    exit;
}
echo "</div>";

// Étape 4: Vérification finale
echo "<div class='step'><h2>Étape 4: Vérification finale</h2>";
try {
    $stmt = $conn->query("SHOW TABLES FROM $db_name");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<div class='success'>✅ Tables créées avec succès:</div>";
    echo "<ul>";
    foreach($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ Erreur: " . $e->getMessage() . "</div>";
}
echo "</div>";

// Étape 5: Instructions finales
echo "<div class='step'><h2>🎉 Installation Terminée!</h2>";
echo "<div class='success'>";
echo "<h3>Prochaines étapes:</h3>";
echo "<ol>";
echo "<li><strong>Accéder au Dashboard:</strong> <a href='admin/dashboard.php' target='_blank'>http://localhost/MykliMultiservices/admin/dashboard.php</a></li>";
echo "<li><strong>Mot de passe:</strong> mykli2025</li>";
echo "<li><strong>Configurer Telegram:</strong> Modifier config/config.php avec votre Bot Token et Chat ID</li>";
echo "<li><strong>Tester le site:</strong> <a href='index.html' target='_blank'>http://localhost/MykliMultiservices/</a></li>";
echo "</ol>";
echo "</div>";
echo "<div class='info'>";
echo "<h3>📚 Documentation:</h3>";
echo "<p>Consultez <strong>INSTALLATION_TRACKING.md</strong> pour la configuration complète de Telegram et Email.</p>";
echo "</div>";
echo "</div>";

echo "</body></html>";
?>

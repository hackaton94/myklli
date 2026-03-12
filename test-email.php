<?php
/**
 * Test d'envoi d'email
 * MYKLI Multi-services
 */

require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/EmailNotifier.php';

echo "<html><head><meta charset='UTF-8'><title>Test Email</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
    h1 { color: #2563eb; }
</style></head><body>";

echo "<h1>📧 Test d'Envoi d'Email</h1>";

echo "<div class='info'>";
echo "<strong>Configuration actuelle :</strong><br>";
echo "Email destinataire : <strong>" . EMAIL_TO . "</strong><br>";
echo "Fuseau horaire : <strong>" . TIMEZONE . "</strong><br>";
echo "Heure actuelle : <strong>" . date('d/m/Y H:i:s') . "</strong>";
echo "</div>";

// Données de test
$testVisitorData = [
    'ip_address' => '102.244.123.45',
    'country' => 'Côte d\'Ivoire',
    'country_code' => 'CI',
    'region' => 'Abidjan',
    'city' => 'Abidjan',
    'latitude' => 5.3600,
    'longitude' => -4.0083,
    'timezone' => 'Africa/Abidjan',
    'isp' => 'Orange CI',
    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
    'browser' => 'Chrome',
    'os' => 'Windows',
    'device' => 'Desktop',
    'referrer' => 'https://google.com',
    'page_url' => 'http://localhost/MykliMultiservices/',
    'session_id' => 'test_session_123'
];

echo "<h2>Test 1 : Notification de Visiteur</h2>";

try {
    $email = new EmailNotifier();
    $result = $email->sendVisitorAlert($testVisitorData);
    
    if ($result) {
        echo "<div class='success'>✅ Email de notification envoyé avec succès à <strong>" . EMAIL_TO . "</strong>!</div>";
        echo "<div class='info'>💡 Vérifiez votre boîte de réception (et le dossier spam si nécessaire)</div>";
    } else {
        echo "<div class='error'>❌ Échec de l'envoi de l'email</div>";
        echo "<div class='info'>";
        echo "<strong>Raisons possibles :</strong><br>";
        echo "1. WampServer n'a pas de serveur SMTP configuré par défaut<br>";
        echo "2. La fonction mail() de PHP nécessite une configuration SMTP<br><br>";
        echo "<strong>Solutions :</strong><br>";
        echo "• Installer et configurer un serveur SMTP local (comme hMailServer)<br>";
        echo "• Utiliser PHPMailer avec Gmail/Outlook SMTP<br>";
        echo "• Utiliser un service d'email comme SendGrid, Mailgun, etc.";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Erreur : " . $e->getMessage() . "</div>";
}

echo "<h2>Test 2 : Rapport Quotidien</h2>";

$testStats = [
    'unique_visitors' => 42,
    'total_visits' => 156,
    'countries_count' => 8
];

$testCountryStats = [
    ['country' => 'Côte d\'Ivoire', 'country_code' => 'CI', 'visit_count' => 45],
    ['country' => 'France', 'country_code' => 'FR', 'visit_count' => 32],
    ['country' => 'Sénégal', 'country_code' => 'SN', 'visit_count' => 28],
    ['country' => 'Belgique', 'country_code' => 'BE', 'visit_count' => 18],
    ['country' => 'Canada', 'country_code' => 'CA', 'visit_count' => 15]
];

try {
    $email = new EmailNotifier();
    $result = $email->sendDailyReport($testStats, $testCountryStats);
    
    if ($result) {
        echo "<div class='success'>✅ Rapport quotidien envoyé avec succès!</div>";
    } else {
        echo "<div class='error'>❌ Échec de l'envoi du rapport</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Erreur : " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<div class='info'>";
echo "<h3>📝 Note Importante sur l'Email</h3>";
echo "<p>Par défaut, WampServer n'a pas de serveur SMTP configuré. Pour que les emails fonctionnent réellement, vous devez :</p>";
echo "<ol>";
echo "<li><strong>Option 1 (Recommandée) :</strong> Utiliser PHPMailer avec Gmail/Outlook</li>";
echo "<li><strong>Option 2 :</strong> Installer un serveur SMTP local (hMailServer, Mercury)</li>";
echo "<li><strong>Option 3 :</strong> Utiliser un service d'email tiers (SendGrid, Mailgun)</li>";
echo "</ol>";
echo "<p>Les notifications Telegram fonctionnent immédiatement sans configuration SMTP !</p>";
echo "</div>";

echo "</body></html>";
?>

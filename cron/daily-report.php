<?php
/**
 * Script de génération de rapports quotidiens
 * À exécuter via Cron Job ou Task Scheduler
 * MYKLI Multi-services
 */

require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/TelegramNotifier.php';
require_once '../includes/EmailNotifier.php';

echo "=== MYKLI Daily Report Generator ===\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n\n";

try {
    $db = Database::getInstance();
    
    // Récupérer les statistiques du jour
    echo "Fetching today's statistics...\n";
    $stats = $db->getTodayStats();
    
    if (!$stats) {
        throw new Exception("Failed to fetch statistics");
    }
    
    echo "Total visits: {$stats['total_visits']}\n";
    echo "Unique visitors: {$stats['unique_visitors']}\n";
    echo "Countries: {$stats['countries_count']}\n\n";
    
    // Récupérer les statistiques par pays
    echo "Fetching country statistics...\n";
    $countryStats = $db->getCountryStats(10);
    
    if ($countryStats) {
        echo "Top countries:\n";
        foreach ($countryStats as $index => $country) {
            echo "  " . ($index + 1) . ". {$country['country']}: {$country['visit_count']} visits\n";
        }
        echo "\n";
    }
    
    // Envoyer le rapport via Telegram
    if (ENABLE_TELEGRAM) {
        echo "Sending Telegram notification...\n";
        $telegram = new TelegramNotifier();
        $telegramSent = $telegram->sendDailyReport($stats, $countryStats);
        echo "Telegram: " . ($telegramSent ? "✅ Sent" : "❌ Failed") . "\n";
    }
    
    // Envoyer le rapport via Email
    if (ENABLE_EMAIL) {
        echo "Sending Email notification...\n";
        $email = new EmailNotifier();
        $emailSent = $email->sendDailyReport($stats, $countryStats);
        echo "Email: " . ($emailSent ? "✅ Sent" : "❌ Failed") . "\n";
    }
    
    echo "\n=== Report generation completed successfully ===\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    error_log("Daily report error: " . $e->getMessage());
    exit(1);
}
?>

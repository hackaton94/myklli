<?php
/**
 * Classe de notification Telegram
 * MYKLI Multi-services
 */

class TelegramNotifier {
    private $botToken;
    private $chatId;
    private $db;

    public function __construct() {
        $this->botToken = TELEGRAM_BOT_TOKEN;
        $this->chatId = TELEGRAM_CHAT_ID;
        $this->db = Database::getInstance();
    }

    public function sendMessage($message, $parseMode = 'HTML') {
        if (!ENABLE_TELEGRAM) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        
        $data = [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => $parseMode,
            'disable_web_page_preview' => true
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $success = ($httpCode == 200);
            $this->db->logNotification('telegram', $message, $success ? 'sent' : 'failed');
            
            return $success;
        } catch (Exception $e) {
            error_log("Telegram notification failed: " . $e->getMessage());
            $this->db->logNotification('telegram', $message, 'failed');
            return false;
        }
    }

    public function sendVisitorAlert($visitorData) {
        $flag = $this->getCountryFlag($visitorData['country_code']);
        
        $message = "🔔 <b>Nouveau Visiteur sur MYKLI Multi-services</b>\n\n";
        $message .= "🌍 <b>Pays:</b> {$flag} {$visitorData['country']}\n";
        $message .= "🏙️ <b>Ville:</b> {$visitorData['city']}\n";
        $message .= "📍 <b>Région:</b> {$visitorData['region']}\n";
        $message .= "🌐 <b>IP:</b> <code>{$visitorData['ip_address']}</code>\n";
        $message .= "💻 <b>Navigateur:</b> {$visitorData['browser']}\n";
        $message .= "📱 <b>Appareil:</b> {$visitorData['device']}\n";
        $message .= "🕐 <b>Heure:</b> " . date('d/m/Y H:i:s') . "\n";
        $message .= "📄 <b>Page:</b> {$visitorData['page_url']}\n";

        return $this->sendMessage($message);
    }

    public function sendDailyReport($stats, $countryStats) {
        $message = "📊 <b>Rapport Quotidien - MYKLI Multi-services</b>\n";
        $message .= "📅 <b>Date:</b> " . date('d/m/Y') . "\n\n";
        
        $message .= "📈 <b>Statistiques:</b>\n";
        $message .= "👥 Visiteurs uniques: <b>{$stats['unique_visitors']}</b>\n";
        $message .= "🔄 Visites totales: <b>{$stats['total_visits']}</b>\n";
        $message .= "🌍 Pays différents: <b>{$stats['countries_count']}</b>\n\n";
        
        if (!empty($countryStats)) {
            $message .= "🌎 <b>Top Pays:</b>\n";
            foreach ($countryStats as $index => $country) {
                $flag = $this->getCountryFlag($country['country_code']);
                $message .= ($index + 1) . ". {$flag} {$country['country']}: <b>{$country['visit_count']}</b> visites\n";
            }
        }

        return $this->sendMessage($message);
    }

    private function getCountryFlag($countryCode) {
        if (empty($countryCode) || strlen($countryCode) !== 2) {
            return '🌍';
        }
        
        $countryCode = strtoupper($countryCode);
        $firstLetter = mb_chr(ord($countryCode[0]) - ord('A') + 0x1F1E6);
        $secondLetter = mb_chr(ord($countryCode[1]) - ord('A') + 0x1F1E6);
        
        return $firstLetter . $secondLetter;
    }
}
?>

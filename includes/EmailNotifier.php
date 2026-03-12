<?php
/**
 * Classe de notification Email
 * MYKLI Multi-services
 */

class EmailNotifier {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function sendVisitorAlert($visitorData) {
        if (!ENABLE_EMAIL) {
            return false;
        }

        $subject = "🔔 Nouveau visiteur sur MYKLI Multi-services";
        
        $message = $this->getEmailTemplate([
            'title' => 'Nouveau Visiteur Détecté',
            'content' => $this->formatVisitorData($visitorData)
        ]);

        return $this->sendEmail(EMAIL_TO, $subject, $message);
    }

    public function sendDailyReport($stats, $countryStats) {
        if (!ENABLE_EMAIL) {
            return false;
        }

        $subject = "📊 Rapport quotidien - " . date('d/m/Y');
        
        $content = $this->formatDailyReport($stats, $countryStats);
        $message = $this->getEmailTemplate([
            'title' => 'Rapport Quotidien',
            'content' => $content
        ]);

        return $this->sendEmail(EMAIL_TO, $subject, $message);
    }

    private function sendEmail($to, $subject, $message) {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            'From: ' . EMAIL_FROM_NAME . ' <' . EMAIL_FROM . '>',
            'Reply-To: ' . EMAIL_FROM,
            'X-Mailer: PHP/' . phpversion()
        ];

        try {
            $success = mail($to, $subject, $message, implode("\r\n", $headers));
            $this->db->logNotification('email', $subject, $success ? 'sent' : 'failed');
            return $success;
        } catch (Exception $e) {
            error_log("Email notification failed: " . $e->getMessage());
            $this->db->logNotification('email', $subject, 'failed');
            return false;
        }
    }

    private function formatVisitorData($data) {
        $html = '<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">';
        $html .= '<h3 style="color: #2563eb; margin-top: 0;">Informations du Visiteur</h3>';
        $html .= '<table style="width: 100%; border-collapse: collapse;">';
        
        $fields = [
            ['label' => '🌍 Pays', 'value' => $data['country']],
            ['label' => '🏙️ Ville', 'value' => $data['city']],
            ['label' => '📍 Région', 'value' => $data['region']],
            ['label' => '🌐 Adresse IP', 'value' => $data['ip_address']],
            ['label' => '💻 Navigateur', 'value' => $data['browser']],
            ['label' => '📱 Système', 'value' => $data['os']],
            ['label' => '📱 Appareil', 'value' => $data['device']],
            ['label' => '🕐 Date/Heure', 'value' => date('d/m/Y H:i:s')],
            ['label' => '📄 Page visitée', 'value' => $data['page_url']]
        ];

        foreach ($fields as $field) {
            $html .= '<tr>';
            $html .= '<td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: bold;">' . $field['label'] . '</td>';
            $html .= '<td style="padding: 8px; border-bottom: 1px solid #dee2e6;">' . htmlspecialchars($field['value']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table></div>';
        return $html;
    }

    private function formatDailyReport($stats, $countryStats) {
        $html = '<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">';
        $html .= '<h3 style="color: #2563eb; margin-top: 0;">📈 Statistiques du Jour</h3>';
        
        $html .= '<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin: 20px 0;">';
        $html .= '<div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">';
        $html .= '<div style="font-size: 2em; color: #2563eb; font-weight: bold;">' . $stats['unique_visitors'] . '</div>';
        $html .= '<div style="color: #6b7280;">Visiteurs Uniques</div>';
        $html .= '</div>';
        
        $html .= '<div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">';
        $html .= '<div style="font-size: 2em; color: #10b981; font-weight: bold;">' . $stats['total_visits'] . '</div>';
        $html .= '<div style="color: #6b7280;">Visites Totales</div>';
        $html .= '</div>';
        
        $html .= '<div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">';
        $html .= '<div style="font-size: 2em; color: #f59e0b; font-weight: bold;">' . $stats['countries_count'] . '</div>';
        $html .= '<div style="color: #6b7280;">Pays Différents</div>';
        $html .= '</div>';
        $html .= '</div>';

        if (!empty($countryStats)) {
            $html .= '<h3 style="color: #2563eb;">🌎 Top Pays</h3>';
            $html .= '<table style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px;">';
            
            foreach ($countryStats as $index => $country) {
                $html .= '<tr>';
                $html .= '<td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">' . ($index + 1) . '</td>';
                $html .= '<td style="padding: 12px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">' . htmlspecialchars($country['country']) . '</td>';
                $html .= '<td style="padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: right; color: #2563eb; font-weight: bold;">' . $country['visit_count'] . ' visites</td>';
                $html .= '</tr>';
            }
            
            $html .= '</table>';
        }
        
        $html .= '</div>';
        return $html;
    }

    private function getEmailTemplate($data) {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $data['title'] . '</title>
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
            <div style="max-width: 600px; margin: 0 auto; background-color: white;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                    <h1 style="color: white; margin: 0; font-size: 24px;">MYKLI Multi-services</h1>
                    <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0;">' . $data['title'] . '</p>
                </div>
                <div style="padding: 30px;">
                    ' . $data['content'] . '
                </div>
                <div style="background-color: #f9fafb; padding: 20px; text-align: center; color: #6b7280; font-size: 14px;">
                    <p style="margin: 0;">© ' . date('Y') . ' MYKLI Multi-services. Tous droits réservés.</p>
                    <p style="margin: 10px 0 0 0;">
                        <a href="' . SITE_URL . '" style="color: #2563eb; text-decoration: none;">Visiter le site</a>
                    </p>
                </div>
            </div>
        </body>
        </html>';
    }
}
?>

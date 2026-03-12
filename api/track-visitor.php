<?php
/**
 * API de tracking des visiteurs
 * MYKLI Multi-services
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/TelegramNotifier.php';
require_once '../includes/EmailNotifier.php';

// Fonction pour obtenir l'IP réelle du visiteur
function getRealIP() {
    $ipKeys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER)) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
    }

    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// Fonction pour obtenir les informations de géolocalisation
function getGeoLocation($ip) {
    $url = IP_API_URL . $ip . '?fields=status,country,countryCode,region,city,lat,lon,timezone,isp';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data && $data['status'] === 'success') {
            return $data;
        }
    }

    return null;
}

// Fonction pour parser le User Agent
function parseUserAgent($userAgent) {
    $browser = 'Unknown';
    $os = 'Unknown';
    $device = 'Desktop';

    // Détection du navigateur
    if (preg_match('/MSIE|Trident/i', $userAgent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Edge/i', $userAgent)) {
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/Firefox/i', $userAgent)) {
        $browser = 'Firefox';
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $browser = 'Chrome';
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
        $browser = 'Opera';
    }

    // Détection du système d'exploitation
    if (preg_match('/Windows/i', $userAgent)) {
        $os = 'Windows';
    } elseif (preg_match('/Mac/i', $userAgent)) {
        $os = 'MacOS';
    } elseif (preg_match('/Linux/i', $userAgent)) {
        $os = 'Linux';
    } elseif (preg_match('/Android/i', $userAgent)) {
        $os = 'Android';
        $device = 'Mobile';
    } elseif (preg_match('/iOS|iPhone|iPad/i', $userAgent)) {
        $os = 'iOS';
        $device = 'Mobile';
    }

    // Détection du type d'appareil
    if (preg_match('/Mobile|Android|iPhone/i', $userAgent)) {
        $device = 'Mobile';
    } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
        $device = 'Tablet';
    }

    return [
        'browser' => $browser,
        'os' => $os,
        'device' => $device
    ];
}

try {
    // Récupérer les données POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    $ip = getRealIP();
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
    $pageUrl = $input['page_url'] ?? '';
    $sessionId = $input['session_id'] ?? session_id();

    // Obtenir la géolocalisation
    $geoData = getGeoLocation($ip);
    
    // Parser le User Agent
    $uaData = parseUserAgent($userAgent);

    // Préparer les données du visiteur
    $visitorData = [
        'ip_address' => $ip,
        'country' => $geoData['country'] ?? 'Unknown',
        'country_code' => $geoData['countryCode'] ?? '',
        'region' => $geoData['region'] ?? '',
        'city' => $geoData['city'] ?? 'Unknown',
        'latitude' => $geoData['lat'] ?? null,
        'longitude' => $geoData['lon'] ?? null,
        'timezone' => $geoData['timezone'] ?? '',
        'isp' => $geoData['isp'] ?? '',
        'user_agent' => $userAgent,
        'browser' => $uaData['browser'],
        'os' => $uaData['os'],
        'device' => $uaData['device'],
        'referrer' => $referrer,
        'page_url' => $pageUrl,
        'session_id' => $sessionId
    ];

    // Enregistrer dans la base de données
    $db = Database::getInstance();
    $visitorId = $db->insertVisitor($visitorData);

    if ($visitorId) {
        // Envoyer les notifications
        $telegram = new TelegramNotifier();
        $telegram->sendVisitorAlert($visitorData);

        $email = new EmailNotifier();
        $email->sendVisitorAlert($visitorData);

        echo json_encode([
            'success' => true,
            'message' => 'Visitor tracked successfully',
            'visitor_id' => $visitorId
        ]);
    } else {
        throw new Exception('Failed to insert visitor data');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>

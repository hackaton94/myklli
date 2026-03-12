<?php
/**
 * Script pour obtenir votre Chat ID Telegram
 * MYKLI Multi-services
 */

require_once 'config/config.php';

echo "<html><head><meta charset='UTF-8'><title>Obtenir Chat ID Telegram</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0; }
    h1 { color: #2563eb; }
    code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    .chat-id { font-size: 1.5em; font-weight: bold; color: #2563eb; background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0; }
    .step { background: white; padding: 15px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #2563eb; }
</style></head><body>";

echo "<h1>📱 Obtenir votre Chat ID Telegram</h1>";

$botToken = TELEGRAM_BOT_TOKEN;

// Vérifier que le token est configuré
if ($botToken === 'VOTRE_BOT_TOKEN_ICI' || empty($botToken)) {
    echo "<div class='error'>❌ Le token Telegram n'est pas configuré dans config/config.php</div>";
    exit;
}

echo "<div class='info'>";
echo "<strong>Token configuré :</strong> " . substr($botToken, 0, 20) . "...";
echo "</div>";

// Étape 1: Vérifier le bot
echo "<div class='step'>";
echo "<h2>Étape 1 : Vérification du Bot</h2>";

$url = "https://api.telegram.org/bot{$botToken}/getMe";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if ($data['ok']) {
        echo "<div class='success'>✅ Bot vérifié avec succès!</div>";
        echo "<p><strong>Nom du bot :</strong> " . $data['result']['first_name'] . "</p>";
        echo "<p><strong>Username :</strong> @" . $data['result']['username'] . "</p>";
    } else {
        echo "<div class='error'>❌ Erreur : " . $data['description'] . "</div>";
        exit;
    }
} else {
    echo "<div class='error'>❌ Impossible de se connecter à Telegram. Vérifiez votre connexion internet.</div>";
    exit;
}
echo "</div>";

// Étape 2: Obtenir les messages
echo "<div class='step'>";
echo "<h2>Étape 2 : Récupération du Chat ID</h2>";

$url = "https://api.telegram.org/bot{$botToken}/getUpdates";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data['ok'] && !empty($data['result'])) {
    echo "<div class='success'>✅ Messages trouvés!</div>";
    
    // Récupérer le dernier chat ID
    $lastUpdate = end($data['result']);
    $chatId = null;
    
    if (isset($lastUpdate['message']['chat']['id'])) {
        $chatId = $lastUpdate['message']['chat']['id'];
    } elseif (isset($lastUpdate['channel_post']['chat']['id'])) {
        $chatId = $lastUpdate['channel_post']['chat']['id'];
    }
    
    if ($chatId) {
        echo "<div class='success'>";
        echo "<h3>🎉 Votre Chat ID :</h3>";
        echo "<div class='chat-id'>" . $chatId . "</div>";
        echo "</div>";
        
        echo "<div class='warning'>";
        echo "<h3>📝 Prochaine étape :</h3>";
        echo "<p>Copiez ce Chat ID et collez-le dans <code>config/config.php</code> :</p>";
        echo "<pre style='background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
        echo "define('TELEGRAM_CHAT_ID', '{$chatId}');</pre>";
        echo "</div>";
        
        // Tester l'envoi d'un message
        echo "<div class='step'>";
        echo "<h2>Étape 3 : Test d'Envoi de Message</h2>";
        
        $testMessage = "🎉 <b>Configuration réussie!</b>\n\n";
        $testMessage .= "✅ Votre bot MYKLI Visitor Tracker est maintenant opérationnel!\n\n";
        $testMessage .= "Vous recevrez des notifications pour chaque visiteur sur votre site.\n\n";
        $testMessage .= "🌐 Site: https://mykli.netlify.app";
        
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $postData = [
            'chat_id' => $chatId,
            'text' => $testMessage,
            'parse_mode' => 'HTML'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if ($result['ok']) {
            echo "<div class='success'>✅ Message de test envoyé avec succès! Vérifiez votre Telegram.</div>";
        } else {
            echo "<div class='error'>❌ Échec de l'envoi du message de test.</div>";
        }
        echo "</div>";
        
    } else {
        echo "<div class='error'>❌ Impossible de trouver le Chat ID dans les messages.</div>";
    }
    
} else {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Aucun message trouvé</h3>";
    echo "<p>Pour obtenir votre Chat ID, vous devez :</p>";
    echo "<ol>";
    echo "<li>Ouvrir Telegram</li>";
    echo "<li>Chercher votre bot : <strong>@" . ($data['result']['username'] ?? 'votre_bot') . "</strong></li>";
    echo "<li>Cliquer sur <strong>Démarrer</strong> ou envoyer n'importe quel message</li>";
    echo "<li>Actualiser cette page</li>";
    echo "</ol>";
    echo "</div>";
}
echo "</div>";

// Instructions finales
echo "<div class='step'>";
echo "<h2>📚 Prochaines Étapes</h2>";
echo "<ol>";
echo "<li>Copiez le Chat ID ci-dessus</li>";
echo "<li>Ouvrez <code>config/config.php</code></li>";
echo "<li>Remplacez <code>VOTRE_CHAT_ID_ICI</code> par votre Chat ID</li>";
echo "<li>Exécutez <code>setup.php</code> pour créer la base de données</li>";
echo "<li>Testez le système en visitant votre site</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";
?>

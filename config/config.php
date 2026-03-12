<?php
/**
 * Configuration du système de tracking des visiteurs
 * MYKLI Multi-services
 */

// Configuration de la base de données
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mykli_visitors');
define('DB_USER', 'root');
define('DB_PASS', ''); // Vide par défaut sur WampServer

// Configuration Telegram
define('TELEGRAM_BOT_TOKEN', '8239831330:AAHo0o5pKbTzBSWS2cHbBWUQ8sxqSkQcgic');
define('TELEGRAM_CHAT_ID', '5754679801');

// Configuration Email
define('EMAIL_TO', 'senermite89@gmail.com');
define('EMAIL_FROM', 'noreply@mykli.com');
define('EMAIL_FROM_NAME', 'MYKLI Multi-services');

// Configuration WhatsApp (via API Twilio ou autre service)
define('WHATSAPP_API_KEY', 'VOTRE_API_KEY_ICI');
define('WHATSAPP_NUMBER', '+243XXXXXXXXX'); // Votre numéro WhatsApp

// Configuration générale
define('SITE_URL', 'https://mykli.netlify.app');
define('SITE_URL_LOCAL', 'http://localhost/MykliMultiservices'); // Pour tests locaux
define('TIMEZONE', 'Africa/Abidjan'); // Côte d'Ivoire (GMT+0)

// Activer/Désactiver les notifications
define('ENABLE_TELEGRAM', true);
define('ENABLE_EMAIL', true);
define('ENABLE_WHATSAPP', false); // Nécessite un service payant

// Fréquence des rapports (en minutes)
define('REPORT_FREQUENCY', 60); // Rapport toutes les heures

// API de géolocalisation (gratuite)
define('IP_API_URL', 'http://ip-api.com/json/');

date_default_timezone_set(TIMEZONE);
?>

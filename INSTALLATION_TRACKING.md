# 📊 Guide d'Installation - Système de Tracking des Visiteurs
## MYKLI Multi-services

---

## 🚀 Installation Rapide

### Étape 1: Configuration de la Base de Données

1. **Ouvrir phpMyAdmin** : `http://localhost/phpmyadmin`

2. **Exécuter le script SQL** :
   - Ouvrir le fichier `config/database.sql`
   - Copier tout le contenu
   - Coller dans l'onglet SQL de phpMyAdmin
   - Cliquer sur "Exécuter"

3. **Vérifier la création** :
   - La base de données `mykli_visitors` doit être créée
   - 3 tables doivent être présentes : `visitors`, `daily_stats`, `notifications_log`

---

### Étape 2: Configuration de Telegram (Recommandé)

#### A. Créer un Bot Telegram

1. **Ouvrir Telegram** et rechercher `@BotFather`

2. **Créer un nouveau bot** :
   ```
   /newbot
   ```

3. **Suivre les instructions** :
   - Nom du bot : `MYKLI Visitor Tracker`
   - Username : `mykli_tracker_bot` (doit finir par _bot)

4. **Copier le Token** :
   - Vous recevrez un token comme : `123456789:ABCdefGHIjklMNOpqrsTUVwxyz`

#### B. Obtenir votre Chat ID

1. **Envoyer un message** à votre bot (n'importe quel message)

2. **Visiter cette URL** dans votre navigateur :
   ```
  
  
   Remplacez `<VOTRE_TOKEN>` par votre token

3. **Trouver le Chat ID** :
   - Cherchez `"chat":{"id":123456789`
   - Le nombre après `"id":` est votre Chat ID

#### C. Configurer dans le code

Ouvrir `config/config.php` et modifier :
```php
define('TELEGRAM_BOT_TOKEN', 'VOTRE_TOKEN_ICI');
define('TELEGRAM_CHAT_ID', 'VOTRE_CHAT_ID_ICI');
```

---

### Étape 3: Configuration Email

Ouvrir `config/config.php` et modifier :
```php
define('EMAIL_TO', 'votre-email@example.com');
define('EMAIL_FROM', 'noreply@mykli.com');
```

**Note** : Pour que les emails fonctionnent, vous devez configurer un serveur SMTP sur WampServer ou utiliser une bibliothèque comme PHPMailer.

---

### Étape 4: Tester le Système

1. **Visiter votre site** : `http://localhost/MykliMultiservices/`

2. **Vérifier dans la console du navigateur** :
   ```
   ✅ Visitor tracked successfully
   ```

3. **Vérifier Telegram** :
   - Vous devriez recevoir une notification avec les détails du visiteur

4. **Vérifier la base de données** :
   - Ouvrir phpMyAdmin
   - Table `visitors` doit contenir une nouvelle entrée

---

### Étape 5: Accéder au Dashboard

1. **URL** : `http://localhost/MykliMultiservices/admin/dashboard.php`

2. **Mot de passe par défaut** : `mykli2025`

3. **⚠️ IMPORTANT** : Changez ce mot de passe dans `admin/dashboard.php` :
   ```php
   $admin_password = 'VOTRE_NOUVEAU_MOT_DE_PASSE';
   ```

---

## 📅 Configuration des Rapports Automatiques

### Option 1: Windows Task Scheduler (Recommandé pour Windows)

1. **Ouvrir Task Scheduler** : Rechercher "Planificateur de tâches"

2. **Créer une tâche de base** :
   - Nom : "MYKLI Daily Report"
   - Déclencheur : Quotidien à 20h00
   - Action : Démarrer un programme

3. **Configurer l'action** :
   - Programme : `C:\wamp64\bin\php\php8.x.x\php.exe`
   - Arguments : `C:\wamp64\www\MykliMultiservices\cron\daily-report.php`

### Option 2: Exécution Manuelle

Ouvrir PowerShell et exécuter :
```powershell
cd C:\wamp64\www\MykliMultiservices\cron
php daily-report.php
```

---

## 🔧 Configuration Avancée

### Activer/Désactiver les Notifications

Dans `config/config.php` :
```php
define('ENABLE_TELEGRAM', true);  // Activer Telegram
define('ENABLE_EMAIL', true);     // Activer Email
define('ENABLE_WHATSAPP', false); // WhatsApp (nécessite service payant)
```

### Changer la Fréquence des Rapports

```php
define('REPORT_FREQUENCY', 60); // En minutes (60 = 1 heure)
```

### Personnaliser le Fuseau Horaire

```php
define('TIMEZONE', 'Africa/Kinshasa'); // RDC
// Autres options :
// 'Africa/Abidjan'  - Côte d'Ivoire
// 'Africa/Dakar'    - Sénégal
// 'Europe/Paris'    - France
```

---

## 📱 Configuration WhatsApp (Optionnel - Service Payant)

Pour utiliser WhatsApp, vous devez utiliser un service comme :

### Option 1: Twilio
1. Créer un compte sur https://www.twilio.com
2. Obtenir un numéro WhatsApp Business
3. Configurer l'API Key dans `config/config.php`

### Option 2: WhatsApp Business API
1. S'inscrire à WhatsApp Business API
2. Obtenir les credentials
3. Modifier `includes/WhatsAppNotifier.php` (à créer)

---

## 🔍 Vérification et Dépannage

### Vérifier que tout fonctionne

1. **Base de données** :
   ```sql
   SELECT COUNT(*) FROM mykli_visitors.visitors;
   ```

2. **Logs PHP** :
   - Vérifier `C:\wamp64\logs\php_error.log`

3. **Test Telegram** :
   ```php
   // Créer test-telegram.php
   <?php
   require_once 'config/config.php';
   require_once 'includes/Database.php';
   require_once 'includes/TelegramNotifier.php';
   
   $telegram = new TelegramNotifier();
   $result = $telegram->sendMessage("🧪 Test de notification MYKLI");
   echo $result ? "✅ Succès" : "❌ Échec";
   ?>
   ```

### Problèmes Courants

#### ❌ "Database connection failed"
- Vérifier que MySQL est démarré dans WampServer
- Vérifier les credentials dans `config/config.php`

#### ❌ "Telegram notification failed"
- Vérifier le Token et Chat ID
- Tester l'URL : `https://api.telegram.org/bot<TOKEN>/getMe`

#### ❌ "Email not sent"
- Configurer un serveur SMTP
- Ou installer PHPMailer pour utiliser Gmail/Outlook

---

## 📊 Utilisation du Dashboard

### Fonctionnalités

- **Statistiques en temps réel** : Visiteurs, visites, pays
- **Top pays** : Classement des pays par nombre de visites
- **Visiteurs récents** : Liste des 20 derniers visiteurs
- **Auto-refresh** : Actualisation automatique toutes les 30 secondes

### Sécurité

⚠️ **IMPORTANT** : En production, implémentez :
1. Authentification forte (base de données)
2. HTTPS obligatoire
3. Protection CSRF
4. Rate limiting
5. Logs d'accès admin

---

## 🎯 Fonctionnalités du Système

### Données Collectées

✅ **Géolocalisation** :
- Pays, région, ville
- Coordonnées GPS
- Fuseau horaire
- Fournisseur d'accès (ISP)

✅ **Informations Techniques** :
- Adresse IP
- Navigateur
- Système d'exploitation
- Type d'appareil (Mobile/Desktop/Tablet)

✅ **Comportement** :
- Page visitée
- Référent (d'où vient le visiteur)
- Temps passé sur le site
- Clics sur les éléments

### Notifications

📱 **Telegram** : Notification instantanée à chaque visiteur
📧 **Email** : Rapport quotidien détaillé
📊 **Dashboard** : Statistiques en temps réel

---

## 🔐 Sécurité et Confidentialité

### Conformité RGPD

Pour être conforme au RGPD, ajoutez :

1. **Bannière de cookies** sur le site
2. **Politique de confidentialité** mentionnant le tracking
3. **Option de désactivation** pour les visiteurs
4. **Anonymisation des IP** après 30 jours

### Protection des Données

- Chiffrer les données sensibles
- Limiter l'accès au dashboard
- Sauvegardes régulières de la base de données
- Supprimer les anciennes données (>90 jours)

---

## 📞 Support

Pour toute question ou problème :

1. Vérifier les logs : `C:\wamp64\logs\`
2. Consulter la documentation PHP
3. Tester les APIs individuellement

---

## 🎉 Félicitations !

Votre système de tracking est maintenant opérationnel ! 

Vous recevrez des notifications pour chaque visiteur et des rapports quotidiens sur Telegram et par email.

**Prochaines étapes recommandées** :
- Sécuriser le dashboard avec une vraie authentification
- Configurer les rapports automatiques
- Personnaliser les messages de notification
- Ajouter des graphiques au dashboard

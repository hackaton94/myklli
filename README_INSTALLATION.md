# 🚀 Installation Rapide - Système de Tracking MYKLI

## ⚡ Installation en 2 Minutes

### **Étape 1 : Exécuter le Script d'Installation**

Ouvrez votre navigateur et allez sur :

```
http://localhost/MykliMultiservices/setup.php
```

Ce script va automatiquement :
- ✅ Vérifier la connexion MySQL
- ✅ Créer la base de données `mykli_visitors`
- ✅ Créer toutes les tables nécessaires
- ✅ Vérifier que tout fonctionne

### **Étape 2 : Accéder au Dashboard**

Une fois l'installation terminée, cliquez sur le lien fourni ou allez sur :

```
http://localhost/MykliMultiservices/admin/dashboard.php
```

**Mot de passe :** `mykli2025`

---

## 📱 Configuration Telegram (Optionnel - 5 minutes)

### **1. Créer un Bot Telegram**

1. Ouvrir Telegram et chercher `@BotFather`
2. Envoyer `/newbot`
3. Suivre les instructions
4. **Copier le Token** reçu

### **2. Obtenir votre Chat ID**

1. Envoyer un message à votre bot
2. Visiter cette URL dans votre navigateur :
   ```
   https://api.telegram.org/bot<VOTRE_TOKEN>/getUpdates
   ```
3. Chercher `"chat":{"id":123456789`
4. **Copier le Chat ID**

### **3. Configurer**

Ouvrir `config/config.php` et modifier :

```php
define('TELEGRAM_BOT_TOKEN', 'VOTRE_TOKEN_ICI');
define('TELEGRAM_CHAT_ID', 'VOTRE_CHAT_ID_ICI');
```

---

## ✅ C'est Tout !

Le système est maintenant opérationnel !

### **Tester le Tracking**

Visitez votre site : `http://localhost/MykliMultiservices/`

Vous devriez :
- ✅ Voir dans la console : `✅ Visitor tracked successfully`
- ✅ Recevoir une notification Telegram (si configuré)
- ✅ Voir le visiteur dans le dashboard

---

## 🔧 En Cas de Problème

### **Erreur de connexion à la base de données**

1. Vérifier que WampServer est démarré (icône verte)
2. Ré-exécuter `setup.php`

### **Telegram ne fonctionne pas**

1. Vérifier le Token et Chat ID dans `config/config.php`
2. Tester l'URL : `https://api.telegram.org/bot<TOKEN>/getMe`

### **Le dashboard ne s'affiche pas**

1. Vérifier que la base de données est créée dans phpMyAdmin
2. Vérifier les logs : `C:\wamp64\logs\php_error.log`

---

## 📚 Documentation Complète

Pour plus de détails, consultez : `INSTALLATION_TRACKING.md`

---

## 🎉 Profitez du Système !

Vous recevez maintenant :
- 📊 Statistiques en temps réel
- 📱 Notifications Telegram instantanées
- 📧 Rapports quotidiens par email
- 🌍 Géolocalisation des visiteurs

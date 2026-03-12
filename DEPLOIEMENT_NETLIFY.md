# 🚀 Déploiement du Système de Tracking sur Netlify

## ⚠️ Information Importante

**Netlify est un hébergeur de sites statiques (HTML, CSS, JavaScript uniquement).**

Le système de tracking PHP que nous avons créé nécessite un serveur avec support PHP et MySQL, ce qui n'est **pas disponible sur Netlify**.

---

## 🎯 Solutions pour le Tracking avec Netlify

### **Option 1 : Backend Séparé (Recommandé)**

Héberger le backend PHP sur un serveur différent et connecter votre site Netlify à ce backend.

#### **Hébergeurs PHP Gratuits :**
- **InfinityFree** : https://infinityfree.net (Gratuit, PHP + MySQL)
- **000webhost** : https://www.000webhost.com (Gratuit, PHP + MySQL)
- **Hostinger** : https://www.hostinger.com (Payant, très performant)
- **OVH** : https://www.ovh.com (Payant, français)

#### **Configuration :**

1. **Héberger le backend PHP** sur InfinityFree/000webhost
2. **Uploader ces dossiers** :
   - `api/`
   - `includes/`
   - `config/`
   - `admin/`
   - `cron/`

3. **Modifier `js/visitor-tracker.js`** sur Netlify :
   ```javascript
   // Remplacer
   fetch('/MykliMultiservices/api/track-visitor.php', {
   
   // Par
   fetch('https://votre-backend.infinityfree.net/api/track-visitor.php', {
   ```

4. **Activer CORS** sur le backend PHP (dans `api/track-visitor.php`) :
   ```php
   header('Access-Control-Allow-Origin: https://mykli.netlify.app');
   ```

---

### **Option 2 : Services Tiers (Plus Simple)**

Utiliser des services de tracking existants :

#### **A. Google Analytics (Gratuit)**
```html
<!-- Ajouter dans index.html -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

#### **B. Plausible Analytics (Respectueux de la vie privée)**
- Site : https://plausible.io
- Alternative à Google Analytics
- Respecte le RGPD

#### **C. Netlify Analytics (Payant - 9$/mois)**
- Intégré directement dans Netlify
- Pas besoin de code supplémentaire

---

### **Option 3 : Serverless Functions (Avancé)**

Utiliser les Netlify Functions (AWS Lambda) :

1. **Créer un dossier** `netlify/functions/`

2. **Créer** `netlify/functions/track-visitor.js` :
   ```javascript
   const fetch = require('node-fetch');
   
   exports.handler = async (event) => {
     // Envoyer directement à Telegram
     const telegramToken = process.env.TELEGRAM_BOT_TOKEN;
     const chatId = process.env.TELEGRAM_CHAT_ID;
     
     const data = JSON.parse(event.body);
     
     const message = `🔔 Nouveau visiteur
     IP: ${data.ip}
     Pays: ${data.country}`;
     
     await fetch(`https://api.telegram.org/bot${telegramToken}/sendMessage`, {
       method: 'POST',
       headers: { 'Content-Type': 'application/json' },
       body: JSON.stringify({
         chat_id: chatId,
         text: message
       })
     });
     
     return {
       statusCode: 200,
       body: JSON.stringify({ success: true })
     };
   };
   ```

3. **Configurer les variables d'environnement** dans Netlify :
   - `TELEGRAM_BOT_TOKEN`
   - `TELEGRAM_CHAT_ID`

---

## 📋 Plan d'Action Recommandé

### **Pour un Tracking Complet (avec Dashboard)**

1. ✅ **Site web** : Netlify (https://mykli.netlify.app)
2. ✅ **Backend PHP** : InfinityFree ou 000webhost (gratuit)
3. ✅ **Base de données** : MySQL sur l'hébergeur PHP
4. ✅ **Notifications** : Telegram (gratuit, instantané)

### **Étapes :**

#### **1. Créer un compte sur InfinityFree**
- Aller sur https://infinityfree.net
- S'inscrire gratuitement
- Créer un site web

#### **2. Uploader les fichiers PHP**
Via FTP (FileZilla) :
- `api/track-visitor.php`
- `includes/Database.php`
- `includes/TelegramNotifier.php`
- `includes/EmailNotifier.php`
- `config/config.php`
- `admin/dashboard.php`
- `setup.php`

#### **3. Créer la base de données**
- Dans le panel InfinityFree
- Créer une base MySQL
- Exécuter `config/database.sql`

#### **4. Mettre à jour config.php**
```php
define('DB_HOST', 'sql123.infinityfree.net'); // Fourni par InfinityFree
define('DB_NAME', 'ifXXXXX_mykli');
define('DB_USER', 'ifXXXXX_user');
define('DB_PASS', 'votre_mot_de_passe');
```

#### **5. Modifier visitor-tracker.js sur Netlify**
```javascript
fetch('https://votre-site.infinityfree.net/api/track-visitor.php', {
```

#### **6. Tester**
- Visiter https://mykli.netlify.app
- Vérifier les notifications Telegram
- Accéder au dashboard : https://votre-site.infinityfree.net/admin/dashboard.php

---

## 🎯 Solution Rapide (Sans Backend)

Si vous voulez juste des notifications Telegram sans dashboard :

### **Créer** `netlify/functions/track.js` :

```javascript
const fetch = require('node-fetch');

exports.handler = async (event) => {
  const TELEGRAM_TOKEN = process.env.TELEGRAM_BOT_TOKEN;
  const CHAT_ID = process.env.TELEGRAM_CHAT_ID;
  
  const data = JSON.parse(event.body);
  const ip = event.headers['x-forwarded-for'] || event.headers['client-ip'];
  
  // Obtenir la géolocalisation
  const geoResponse = await fetch(`http://ip-api.com/json/${ip}`);
  const geo = await geoResponse.json();
  
  const message = `🔔 Nouveau visiteur sur MYKLI

🌍 Pays: ${geo.country}
🏙️ Ville: ${geo.city}
🌐 IP: ${ip}
📄 Page: ${data.page_url}
🕐 Heure: ${new Date().toLocaleString('fr-FR', {timeZone: 'Africa/Abidjan'})}`;

  await fetch(`https://api.telegram.org/bot${TELEGRAM_TOKEN}/sendMessage`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      chat_id: CHAT_ID,
      text: message,
      parse_mode: 'HTML'
    })
  });
  
  return {
    statusCode: 200,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ success: true })
  };
};
```

### **Modifier** `js/visitor-tracker.js` :
```javascript
fetch('/.netlify/functions/track', {
```

### **Configurer dans Netlify** :
- Site Settings → Environment Variables
- Ajouter `TELEGRAM_BOT_TOKEN` et `TELEGRAM_CHAT_ID`

---

## 📊 Comparaison des Solutions

| Solution | Coût | Dashboard | Notifications | Difficulté |
|----------|------|-----------|---------------|------------|
| Backend PHP séparé | Gratuit | ✅ Oui | ✅ Oui | Moyenne |
| Netlify Functions | Gratuit | ❌ Non | ✅ Oui | Facile |
| Google Analytics | Gratuit | ✅ Oui | ❌ Non | Très facile |
| Services tiers | Variable | ✅ Oui | ✅ Oui | Facile |

---

## 🎉 Recommandation Finale

**Pour votre cas (site sur Netlify) :**

1. **Court terme** : Utiliser Netlify Functions pour les notifications Telegram
2. **Long terme** : Héberger le backend PHP sur InfinityFree pour avoir le dashboard complet

**Voulez-vous que je vous aide à configurer l'une de ces solutions ?**

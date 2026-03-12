<?php
/**
 * Tableau de bord des statistiques visiteurs
 * MYKLI Multi-services
 */

require_once '../config/config.php';
require_once '../includes/Database.php';

// Simple authentification (à améliorer en production)
session_start();
$admin_password = 'mykli2025'; // Changez ce mot de passe !

if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $admin_password) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $error = "Mot de passe incorrect";
        }
    }
    
    if (!isset($_SESSION['admin_logged_in'])) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion Admin - MYKLI</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: 'Inter', sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .login-box {
                    background: white;
                    padding: 40px;
                    border-radius: 20px;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                    max-width: 400px;
                    width: 100%;
                }
                h1 { color: #2563eb; margin-bottom: 30px; text-align: center; }
                input {
                    width: 100%;
                    padding: 15px;
                    border: 2px solid #e5e7eb;
                    border-radius: 10px;
                    font-size: 16px;
                    margin-bottom: 20px;
                }
                button {
                    width: 100%;
                    padding: 15px;
                    background: #2563eb;
                    color: white;
                    border: none;
                    border-radius: 10px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s;
                }
                button:hover { background: #1d4ed8; transform: translateY(-2px); }
                .error { color: #ef4444; margin-bottom: 15px; text-align: center; }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h1>🔐 Admin Dashboard</h1>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="POST">
                    <input type="password" name="password" placeholder="Mot de passe" required autofocus>
                    <button type="submit">Se connecter</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

$db = Database::getInstance();
$stats = $db->getTodayStats();
$countryStats = $db->getCountryStats(10);
$recentVisitors = $db->getRecentVisitors(20);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MYKLI Multi-services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 2rem;
            margin-bottom: 5px;
        }
        
        .header p {
            opacity: 0.9;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .stat-icon.blue { background: #dbeafe; color: #2563eb; }
        .stat-icon.green { background: #d1fae5; color: #10b981; }
        .stat-icon.orange { background: #fed7aa; color: #f59e0b; }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        
        tr:hover {
            background: #f9fafb;
        }
        
        .country-flag {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .badge.mobile { background: #dbeafe; color: #2563eb; }
        .badge.desktop { background: #d1fae5; color: #10b981; }
        .badge.tablet { background: #fed7aa; color: #f59e0b; }
        
        .refresh-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .refresh-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            float: right;
        }
        
        .logout-btn:hover {
            background: #dc2626;
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <form method="POST" action="?logout=1" style="display: inline;">
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
            <h1>📊 Dashboard Visiteurs</h1>
            <p>MYKLI Multi-services - Statistiques en temps réel</p>
        </div>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value"><?php echo number_format($stats['unique_visitors']); ?></div>
                <div class="stat-label">Visiteurs Uniques Aujourd'hui</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-value"><?php echo number_format($stats['total_visits']); ?></div>
                <div class="stat-label">Visites Totales</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stat-value"><?php echo number_format($stats['countries_count']); ?></div>
                <div class="stat-label">Pays Différents</div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-flag"></i>
                Top Pays
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pays</th>
                        <th>Visites</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($countryStats as $index => $country): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td>
                            <span class="country-flag"><?php echo $country['country_code']; ?></span>
                            <?php echo htmlspecialchars($country['country']); ?>
                        </td>
                        <td><strong><?php echo number_format($country['visit_count']); ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-clock"></i>
                Visiteurs Récents
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Pays</th>
                        <th>Ville</th>
                        <th>Navigateur</th>
                        <th>Appareil</th>
                        <th>Date/Heure</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentVisitors as $visitor): ?>
                    <tr>
                        <td><code><?php echo htmlspecialchars($visitor['ip_address']); ?></code></td>
                        <td><?php echo htmlspecialchars($visitor['country']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['city']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['browser']); ?></td>
                        <td>
                            <span class="badge <?php echo strtolower($visitor['os']); ?>">
                                <?php echo htmlspecialchars($visitor['os']); ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($visitor['visit_date'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button class="refresh-btn" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i>
            Actualiser
        </button>
    </div>

    <script>
        // Auto-refresh toutes les 30 secondes
        setTimeout(() => location.reload(), 30000);
    </script>
</body>
</html>
<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: dashboard.php');
    exit;
}
?>

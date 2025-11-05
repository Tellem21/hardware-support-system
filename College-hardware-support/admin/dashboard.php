<?php
// admin/dashboard.php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Sample data
$stats = [
    'total_tickets' => 24,
    'open_tickets' => 8,
    'in_progress' => 5,
    'resolved' => 11
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - College of Science</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            background: #8B0000;
            color: white;
            padding: 1rem 0;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header-text h1 {
            font-size: 1.5rem;
            margin-bottom: 0.2rem;
        }
        .header-text h2 {
            font-size: 1rem;
            font-weight: 300;
        }
        nav ul {
            display: flex;
            list-style: none;
            margin-top: 1rem;
            gap: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
        }
        nav a:hover, nav a.active {
            background-color: rgba(255,255,255,0.2);
        }
        .welcome-bar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #8B0000;
            display: block;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #8B0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #A52A2A;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .action-card {
            background: white;
            padding: 30px 20px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .action-card:hover {
            background: #f8f9fa;
        }
        footer {
            background: #333;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-container">
                <div class="header-text">
                    <h1>College of Science</h1>
                    <h2>Hardware Support - Admin Dashboard</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="view-tickets.php">View Tickets</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="welcome-bar">
            <div>
                <h1>Welcome, Admin!</h1>
                <p>Hardware Support Ticket System Overview</p>
            </div>
            <div>
                <a href="view-tickets.php" class="btn">Manage Tickets</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number"><?php echo $stats['total_tickets']; ?></span>
                <span>Total Tickets</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $stats['open_tickets']; ?></span>
                <span>Open Tickets</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $stats['in_progress']; ?></span>
                <span>In Progress</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $stats['resolved']; ?></span>
                <span>Resolved</span>
            </div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                <a href="view-tickets.php" class="action-card">
                    <h3>View All Tickets</h3>
                    <p>Manage all support requests</p>
                </a>
                <a href="view-tickets.php?filter=open" class="action-card">
                    <h3>Open Tickets</h3>
                    <p>View pending requests</p>
                </a>
                <a href="view-tickets.php?filter=urgent" class="action-card">
                    <h3>Urgent Issues</h3>
                    <p>Critical problems</p>
                </a>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 College of Science Hardware Support - KNUST</p>
        </div>
    </footer>
</body>
</html>
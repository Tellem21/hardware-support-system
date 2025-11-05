<?php
// admin/view-tickets.php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Sample tickets data
$tickets = [
    [
        'id' => 'CSHW-2024-001',
        'name' => 'Dr. Kwame Osei',
        'department' => 'Physics',
        'issue' => 'Laptop not starting',
        'status' => 'Open',
        'priority' => 'High',
        'date' => '2024-01-15'
    ],
    [
        'id' => 'CSHW-2024-002',
        'name' => 'Prof. Akosua Anokye',
        'department' => 'Chemistry',
        'issue' => 'Printer setup',
        'status' => 'In Progress',
        'priority' => 'Medium',
        'date' => '2024-01-14'
    ],
    [
        'id' => 'CSHW-2024-003',
        'name' => 'Mary Mensah',
        'department' => 'Computer Science',
        'issue' => 'Network connection',
        'status' => 'Resolved',
        'priority' => 'High',
        'date' => '2024-01-13'
    ]
];

// Filter tickets
$filter = $_GET['filter'] ?? 'all';
if ($filter !== 'all') {
    $tickets = array_filter($tickets, function($ticket) use ($filter) {
        if ($filter === 'open') return $ticket['status'] === 'Open';
        if ($filter === 'urgent') return $ticket['priority'] === 'High';
        return true;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tickets - College of Science</title>
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
        .filters {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }
        .filter-btn.active {
            background: #8B0000;
            color: white;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .ticket-table th,
        .ticket-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .ticket-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-open { background: #d4edda; color: #155724; }
        .status-in-progress { background: #fff3cd; color: #856404; }
        .status-resolved { background: #e2e3e5; color: #383d41; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #8B0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
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
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
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
                    <h2>Hardware Support - Manage Tickets</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="view-tickets.php" class="active">View Tickets</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h1>Support Tickets</h1>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="filters">
            <a href="?filter=all" class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">All Tickets</a>
            <a href="?filter=open" class="filter-btn <?php echo $filter === 'open' ? 'active' : ''; ?>">Open</a>
            <a href="?filter=urgent" class="filter-btn <?php echo $filter === 'urgent' ? 'active' : ''; ?>">Urgent</a>
        </div>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Requester</th>
                    <th>Department</th>
                    <th>Issue</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><strong><?php echo $ticket['id']; ?></strong></td>
                    <td><?php echo $ticket['name']; ?></td>
                    <td><?php echo $ticket['department']; ?></td>
                    <td><?php echo $ticket['issue']; ?></td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $ticket['status'])); ?>">
                            <?php echo $ticket['status']; ?>
                        </span>
                    </td>
                    <td><?php echo $ticket['priority']; ?></td>
                    <td><?php echo $ticket['date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (empty($tickets)): ?>
        <div style="text-align: center; padding: 40px; background: white; border-radius: 10px; margin-top: 20px;">
            <h3>No tickets found</h3>
            <p>No tickets match the current filter criteria.</p>
        </div>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 College of Science Hardware Support - KNUST</p>
        </div>
    </footer>
</body>
</html>
<?php
// check-status.php
session_start();

// Sample ticket data (in real application, this would come from database)
$sample_tickets = [
    'CSHW-20240115-1234' => [
        'status' => 'In Progress',
        'name' => 'Dr. Kwame Osei',
        'department' => 'Physics',
        'issue' => 'Laptop not powering on',
        'submitted_date' => '2024-01-15 09:30:00',
        'last_update' => '2024-01-15 14:20:00',
        'assigned_tech' => 'Tech. Ama Serwaa',
        'updates' => [
            ['date' => '2024-01-15 09:30:00', 'message' => 'Ticket submitted'],
            ['date' => '2024-01-15 10:15:00', 'message' => 'Ticket assigned to technician'],
            ['date' => '2024-01-15 14:20:00', 'message' => 'Diagnosis in progress - suspected power supply issue'],
        ]
    ],
    'CSHW-20240114-5678' => [
        'status' => 'Resolved',
        'name' => 'Prof. Akosua Anokye',
        'department' => 'Chemistry',
        'issue' => 'Printer setup required',
        'submitted_date' => '2024-01-14 10:15:00',
        'last_update' => '2024-01-14 16:45:00',
        'assigned_tech' => 'Tech. Kwame Mensah',
        'updates' => [
            ['date' => '2024-01-14 10:15:00', 'message' => 'Ticket submitted'],
            ['date' => '2024-01-14 11:30:00', 'message' => 'Technician dispatched to location'],
            ['date' => '2024-01-14 16:45:00', 'message' => 'Printer setup completed and tested'],
        ]
    ],
    'CSHW-20240113-9012' => [
        'status' => 'Open',
        'name' => 'Mary Mensah',
        'department' => 'Computer Science',
        'issue' => 'Network connectivity issues',
        'submitted_date' => '2024-01-13 14:20:00',
        'last_update' => '2024-01-13 14:20:00',
        'assigned_tech' => 'Not assigned yet',
        'updates' => [
            ['date' => '2024-01-13 14:20:00', 'message' => 'Ticket submitted and awaiting assignment'],
        ]
    ]
];

$ticket_data = null;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_number = strtoupper(trim($_POST['ticket_number'] ?? ''));
    $email = trim($_POST['email'] ?? '');
    
    if (empty($ticket_number) || empty($email)) {
        $error_message = "Please enter both ticket number and email address!";
    } elseif (isset($sample_tickets[$ticket_number])) {
        $ticket_data = $sample_tickets[$ticket_number];
    } else {
        $error_message = "Ticket not found! Please check your ticket number and try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Ticket Status - College of Science</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-container {
            max-width: 1000px;
            margin: 40px auto;
        }
        .search-box {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .search-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .search-header h1 {
            color: #8B0000;
            margin-bottom: 10px;
            font-size: 2.2rem;
        }
        .search-form {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }
        .search-btn {
            background: linear-gradient(135deg, #8B0000, #B22222);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            font-weight: 600;
        }
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
        }
        .ticket-status {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: <?php echo $ticket_data ? 'block' : 'none'; ?>;
        }
        .status-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }
        .ticket-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #8B0000;
        }
        .status-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1rem;
        }
        .status-open { background: #fff3cd; color: #856404; }
        .status-in-progress { background: #cce7ff; color: #004085; }
        .status-resolved { background: #d4edda; color: #155724; }
        .status-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .detail-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #8B0000;
        }
        .detail-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }
        .timeline {
            margin-top: 30px;
        }
        .timeline-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: #333;
        }
        .timeline-item {
            display: flex;
            margin-bottom: 20px;
            position: relative;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: -20px;
            width: 2px;
            background: #e9ecef;
        }
        .timeline-item:last-child:before {
            display: none;
        }
        .timeline-marker {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #8B0000;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }
        .timeline-content {
            flex: 1;
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
        }
        .timeline-date {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        .timeline-message {
            color: #333;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        .help-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
        }
        .help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .help-item {
            text-align: center;
            padding: 20px;
        }
        .help-icon {
            font-size: 2rem;
            color: #8B0000;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-container">
                <div class="header-text">
                    <h1>College of Science</h1>
                    <h2>Hardware Support - Check Status</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="submit-ticket.php">Submit Ticket</a></li>
                    <li><a href="check-status.php" class="active">Check Status</a></li>
                    <li><a href="admin/login.php">Admin Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="status-container">
            <div class="search-box">
                <div class="search-header">
                    <h1><i class="fas fa-search"></i> Check Ticket Status</h1>
                    <p>Enter your ticket number and email to track your support request</p>
                </div>

                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="search-form">
                    <div class="form-group">
                        <label for="ticket_number">Ticket Number</label>
                        <input type="text" class="form-control" id="ticket_number" name="ticket_number" 
                               value="<?php echo htmlspecialchars($_POST['ticket_number'] ?? ''); ?>"
                               placeholder="e.g., CSHW-20240115-1234" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                               placeholder="Enter the email used when submitting ticket" required>
                    </div>

                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Check Status
                    </button>
                </form>

                <div class="help-section">
                    <h3 style="text-align: center; margin-bottom: 20px; color: #8B0000;">
                        <i class="fas fa-question-circle"></i> Need Help?
                    </h3>
                    <div class="help-grid">
                        <div class="help-item">
                            <i class="fas fa-ticket-alt help-icon"></i>
                            <h4>Find Ticket Number</h4>
                            <p>Check your email for the confirmation message with your ticket number</p>
                        </div>
                        <div class="help-item">
                            <i class="fas fa-envelope help-icon"></i>
                            <h4>Wrong Email?</h4>
                            <p>Use the same email address you used when submitting the ticket</p>
                        </div>
                        <div class="help-item">
                            <i class="fas fa-phone help-icon"></i>
                            <h4>Contact Support</h4>
                            <p>Call +233 (0) 3220 60000 if you need immediate assistance</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($ticket_data): ?>
            <div class="ticket-status" id="ticketResult">
                <div class="status-header">
                    <div class="ticket-number">Ticket: <?php echo htmlspecialchars($_POST['ticket_number']); ?></div>
                    <div class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $ticket_data['status'])); ?>">
                        <?php echo $ticket_data['status']; ?>
                    </div>
                </div>

                <div class="status-details">
                    <div class="detail-card">
                        <div class="detail-label">Requester Name</div>
                        <div class="detail-value"><?php echo $ticket_data['name']; ?></div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Department</div>
                        <div class="detail-value"><?php echo $ticket_data['department']; ?></div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Issue Type</div>
                        <div class="detail-value"><?php echo $ticket_data['issue']; ?></div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Assigned Technician</div>
                        <div class="detail-value"><?php echo $ticket_data['assigned_tech']; ?></div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Submitted Date</div>
                        <div class="detail-value"><?php echo date('M j, Y g:i A', strtotime($ticket_data['submitted_date'])); ?></div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Last Updated</div>
                        <div class="detail-value"><?php echo date('M j, Y g:i A', strtotime($ticket_data['last_update'])); ?></div>
                    </div>
                </div>

                <div class="timeline">
                    <h3 class="timeline-title"><i class="fas fa-history"></i> Ticket Timeline</h3>
                    <?php foreach ($ticket_data['updates'] as $index => $update): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <i class="fas fa-<?php echo $index === 0 ? 'plus' : ($index === count($ticket_data['updates']) - 1 ? 'check' : 'sync'); ?>"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">
                                <?php echo date('M j, Y g:i A', strtotime($update['date'])); ?>
                            </div>
                            <div class="timeline-message">
                                <?php echo $update['message']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2024 College of Science Hardware Support - KNUST</p>
            </div>
        </div>
    </footer>

    <script>
        // Sample ticket numbers for testing
        const sampleTickets = [
            'CSHW-20240115-1234',
            'CSHW-20240114-5678', 
            'CSHW-20240113-9012'
        ];

        // Add sample ticket helper
        const ticketInput = document.getElementById('ticket_number');
        const emailInput = document.getElementById('email');
        
        // Add click to fill functionality for testing
        ticketInput.addEventListener('click', function() {
            if (!this.value) {
                this.value = sampleTickets[0];
                emailInput.value = 'test@knust.edu.gh';
            }
        });

        // Auto-format ticket number
        ticketInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Show/hide ticket result
        <?php if ($ticket_data): ?>
        document.getElementById('ticketResult').style.display = 'block';
        <?php endif; ?>
    </script>
</body>
</html>
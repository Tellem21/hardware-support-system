<?php
// submit-ticket.php
session_start();

// Handle form submission
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process form data
    $required_fields = ['name', 'email', 'phone', 'id_number', 'department', 'device_type', 'issue_type', 'urgency', 'description'];
    $all_filled = true;
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $all_filled = false;
            break;
        }
    }
    
    if ($all_filled) {
        // Generate ticket number
        $ticket_number = 'CSHW-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // In a real application, you would save to database here
        $success_message = "Ticket submitted successfully! Your ticket number is: <strong>{$ticket_number}</strong>";
        
        // Clear form
        $_POST = array();
    } else {
        $error_message = "Please fill in all required fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Ticket - College of Science</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #8B0000, #B22222);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .form-header h1 {
            margin: 0;
            font-size: 2.2rem;
        }
        .form-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .form-body {
            padding: 40px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group label .required {
            color: #dc3545;
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
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        .submit-btn {
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
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        .feature-highlights {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .feature-item {
            text-align: center;
            padding: 20px;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #8B0000;
            margin-bottom: 15px;
        }
        .urgency-indicator {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: 10px;
        }
        .urgency-low { background: #d4edda; color: #155724; }
        .urgency-medium { background: #fff3cd; color: #856404; }
        .urgency-high { background: #f8d7da; color: #721c24; }
        .urgency-emergency { background: #dc3545; color: white; }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-container">
                <div class="header-text">
                    <h1>College of Science</h1>
                    <h2>Hardware Support - Submit Ticket</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="submit-ticket.php" class="active">Submit Ticket</a></li>
                    <li><a href="check-status.php">Check Status</a></li>
                    <li><a href="admin/login.php">Admin Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h1><i class="fas fa-ticket-alt"></i> Submit Support Ticket</h1>
                <p>Get fast and professional hardware support from our technical team</p>
            </div>

            <div class="form-body">
                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                        <p style="margin: 10px 0 0; font-size: 0.9rem;">We'll contact you within 2 working hours.</p>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required 
                                   value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                   placeholder="Enter your full name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                   placeholder="your.email@knust.edu.gh">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                   value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                   placeholder="+233 XX XXX XXXX">
                        </div>

                        <div class="form-group">
                            <label for="id_number">Student/Staff ID <span class="required">*</span></label>
                            <input type="text" class="form-control" id="id_number" name="id_number" required
                                   value="<?php echo htmlspecialchars($_POST['id_number'] ?? ''); ?>"
                                   placeholder="e.g., STU2024001 or STAFF12345">
                        </div>

                        <div class="form-group">
                            <label for="department">Department <span class="required">*</span></label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="">Select Department</option>
                                <option value="Mathematics" <?php echo ($_POST['department'] ?? '') === 'Mathematics' ? 'selected' : ''; ?>>Mathematics</option>
                                <option value="Physics" <?php echo ($_POST['department'] ?? '') === 'Physics' ? 'selected' : ''; ?>>Physics</option>
                                <option value="Chemistry" <?php echo ($_POST['department'] ?? '') === 'Chemistry' ? 'selected' : ''; ?>>Chemistry</option>
                                <option value="Biological Sciences" <?php echo ($_POST['department'] ?? '') === 'Biological Sciences' ? 'selected' : ''; ?>>Biological Sciences</option>
                                <option value="Computer Science" <?php echo ($_POST['department'] ?? '') === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                                <option value="Statistics" <?php echo ($_POST['department'] ?? '') === 'Statistics' ? 'selected' : ''; ?>>Statistics</option>
                                <option value="Other" <?php echo ($_POST['department'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="device_type">Device Type <span class="required">*</span></label>
                            <select class="form-control" id="device_type" name="device_type" required>
                                <option value="">Select Device Type</option>
                                <option value="Laptop" <?php echo ($_POST['device_type'] ?? '') === 'Laptop' ? 'selected' : ''; ?>>Laptop</option>
                                <option value="Desktop Computer" <?php echo ($_POST['device_type'] ?? '') === 'Desktop Computer' ? 'selected' : ''; ?>>Desktop Computer</option>
                                <option value="Printer" <?php echo ($_POST['device_type'] ?? '') === 'Printer' ? 'selected' : ''; ?>>Printer</option>
                                <option value="Scanner" <?php echo ($_POST['device_type'] ?? '') === 'Scanner' ? 'selected' : ''; ?>>Scanner</option>
                                <option value="Network Equipment" <?php echo ($_POST['device_type'] ?? '') === 'Network Equipment' ? 'selected' : ''; ?>>Network Equipment</option>
                                <option value="Lab Equipment" <?php echo ($_POST['device_type'] ?? '') === 'Lab Equipment' ? 'selected' : ''; ?>>Lab Equipment</option>
                                <option value="Other" <?php echo ($_POST['device_type'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="issue_type">Issue Type <span class="required">*</span></label>
                            <select class="form-control" id="issue_type" name="issue_type" required>
                                <option value="">Select Issue Type</option>
                                <option value="Hardware Failure" <?php echo ($_POST['issue_type'] ?? '') === 'Hardware Failure' ? 'selected' : ''; ?>>Hardware Failure</option>
                                <option value="Performance Issues" <?php echo ($_POST['issue_type'] ?? '') === 'Performance Issues' ? 'selected' : ''; ?>>Performance Issues</option>
                                <option value="Connectivity Problems" <?php echo ($_POST['issue_type'] ?? '') === 'Connectivity Problems' ? 'selected' : ''; ?>>Connectivity Problems</option>
                                <option value="Software Installation" <?php echo ($_POST['issue_type'] ?? '') === 'Software Installation' ? 'selected' : ''; ?>>Software Installation</option>
                                <option value="Printer Setup" <?php echo ($_POST['issue_type'] ?? '') === 'Printer Setup' ? 'selected' : ''; ?>>Printer Setup</option>
                                <option value="Other" <?php echo ($_POST['issue_type'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="urgency">Urgency Level <span class="required">*</span></label>
                            <select class="form-control" id="urgency" name="urgency" required>
                                <option value="">Select Urgency Level</option>
                                <option value="Low" <?php echo ($_POST['urgency'] ?? '') === 'Low' ? 'selected' : ''; ?>>Low - Minor issue, not affecting work</option>
                                <option value="Medium" <?php echo ($_POST['urgency'] ?? '') === 'Medium' ? 'selected' : ''; ?>>Medium - Affecting work but not critical</option>
                                <option value="High" <?php echo ($_POST['urgency'] ?? '') === 'High' ? 'selected' : ''; ?>>High - Critical issue preventing work</option>
                                <option value="Emergency" <?php echo ($_POST['urgency'] ?? '') === 'Emergency' ? 'selected' : ''; ?>>Emergency - System down, multiple users affected</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="description">Issue Description <span class="required">*</span></label>
                            <textarea class="form-control" id="description" name="description" required 
                                      placeholder="Please provide detailed description of the issue, including any error messages, when it started, and steps to reproduce the problem..."><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                            <small style="color: #666; margin-top: 5px; display: block;">
                                <i class="fas fa-lightbulb"></i> Tip: The more details you provide, the faster we can help you!
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Submit Support Ticket
                    </button>
                </form>

                <div class="feature-highlights">
                    <div class="feature-item">
                        <i class="fas fa-clock feature-icon"></i>
                        <h3>Fast Response</h3>
                        <p>Average response time: 2.3 hours during working hours</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-user-shield feature-icon"></i>
                        <h3>Expert Support</h3>
                        <p>Certified technicians with hardware expertise</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-history feature-icon"></i>
                        <h3>Status Tracking</h3>
                        <p>Track your ticket progress in real-time</p>
                    </div>
                </div>
            </div>
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
        // Dynamic urgency indicator
        document.getElementById('urgency').addEventListener('change', function() {
            const urgency = this.value;
            const indicator = document.getElementById('urgency-indicator');
            
            if (!indicator) {
                const newIndicator = document.createElement('span');
                newIndicator.id = 'urgency-indicator';
                newIndicator.className = `urgency-${urgency.toLowerCase()}`;
                newIndicator.textContent = urgency;
                this.parentNode.appendChild(newIndicator);
            } else {
                indicator.className = `urgency-indicator urgency-${urgency.toLowerCase()}`;
                indicator.textContent = urgency;
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#dc3545';
                } else {
                    field.style.borderColor = '#e9ecef';
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields marked with *');
            }
        });
    </script>
</body>
</html>
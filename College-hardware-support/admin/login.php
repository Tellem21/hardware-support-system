<?php
// admin/login.php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

// Handle login
$error = '';
if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Secure credentials - change these in production
    $valid_username = 'cos_hardware_admin';
    $valid_password = 'KnustSci@2024!Support';
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - College of Science Hardware Support</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            background: linear-gradient(135deg, #8B0000 0%, #B22222 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            opacity: 0.9;
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
            transition: background-color 0.3s;
        }
        nav a:hover, nav a.active {
            background-color: rgba(255,255,255,0.2);
        }
        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            min-height: 80vh;
            padding: 40px 0;
        }
        .login-container {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-header h1 {
            color: #8B0000;
            margin-bottom: 10px;
            font-size: 2.2rem;
        }
        .login-header p {
            color: #666;
            font-size: 1.1rem;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        .form-control:focus {
            outline: none;
            border-color: #8B0000;
            background: white;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #8B0000, #B22222);
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }
        .error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #dc3545;
            font-weight: 500;
        }
        .features-sidebar {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .features-sidebar h2 {
            color: #8B0000;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.8rem;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .feature-item:hover {
            transform: translateX(5px);
            background: #e9ecef;
        }
        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8B0000, #B22222);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .feature-content h3 {
            color: #333;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }
        .feature-content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .security-notice {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border: 1px solid #ffecb5;
            padding: 15px;
            border-radius: 10px;
            margin-top: 30px;
            text-align: center;
        }
        .security-notice i {
            color: #856404;
            margin-right: 8px;
        }
        .security-notice span {
            color: #856404;
            font-weight: 600;
            font-size: 0.9rem;
        }
        footer {
            background: #333;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
            text-align: center;
        }
        .support-contact {
            background: linear-gradient(135deg, #8B0000, #B22222);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-top: 30px;
            text-align: center;
        }
        .support-contact h3 {
            margin-bottom: 10px;
            font-size: 1.3rem;
        }
        .support-contact p {
            margin-bottom: 5px;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .login-container {
                padding: 30px 20px;
            }
            .features-sidebar {
                padding: 25px 20px;
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
                    <h2>Hardware Support System - Admin Portal</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="login.php" class="active">Admin Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="login-header">
                    <h1><i class="fas fa-lock"></i> Secure Admin Login</h1>
                    <p>Access the Hardware Support Management System</p>
                </div>

                <?php if ($error): ?>
                    <div class="error">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i> Administrator Username</label>
                        <input type="text" class="form-control" id="username" name="username" required 
                               placeholder="Enter your admin username">
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-key"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Enter your secure password">
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                    </button>
                </form>

                <div class="security-notice">
                    <i class="fas fa-shield-alt"></i>
                    <span>Authorized Personnel Only - All activities are logged and monitored</span>
                </div>
            </div>

            <div class="features-sidebar">
                <h2><i class="fas fa-cogs"></i> System Features</h2>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Real-time Dashboard</h3>
                        <p>Monitor all hardware support requests with live statistics and performance metrics</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Ticket Management</h3>
                        <p>Process, assign, and track support tickets with advanced filtering and prioritization</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Analytics & Reports</h3>
                        <p>Generate detailed reports on support performance, response times, and hardware issues</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Team Management</h3>
                        <p>Assign technicians, manage workloads, and coordinate support activities efficiently</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Hardware Inventory</h3>
                        <p>Track and manage college hardware assets with maintenance schedules and warranty info</p>
                    </div>
                </div>

                <div class="support-contact">
                    <h3><i class="fas fa-life-ring"></i> Need Assistance?</h3>
                    <p><strong>IT Support:</strong> +233 (0) 3220 60000</p>
                    <p><strong>Email:</strong> cos-hardware@knust.edu.gh</p>
                    <p><strong>Emergency:</strong> Available 24/7 for critical issues</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 College of Science Hardware Support System - Kwame Nkrumah University of Science and Technology</p>
            <p style="margin-top: 10px; font-size: 0.9rem; opacity: 0.8;">
                Secure Admin Portal - Unauthorized access prohibited
            </p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Add password strength indicator (conceptual)
            const passwordInput = document.getElementById('password');
            passwordInput.addEventListener('input', function() {
                // This is just for show - real validation happens server-side
                if (this.value.length > 0) {
                    this.style.background = "linear-gradient(90deg, #8B0000 " + (this.value.length * 5) + "%, #f8f9fa " + (this.value.length * 5) + "%)";
                } else {
                    this.style.background = "#f8f9fa";
                }
            });
        });
    </script>
</body>
</html>
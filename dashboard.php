<?php
require_once 'includes/config.php';
requireLogin();

$page_title = "Dashboard";

// Get user's full name from session
$full_name = $_SESSION['full_name'] ?? 'User';

// Get current time for greeting
$current_hour = date('H');
$greeting = "Good morning";
if ($current_hour >= 12 && $current_hour < 18) {
    $greeting = "Good afternoon";
} elseif ($current_hour >= 18) {
    $greeting = "Good evening";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Diabetes Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <a href="dashboard.php" class="logo">Diabetes Management System</a>
                <div class="nav-user-info">
                    <span class="welcome-text">Welcome, <?php echo htmlspecialchars($full_name); ?>!</span>
                </div>
                <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="consultations.php">Consultations</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="test_results.php">Results</a></li>
                    <li><a href="recommended_meals.php">Meals</a></li>
                    <li><a href="emergency.php">Emergency</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container dashboard-container">
            <h1 class="page-title">Hello, <?php echo htmlspecialchars($full_name); ?>!</h1>
            <p class="page-description"><?php echo $greeting; ?>! Welcome to your Diabetes Management System dashboard. Here you can manage all aspects of your health.</p>

            <div class="dashboard-cards">
                <a href="consultations.php" class="card">
                    <img src="images/doctor_consultation_icon.png" alt="Doctor Consultations Icon">
                    <h2>Doctor Consultations</h2>
                    <p>Book consultations with your specialist doctor and track your health condition.</p>
                </a>

                <a href="appointments.php" class="card">
                    <img src="images/hospital_icon.jpg" alt="Hospital Appointments Icon">
                    <h2>Hospital Appointments</h2>
                    <p>Manage your appointments at hospitals and specialized clinics.</p>
                </a>

                <a href="test_results.php" class="card">
                    <img src="images/test_results_icon.jpg" alt="Test Results Icon">
                    <h2>Test Results</h2>
                    <p>Track your medical test results and blood sugar levels.</p>
                </a>

                <a href="recommended_meals.php" class="card">
                    <img src="images/healthy_fruits.jpg" alt="Recommended Meals Icon">
                    <h2>Recommended Meals</h2>
                    <p>Discover healthy and balanced meal ideas suitable for diabetes management.</p>
                </a>

                <a href="emergency.php" class="card">
                    <img src="images/emergency_icon.jpg" alt="Emergency Icon">
                    <h2>Emergency</h2>
                    <p>Emergency numbers and contacts for urgent situations.</p>
                </a>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Diabetes Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>


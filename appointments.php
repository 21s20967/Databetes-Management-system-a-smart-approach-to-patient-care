<?php
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospital_name = trim($_POST['hospital_name']);
    $appointment_date = $_POST['appointment_date'];
    $department = trim($_POST['department']);
    $doctor_name = trim($_POST['doctor_name']);
    
    if (empty($hospital_name) || empty($appointment_date) || empty($department)) {
        $message = '<div class="message message-error">Hospital name, appointment date, and department are required.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO hospital_appointments (user_id, hospital_name, appointment_date, department, doctor_name, status) VALUES (?, ?, ?, ?, ?, 'scheduled')");
        
        if ($stmt->execute([$user_id, $hospital_name, $appointment_date, $department, $doctor_name])) {
            $message = '<div class="message message-success">Appointment scheduled successfully!</div>';
        } else {
            $message = '<div class="message message-error">Error scheduling appointment. Please try again.</div>';
        }
    }
}

// Fetch appointments
$stmt = $pdo->prepare("SELECT * FROM hospital_appointments WHERE user_id = ? ORDER BY appointment_date DESC");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Appointments - Diabetes Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="dashboard.php" class="logo">Diabetes Management System</a>
                <ul class="nav-links">
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="consultations.php">Consultations</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="test_results.php">Results</a></li>
                    <li><a href="emergency.php">Emergency</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="card fade-in">
                <h1 style="color: #333; margin-bottom: 2rem; text-align: center;">Hospital Appointments</h1>
                
                <h2 style="color: #4A90E2; margin-bottom: 1.5rem;">Schedule New Appointment</h2>
                
                <?php echo $message; ?>
                
                <form method="POST" action="">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label for="hospital_name" class="form-label">Hospital Name</label>
                            <input type="text" id="hospital_name" name="hospital_name" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="appointment_date" class="form-label">Appointment Date & Time</label>
                            <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="department" class="form-label">Department</label>
                            <select id="department" name="department" class="form-select" required>
                                <option value="">Select Department</option>
                                <option value="Endocrinology">Endocrinology</option>
                                <option value="Internal Medicine">Internal Medicine</option>
                                <option value="Cardiology">Cardiology</option>
                                <option value="Ophthalmology">Ophthalmology</option>
                                <option value="Nephrology">Nephrology</option>
                                <option value="Podiatry">Podiatry</option>
                                <option value="Emergency">Emergency</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="doctor_name" class="form-label">Doctor Name (Optional)</label>
                            <input type="text" id="doctor_name" name="doctor_name" class="form-input">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                </form>
            </div>

            <div class="card fade-in">
                <h2 style="color: #333; margin-bottom: 1.5rem;">All Hospital Appointments</h2>
                
                <?php if (count($appointments) > 0): ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hospital</th>
                                    <th>Date & Time</th>
                                    <th>Department</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['hospital_name']); ?></td>
                                        <td><?php echo date('M d, Y - H:i', strtotime($appointment['appointment_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['department']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['doctor_name'] ?: 'Not specified'); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $appointment['status']; ?>">
                                                <?php echo ucfirst($appointment['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: #666;">
                        <p style="font-size: 1.1rem;">No appointments scheduled yet</p>
                        <p>Schedule your first appointment using the form above</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Diabetes Management System. Developed by Manus AI for better diabetes care.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>


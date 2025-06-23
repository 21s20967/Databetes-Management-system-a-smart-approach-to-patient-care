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
    $doctor_name = trim($_POST['doctor_name']);
    $consultation_date = $_POST['consultation_date'];
    $notes = trim($_POST['notes']);
    
    if (empty($doctor_name) || empty($consultation_date)) {
        $message = '<div class="message message-error">Doctor name and consultation date are required.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO consultations (user_id, doctor_name, consultation_date, notes, status) VALUES (?, ?, ?, ?, 'scheduled')");
        
        if ($stmt->execute([$user_id, $doctor_name, $consultation_date, $notes])) {
            $message = '<div class="message message-success">Consultation added successfully!</div>';
        } else {
            $message = '<div class="message message-error">Error adding consultation. Please try again.</div>';
        }
    }
}

// Fetch consultations
$stmt = $pdo->prepare("SELECT * FROM consultations WHERE user_id = ? ORDER BY consultation_date DESC");
$stmt->execute([$user_id]);
$consultations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Consultations - Diabetes Management System</title>
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
                <h1 style="color: #333; margin-bottom: 2rem; text-align: center;">Doctor Consultations</h1>
                
                <h2 style="color: #4A90E2; margin-bottom: 1.5rem;">Add New Consultation</h2>
                
                <?php echo $message; ?>
                
                <form method="POST" action="">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label for="doctor_name" class="form-label">Doctor Name</label>
                            <input type="text" id="doctor_name" name="doctor_name" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="consultation_date" class="form-label">Consultation Date & Time</label>
                            <input type="datetime-local" id="consultation_date" name="consultation_date" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" class="form-textarea" placeholder="Any additional notes or symptoms to discuss..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Consultation</button>
                </form>
            </div>

            <div class="card fade-in">
                <h2 style="color: #333; margin-bottom: 1.5rem;">All Doctor Consultations</h2>
                
                <?php if (count($consultations) > 0): ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($consultations as $consultation): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($consultation['doctor_name']); ?></td>
                                        <td><?php echo date('M d, Y - H:i', strtotime($consultation['consultation_date'])); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $consultation['status']; ?>">
                                                <?php echo ucfirst($consultation['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($consultation['notes'] ?: 'No notes'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: #666;">
                        <p style="font-size: 1.1rem;">No consultations recorded yet</p>
                        <p>Add your first consultation using the form above</p>
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


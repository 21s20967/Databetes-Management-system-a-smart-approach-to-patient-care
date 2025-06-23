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
    $test_type = trim($_POST['test_type']);
    $test_date = $_POST['test_date'];
    $glucose_level = !empty($_POST['glucose_level']) ? (float)$_POST['glucose_level'] : null;
    $hba1c_level = !empty($_POST['hba1c_level']) ? (float)$_POST['hba1c_level'] : null;
    $blood_pressure = trim($_POST['blood_pressure']);
    $weight = !empty($_POST['weight']) ? (float)$_POST['weight'] : null;
    
    if (empty($test_type) || empty($test_date)) {
        $message = '<div class="message message-error">Test type and test date are required.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO test_results (user_id, test_type, test_date, glucose_level, hba1c_level, blood_pressure, weight) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$user_id, $test_type, $test_date, $glucose_level, $hba1c_level, $blood_pressure, $weight])) {
            $message = '<div class="message message-success">Test result added successfully!</div>';
        } else {
            $message = '<div class="message message-error">Error adding test result. Please try again.</div>';
        }
    }
}

// Fetch test results
$stmt = $pdo->prepare("SELECT * FROM test_results WHERE user_id = ? ORDER BY test_date DESC");
$stmt->execute([$user_id]);
$test_results = $stmt->fetchAll();

// Function to get glucose level status
function getGlucoseStatus($level, $test_type) {
    if (!$level) return '';
    
    if ($test_type == 'Fasting Blood Sugar') {
        if ($level < 70) return 'Low';
        if ($level <= 100) return 'Normal';
        if ($level <= 125) return 'Pre-diabetes';
        return 'High';
    } elseif ($test_type == 'Random Blood Sugar') {
        if ($level < 70) return 'Low';
        if ($level < 140) return 'Normal';
        if ($level <= 199) return 'Pre-diabetes';
        return 'High';
    }
    return '';
}

// Function to get HbA1c status
function getHbA1cStatus($level) {
    if (!$level) return '';
    
    if ($level < 5.7) return 'Normal';
    if ($level <= 6.4) return 'Pre-diabetes';
    return 'Diabetes';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results - Diabetes Management System</title>
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
                <h1 style="color: #333; margin-bottom: 2rem; text-align: center;">Test Results</h1>
                
                <h2 style="color: #4A90E2; margin-bottom: 1.5rem;">Add New Test Result</h2>
                
                <?php echo $message; ?>
                
                <form method="POST" action="">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label for="test_type" class="form-label">Test Type</label>
                            <select id="test_type" name="test_type" class="form-select" required>
                                <option value="">Select Test Type</option>
                                <option value="Fasting Blood Sugar">Fasting Blood Sugar</option>
                                <option value="Random Blood Sugar">Random Blood Sugar</option>
                                <option value="HbA1c">HbA1c</option>
                                <option value="Oral Glucose Tolerance Test">Oral Glucose Tolerance Test</option>
                                <option value="Blood Pressure Check">Blood Pressure Check</option>
                                <option value="Weight Check">Weight Check</option>
                                <option value="Complete Blood Count">Complete Blood Count</option>
                                <option value="Lipid Profile">Lipid Profile</option>
                                <option value="Kidney Function">Kidney Function</option>
                                <option value="Eye Exam">Eye Exam</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="test_date" class="form-label">Test Date</label>
                            <input type="date" id="test_date" name="test_date" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="glucose_level" class="form-label">Glucose Level (mg/dL)</label>
                            <input type="number" id="glucose_level" name="glucose_level" class="form-input" step="0.1" min="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="hba1c_level" class="form-label">HbA1c Level (%)</label>
                            <input type="number" id="hba1c_level" name="hba1c_level" class="form-input" step="0.1" min="0" max="20">
                        </div>
                        
                        <div class="form-group">
                            <label for="blood_pressure" class="form-label">Blood Pressure (e.g., 120/80)</label>
                            <input type="text" id="blood_pressure" name="blood_pressure" class="form-input" placeholder="120/80">
                        </div>
                        
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" class="form-input" step="0.1" min="0">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Test Result</button>
                </form>
            </div>

            <div class="card fade-in">
                <h2 style="color: #333; margin-bottom: 1.5rem;">All Test Results</h2>
                
                <?php if (count($test_results) > 0): ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Test Type</th>
                                    <th>Date</th>
                                    <th>Glucose (mg/dL)</th>
                                    <th>HbA1c (%)</th>
                                    <th>Blood Pressure</th>
                                    <th>Weight (kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($test_results as $result): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($result['test_type']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($result['test_date'])); ?></td>
                                        <td>
                                            <?php if ($result['glucose_level']): ?>
                                                <?php echo $result['glucose_level']; ?>
                                                <?php 
                                                $status = getGlucoseStatus($result['glucose_level'], $result['test_type']);
                                                if ($status): 
                                                ?>
                                                    <br><small style="color: <?php echo $status == 'Normal' ? '#50C878' : ($status == 'Low' || $status == 'High' ? '#FF6B6B' : '#FF7F50'); ?>">
                                                        (<?php echo $status; ?>)
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($result['hba1c_level']): ?>
                                                <?php echo $result['hba1c_level']; ?>
                                                <?php 
                                                $status = getHbA1cStatus($result['hba1c_level']);
                                                if ($status): 
                                                ?>
                                                    <br><small style="color: <?php echo $status == 'Normal' ? '#50C878' : '#FF6B6B'; ?>">
                                                        (<?php echo $status; ?>)
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($result['blood_pressure'] ?: '-'); ?></td>
                                        <td><?php echo $result['weight'] ? $result['weight'] : '-'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: #666;">
                        <p style="font-size: 1.1rem;">No test results recorded yet</p>
                        <p>Add your first test result using the form above</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Reference Values -->
            <div class="card fade-in">
                <h2 style="color: #333; margin-bottom: 1.5rem;">Reference Values</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <div style="background: rgba(74, 144, 226, 0.05); padding: 1.5rem; border-radius: 12px;">
                        <h3 style="color: #4A90E2; margin-bottom: 1rem;">Blood Sugar Levels</h3>
                        <p><strong>Fasting:</strong> 70-100 mg/dL (Normal)</p>
                        <p><strong>Random:</strong> &lt;140 mg/dL (Normal)</p>
                        <p><strong>Pre-diabetes:</strong> 100-125 mg/dL (Fasting)</p>
                        <p><strong>Diabetes:</strong> ≥126 mg/dL (Fasting)</p>
                    </div>
                    <div style="background: rgba(80, 200, 120, 0.05); padding: 1.5rem; border-radius: 12px;">
                        <h3 style="color: #50C878; margin-bottom: 1rem;">HbA1c Levels</h3>
                        <p><strong>Normal:</strong> &lt;5.7%</p>
                        <p><strong>Pre-diabetes:</strong> 5.7-6.4%</p>
                        <p><strong>Diabetes:</strong> ≥6.5%</p>
                        <p><strong>Target for diabetics:</strong> &lt;7%</p>
                    </div>
                    <div style="background: rgba(255, 107, 107, 0.05); padding: 1.5rem; border-radius: 12px;">
                        <h3 style="color: #FF6B6B; margin-bottom: 1rem;">Blood Pressure</h3>
                        <p><strong>Normal:</strong> &lt;120/80 mmHg</p>
                        <p><strong>Elevated:</strong> 120-129/&lt;80 mmHg</p>
                        <p><strong>High Stage 1:</strong> 130-139/80-89 mmHg</p>
                        <p><strong>High Stage 2:</strong> ≥140/90 mmHg</p>
                    </div>
                </div>
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


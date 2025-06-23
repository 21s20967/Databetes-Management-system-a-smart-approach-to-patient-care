<?php
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle form submission for emergency contacts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact_name = trim($_POST['contact_name']);
    $phone_number = trim($_POST['phone_number']);
    $relationship = $_POST['relationship'];
    $is_primary = isset($_POST['is_primary']) ? 1 : 0;
    
    if (empty($contact_name) || empty($phone_number) || empty($relationship)) {
        $message = '<div class="message message-error">Contact name, phone number, and relationship are required.</div>';
    } else {
        // If this is set as primary, remove primary status from other contacts
        if ($is_primary) {
            $stmt = $pdo->prepare("UPDATE emergency_contacts SET is_primary = 0 WHERE user_id = ?");
            $stmt->execute([$user_id]);
        }
        
        $stmt = $pdo->prepare("INSERT INTO emergency_contacts (user_id, contact_name, phone_number, relationship, is_primary) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$user_id, $contact_name, $phone_number, $relationship, $is_primary])) {
            $message = '<div class="message message-success">Emergency contact added successfully!</div>';
        } else {
            $message = '<div class="message message-error">Error adding emergency contact. Please try again.</div>';
        }
    }
}

// Fetch emergency contacts
$stmt = $pdo->prepare("SELECT * FROM emergency_contacts WHERE user_id = ? ORDER BY is_primary DESC, contact_name ASC");
$stmt->execute([$user_id]);
$emergency_contacts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency - Diabetes Management System</title>
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
            <!-- Emergency Numbers -->
            <div class="card fade-in">
                <h1 style="color: #333; margin-bottom: 2rem; text-align: center;">Emergency Services</h1>
                
                <h2 style="color: #FF6B6B; margin-bottom: 1.5rem; text-align: center;">General Emergency Numbers</h2>
                
                <div class="emergency-grid">
                    <div class="emergency-card" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A52 100%);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🚑</div>
                        <div class="emergency-label">Ambulance</div>
                        <div class="emergency-number">911</div>
                        <a href="tel:911" style="color: white; text-decoration: none; font-weight: 500;">Call Now</a>
                    </div>
                    
                    <div class="emergency-card" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🏥</div>
                        <div class="emergency-label">Medical Emergency</div>
                        <div class="emergency-number">911</div>
                        <a href="tel:911" style="color: white; text-decoration: none; font-weight: 500;">Call Now</a>
                    </div>
                    
                    <div class="emergency-card" style="background: linear-gradient(135deg, #50C878 0%, #45B565 100%);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">☎️</div>
                        <div class="emergency-label">Health Hotline</div>
                        <div class="emergency-number">211</div>
                        <a href="tel:211" style="color: white; text-decoration: none; font-weight: 500;">Call Now</a>
                    </div>
                    
                    <div class="emergency-card" style="background: linear-gradient(135deg, #FF7F50 0%, #FF6347 100%);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🆘</div>
                        <div class="emergency-label">Poison Control</div>
                        <div class="emergency-number">1-800-222-1222</div>
                        <a href="tel:18002221222" style="color: white; text-decoration: none; font-weight: 500;">Call Now</a>
                    </div>
                </div>
            </div>

            <!-- Add Emergency Contact -->
            <div class="card fade-in">
                <h2 style="color: #4A90E2; margin-bottom: 1.5rem;">Add Emergency Contact</h2>
                
                <?php echo $message; ?>
                
                <form method="POST" action="">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label for="contact_name" class="form-label">Contact Name</label>
                            <input type="text" id="contact_name" name="contact_name" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="tel" id="phone_number" name="phone_number" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="relationship" class="form-label">Relationship</label>
                            <select id="relationship" name="relationship" class="form-select" required>
                                <option value="">Select Relationship</option>
                                <option value="Spouse">Spouse</option>
                                <option value="Parent">Parent</option>
                                <option value="Child">Child</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Friend">Friend</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Caregiver">Caregiver</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" id="is_primary" name="is_primary" style="margin: 0;">
                                <span class="form-label" style="margin: 0;">Primary Emergency Contact</span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Emergency Contact</button>
                </form>
            </div>

            <!-- Emergency Contacts List -->
            <div class="card fade-in">
                <h2 style="color: #333; margin-bottom: 1.5rem;">Emergency Contacts</h2>
                
                <?php if (count($emergency_contacts) > 0): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        <?php foreach ($emergency_contacts as $contact): ?>
                            <div style="background: rgba(74, 144, 226, 0.05); border: 2px solid <?php echo $contact['is_primary'] ? '#4A90E2' : '#e1e5e9'; ?>; border-radius: 12px; padding: 1.5rem;">
                                <?php if ($contact['is_primary']): ?>
                                    <div style="background: #4A90E2; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; display: inline-block; margin-bottom: 1rem;">PRIMARY</div>
                                <?php endif; ?>
                                <h3 style="color: #333; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($contact['contact_name']); ?></h3>
                                <p style="color: #666; margin-bottom: 0.5rem;">
                                    <strong>Phone:</strong> 
                                    <a href="tel:<?php echo htmlspecialchars($contact['phone_number']); ?>" style="color: #4A90E2; text-decoration: none;">
                                        <?php echo htmlspecialchars($contact['phone_number']); ?>
                                    </a>
                                </p>
                                <p style="color: #666;"><strong>Relationship:</strong> <?php echo htmlspecialchars($contact['relationship']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: #666;">
                        <p style="font-size: 1.1rem;">No emergency contacts added yet</p>
                        <p>Add your first emergency contact using the form above</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Emergency Tips -->
            <div class="tips-section fade-in">
                <h2 class="tips-title">Important Emergency Tips</h2>
                
                <div class="tip-item">
                    <h3 class="tip-title">🔻 For Severe Low Blood Sugar (Hypoglycemia):</h3>
                    <div class="tip-content">
                        <p>• Consume 15-20 grams of fast-acting carbohydrates (glucose tablets, fruit juice, regular soda)</p>
                        <p>• Wait 15 minutes and recheck blood sugar</p>
                        <p>• If still low, repeat the process</p>
                        <p>• Call emergency services if unconscious or unable to swallow</p>
                    </div>
                </div>
                
                <div class="tip-item">
                    <h3 class="tip-title">🔺 For Severe High Blood Sugar (Hyperglycemia):</h3>
                    <div class="tip-content">
                        <p>• Drink plenty of water to stay hydrated</p>
                        <p>• Check for ketones in urine if possible</p>
                        <p>• Take insulin as prescribed by your doctor</p>
                        <p>• Seek immediate medical attention if symptoms are severe (vomiting, difficulty breathing, confusion)</p>
                    </div>
                </div>
                
                <div class="tip-item">
                    <h3 class="tip-title">🚨 When to Call Emergency Services:</h3>
                    <div class="tip-content">
                        <p>• Loss of consciousness or severe confusion</p>
                        <p>• Difficulty breathing or chest pain</p>
                        <p>• Severe dehydration or persistent vomiting</p>
                        <p>• Blood sugar below 50 mg/dL or above 400 mg/dL</p>
                        <p>• Signs of diabetic ketoacidosis (fruity breath, rapid breathing, severe fatigue)</p>
                    </div>
                </div>
                
                <div class="tip-item">
                    <h3 class="tip-title">📋 Emergency Preparedness:</h3>
                    <div class="tip-content">
                        <p>• Always carry glucose tablets or fast-acting carbohydrates</p>
                        <p>• Wear medical identification (bracelet or necklace)</p>
                        <p>• Keep emergency contact information easily accessible</p>
                        <p>• Ensure family/friends know how to help in emergencies</p>
                        <p>• Have a glucagon emergency kit if prescribed</p>
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


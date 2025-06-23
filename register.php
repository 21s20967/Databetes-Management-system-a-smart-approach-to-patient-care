<?php
require_once 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $age = (int)$_POST['age'];
    $password = trim($_POST['password']);
    $location = trim($_POST['location']);
    
    if (empty($username) || empty($full_name) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetch()) {
            $error = 'Username already exists. Please choose a different one.';
        } else {
            // Insert new user with plain text password
            $stmt = $pdo->prepare("INSERT INTO users (username, full_name, phone, age, password, location) VALUES (?, ?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$username, $full_name, $phone, $age, $password, $location])) {
                $success = 'Account created successfully! You can now sign in.';
            } else {
                $error = 'Error creating account. Please try again.';
            }
        }
    }
}

$page_title = "Sign Up";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Diabetes Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-form-container">
            <div class="auth-form">
                <h1>Nice to meet you!</h1>
                <h2>Let's Create Your Account</h2>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" min="1" max="120">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location">
                    </div>
                    
                    <button type="submit" class="btn-primary">Create Account</button>
                </form>
                
                <p class="auth-link">Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
        
        <div class="auth-image-container">
            <img src="images/background_login.jpg" alt="Medical Background">
        </div>
    </div>
</body>
</html>


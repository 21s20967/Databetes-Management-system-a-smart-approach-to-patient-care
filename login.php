<?php
require_once 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        // Check user credentials with plain text password comparison
        $stmt = $pdo->prepare("SELECT id, username, full_name, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $password === $user['password']) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

$page_title = "Sign In";
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
                <h1>Hello!</h1>
                <h2>Welcome back!</h2>
                <p>Let's Sign In to Your Account</p>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn-primary">Sign In</button>
                </form>
                
                <div class="demo-accounts">
                    <h3>Demo Accounts:</h3>
                    <p><strong>Username:</strong> shaikha | <strong>Password:</strong> 123456</p>
                    <p><strong>Username:</strong> ahmed123 | <strong>Password:</strong> password</p>
                    <p><strong>Username:</strong> sara_ali | <strong>Password:</strong> password</p>
                </div>
                
                <p class="auth-link">Don't have an account? <a href="register.php">Create Account</a></p>
            </div>
        </div>
        
        <div class="auth-image-container">
            <img src="images/background_login.jpg" alt="Medical Background">
        </div>
    </div>
</body>
</html>


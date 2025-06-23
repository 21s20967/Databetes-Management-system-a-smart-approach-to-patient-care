<?php
require_once 'includes/config.php';

// تسجيل الخروج
session_destroy();
header("Location: login.php");
exit();
?>


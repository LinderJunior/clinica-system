<?php
// Simple test file to view the dashboard
session_start();

// Set a basic session to simulate logged in user
$_SESSION['user_id'] = 1;
$_SESSION['role_id'] = 1;

// Include the dashboard directly
include_once __DIR__ . '/pages/inicio.php';
?>

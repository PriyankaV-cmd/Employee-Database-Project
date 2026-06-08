<?php
/**
 * db.php - Database Connection Configuration
 * DevOps Note: In production, use environment variables
 */

//below commands are to run and  check database in local
//define('DB_HOST', 'localhost');
//define('DB_USER', 'emp_user');
//define('DB_PASS', 'StrongPass@123');
//define('DB_NAME', 'employee_db');




define('DB_HOST', 'php-crud-app.cxcy820mudoj.ap-south-1.rds.amazonaws.com');
define('DB_USER', 'admin');
define('DB_PASS', 'Mystrongpw789');
define('DB_NAME', 'employee_db');


// Create MySQLi connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    error_log('Database connection failed: ' . $conn->connect_error);
    die('<h2>Database connection failed. Please contact administrator.</h2>');
}

// Set character set
if (!$conn->set_charset('utf8mb4')) {
    error_log('Error loading character set utf8mb4: ' . $conn->error);
}
?>

<?php
session_start();
include 'db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password, role, full_name, enrolled_class_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        // Login Success
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        $_SESSION['name'] = $row['full_name'];
        $_SESSION['class_id'] = $row['enrolled_class_id'];

        if ($row['role'] == 'admin' || $row['role'] == 'staff') {
            header("Location: dashboard_staff.php");
        } else {
            header("Location: dashboard_student.php");
        }
        exit();
    }
}

// Login Failed
header("Location: index.html?error=Invalid Credentials");
exit();
?>
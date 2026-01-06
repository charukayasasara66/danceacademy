<?php
session_start();
include 'db_connect.php';

// SECURITY LOCK: STRICTLY ADMIN (DIRECTOR) ONLY
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized. Director access only."]);
    exit();
}

$input = json_decode(file_get_contents("php://input"));
$targetID = $input->id; // The ID to delete (e.g., tea002 or std2025001)

// CRITICAL SAFETY: Prevent deleting the Main Director Account
if($targetID === 'add username') {
    echo json_encode(["status" => "error", "message" => "CRITICAL: Cannot delete the Head Director account."]);
    exit();
}

// Perform Deletion
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $targetID);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "User account has been permanently removed."]);
    } else {
        echo json_encode(["status" => "error", "message" => "User not found or already deleted."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $conn->error]);
}
?>
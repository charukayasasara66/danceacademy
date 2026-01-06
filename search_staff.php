<?php
session_start();
include 'db_connect.php';

// SECURITY: STRICTLY ADMIN ONLY
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized Access"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"));
$searchName = $input->name;

$stmt = $conn->prepare("SELECT full_name, username, created_at FROM users WHERE role = 'staff' AND full_name = ?");
$stmt->bind_param("s", $searchName);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "status" => "success",
        "data" => [
            "name" => $row['full_name'],
            "id" => $row['username'], // This is their Staff ID 
            "joined" => date("F j, Y", strtotime($row['created_at']))
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Staff member not found."]);
}
?>
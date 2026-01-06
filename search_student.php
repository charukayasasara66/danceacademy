<?php
session_start();
include 'db_connect.php';

// Security: Only allow Admin or Staff
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'staff')) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"));
$searchName = $input->name;

// We use LEFT JOIN to get class details even if the class ID is somehow missing
$query = "SELECT u.full_name, u.username, u.grade, u.branch, c.subject, c.day_time 
          FROM users u 
          LEFT JOIN classes c ON u.enrolled_class_id = c.id 
          WHERE u.role = 'student' AND u.full_name = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $searchName);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // If class info is missing/deleted, provide default text
    $classDetails = $row['subject'] ? $row['subject'] . " (" . $row['day_time'] . ")" : "Not Assigned";
    
    echo json_encode([
        "status" => "success",
        "data" => [
            "name" => $row['full_name'],
            "id" => $row['username'],
            "grade" => $row['grade'],
            "branch" => $row['branch'],
            "class" => $classDetails
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Student not found."]);
}
?>
<?php
ob_start();
include 'db_connect.php';

$input = file_get_contents("php://input");
$data = json_decode($input);

if (ob_get_length()) ob_end_clean();
header('Content-Type: application/json');

if ($data === null) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
    exit();
}

$branch = $data->branch;
$grade = $data->grade;

// Use LIKE for broader matching
$query = "SELECT subject, day_time FROM classes WHERE branch = ? AND grade LIKE ?";
$stmt = $conn->prepare($query);

if(!$stmt) {
    echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    exit();
}

$gradeSearch = "%" . $grade . "%";
$stmt->bind_param("ss", $branch, $gradeSearch);
$stmt->execute();
$result = $stmt->get_result();

$classes = [];
while($row = $result->fetch_assoc()) {
    $classes[] = $row;
}

if(count($classes) > 0) {
    echo json_encode(["status" => "success", "data" => $classes]);
} else {
    echo json_encode(["status" => "error", "message" => "No classes found for $branch ($grade)"]);
}

$stmt->close();
$conn->close();
?>
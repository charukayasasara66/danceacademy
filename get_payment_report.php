<?php
session_start();
include 'db_connect.php';

// SECURITY: Only Director or Accountant
$allowed_users = ['add username', 'add username'];
if (!in_array($_SESSION['username'], $allowed_users)) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"));
$startDate = $input->startDate;
$endDate = $input->endDate;

// Query: Join Payments with Users to get Names
$query = "SELECT u.full_name, p.student_id, p.transaction_date, p.paid_for_month, p.paid_for_year, p.amount 
          FROM student_payments p 
          JOIN users u ON p.student_id = u.username 
          WHERE p.transaction_date BETWEEN ? AND ? 
          ORDER BY p.transaction_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

$payments = [];
$totalAmount = 0;

while($row = $result->fetch_assoc()) {
    $row['formatted_date'] = date("d/m/Y", strtotime($row['transaction_date']));
    $totalAmount += $row['amount'];
    $payments[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $payments,
    "total" => number_format($totalAmount, 2)
]);
?>
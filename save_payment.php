<?php
session_start();
include 'db_connect.php';

$allowed_users = ['add username', 'add username'];
if (!in_array($_SESSION['username'], $allowed_users)) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"));

$student_id = $input->student_id;
$year = $input->year;
$month = $input->month;
$amount = $input->amount; // NEW FIELD
$reason = $input->reason;
$today = date("Y-m-d");

// Save Payment with Amount
$stmt = $conn->prepare("INSERT INTO student_payments (student_id, paid_for_month, paid_for_year, amount, transaction_date, skip_reason) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssidss", $student_id, $month, $year, $amount, $today, $reason);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Payment of LKR $amount recorded for $month $year"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database Error"]);
}
?>
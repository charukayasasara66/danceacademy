<?php
session_start();
include 'db_connect.php';

// 1. AUTHENTICATION CHECK
// Ensure the user is logged in
if (!isset($_SESSION['role'])) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// 2. READ INPUT
$input = json_decode(file_get_contents("php://input"));
$requested_id = isset($input->student_id) ? $input->student_id : '';

// 3. SECURITY LOGIC (IDOR PROTECTION)
// - If the user is a STUDENT, ignore their input and force their own ID.
// - If the user is ADMIN/STAFF, let them view the requested ID.
if ($_SESSION['role'] == 'student') {
    $student_id = $_SESSION['username']; // Secure: Taken from server session
} else {
    // Admin/Staff logic:
    if (empty($requested_id)) {
        echo json_encode(["status" => "error", "message" => "Student ID required for staff search."]);
        exit();
    }
    $student_id = $requested_id;
}

// 4. FETCH DATA (Prepared Statement)
$query = "SELECT * FROM student_payments WHERE student_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Database error."]);
    exit();
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $monthName = $row['paid_for_month'];
    $year = $row['paid_for_year'];
    $transDate = date("d/m/Y", strtotime($row['transaction_date']));

    // 5. CALCULATE DUE DATE (Logic: 25th of the NEXT month)
    // We create a date string like "25 November 2025" and add 1 month
    $lastPaidDateString = "25 $monthName $year"; 
    $nextDueDate = date("d/m/Y", strtotime("+1 month", strtotime($lastPaidDateString)));

    echo json_encode([
        "status" => "success",
        "last_payment" => "$transDate for $monthName $year",
        "next_due" => $nextDueDate,
        "skip_reason" => $row['skip_reason']
    ]);
} else {
    echo json_encode([
        "status" => "empty",
        "message" => "No payment history found.",
        "next_due" => "Immediate Payment Required"
    ]);
}

$stmt->close();
$conn->close();
?>
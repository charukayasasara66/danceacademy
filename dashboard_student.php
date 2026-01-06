<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: index.html");
    exit();
}

$class_id = $_SESSION['class_id'];
$classInfo = null;
if($class_id) {
    $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $classInfo = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body { background-color: #050505; color: #f1faee; font-family: 'Montserrat', sans-serif; text-align: center; padding-top: 50px; }
        .card { max-width: 500px; margin: 0 auto; background: #111; border: 1px solid #d4af37; padding: 40px; border-radius: 20px; }
        h1 { font-family: 'Cinzel', serif; color: #d4af37; margin-bottom: 30px; }
        .detail { font-size: 1.1rem; margin: 15px 0; color: #ccc; }
        
        /* Payment Box */
        .payment-box { background: rgba(212, 175, 55, 0.1); padding: 20px; border-radius: 10px; margin-top: 20px; border: 1px solid #d4af37; }
        .pay-label { font-size: 0.9rem; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .pay-value { font-size: 1.3rem; color: #fff; font-weight: bold; margin-bottom: 15px; }
        .due-date { color: #ff4444; font-size: 1.4rem; text-shadow: 0 0 10px rgba(255,0,0,0.3); }
        
        .logout { display: inline-block; margin-top: 30px; color: #e63946; text-decoration: none; border: 1px solid #e63946; padding: 10px 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>My Class Portal</h1>
        <p>Welcome, <?php echo $_SESSION['name']; ?></p>
        
        <?php if($classInfo): ?>
            <h2 style="color:white;"><?php echo $classInfo['subject']; ?></h2>
            <p class="detail"><?php echo $classInfo['branch']; ?> | <?php echo $classInfo['grade']; ?></p>
            <p class="detail" style="color: #d4af37;"><?php echo $classInfo['day_time']; ?></p>
        <?php endif; ?>

        <div class="payment-box">
            <div class="pay-label">Last Payment</div>
            <div class="pay-value" id="lastPay">Loading...</div>
            
            <div class="pay-label">Next Due Date</div>
            <div class="pay-value due-date" id="nextDue">Loading...</div>
        </div>

        <a href="logout.php" class="logout">LOGOUT</a>
    </div>

    <script>
        // Fetch Payment Data on Load
        window.onload = async function() {
            const studentID = "<?php echo $_SESSION['username']; ?>";
            const res = await fetch('get_payment_status.php', { method:'POST', body:JSON.stringify({student_id: studentID}) });
            const data = await res.json();
            
            if(data.status === 'success') {
                document.getElementById('lastPay').innerText = data.last_payment;
                document.getElementById('nextDue').innerText = data.next_due;
            } else {
                document.getElementById('lastPay').innerText = "No records yet";
                document.getElementById('nextDue').innerText = "Pending";
            }
        };
    </script>
</body>
</html>
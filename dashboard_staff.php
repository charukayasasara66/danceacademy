<?php
session_start();
include 'db_connect.php';

// Security Check
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'staff')) {
    header("Location: index.html");
    exit();
}

$currentUser = $_SESSION['username'];
$isAdmin = ($_SESSION['role'] == 'admin'); 
// CHECK: Is this user allowed to manage payments? (Director OR Accountant)
$canManagePayments = ($currentUser == 'add username' || $currentUser == 'add username');
$message = "";

// --- FORM SUBMISSIONS ---
if (isset($_POST['reg_staff']) && $isAdmin) {
    $s_name = $_POST['staff_name'];
    $s_id = $_POST['staff_id'];
    $s_pass = password_hash($_POST['staff_pass'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, full_name) VALUES (?, ?, 'staff', ?)");
    $stmt->bind_param("sss", $s_id, $s_pass, $s_name);
    if($stmt->execute()) $message = "Staff Member Registered!";
    else $message = "Error: " . $conn->error;
}

if (isset($_POST['reg_student'])) {
    $st_name = $_POST['student_name'];
    $st_id = $_POST['student_id'];
    $st_pass = password_hash($_POST['student_pass'], PASSWORD_DEFAULT);
    $st_grade = $_POST['student_grade'];
    $st_branch = $_POST['student_branch'];
    $st_class = $_POST['student_class'];
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, full_name, grade, branch, enrolled_class_id) VALUES (?, ?, 'student', ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $st_id, $st_pass, $st_name, $st_grade, $st_branch, $st_class);
    if($stmt->execute()) $message = "Student Registered Successfully!";
    else $message = "Error: " . $conn->error;
}

// --- DATA FETCHING ---
$classQuery = $conn->query("SELECT id, subject, day_time, branch, grade FROM classes ORDER BY branch, grade");
$studentListQuery = $conn->query("SELECT full_name FROM users WHERE role = 'student' ORDER BY full_name ASC");
$staffListQuery = ($isAdmin) ? $conn->query("SELECT full_name FROM users WHERE role = 'staff' ORDER BY full_name ASC") : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academy Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #050505; color: #f1faee; font-family: 'Montserrat', sans-serif; padding: 20px; }
        h1, h2 { font-family: 'Cinzel', serif; color: #d4af37; }
        .container { max-width: 900px; margin: 0 auto; }
        .card { background: rgba(255,255,255,0.05); border: 1px solid #333; padding: 30px; border-radius: 15px; margin-bottom: 20px; animation: fadeIn 0.5s; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; background: #111; border: 1px solid #444; color: white; border-radius: 5px; }
        button { background: #d4af37; color: black; padding: 12px 20px; border: none; cursor: pointer; font-weight: bold; width: 100%; margin-top: 10px; border-radius: 5px; transition: 0.3s; }
        button:hover { background: white; box-shadow: 0 0 15px #d4af37; }
        
        .nav-btn { width: auto; margin-right: 10px; background: #222; color: #888; border: 1px solid #444; margin-bottom: 10px; }
        .nav-btn.active { background: #d4af37; color: black; border-color: #d4af37; }

        .result-box { margin-top: 20px; border-top: 1px solid #444; padding-top: 20px; display: none; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #222; }
        .detail-label { color: #888; } .detail-val { color: #d4af37; font-weight: bold; text-align: right; }
        
        /* Payment Styles */
        .payment-section { margin-top: 20px; padding: 15px; background: rgba(212, 175, 55, 0.1); border-radius: 10px; border: 1px solid #d4af37; display: none; }
        .pay-btn { background: #28a745; color: white; } .pay-btn:hover { background: #2ecc71; }
        
        /* Report Table */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; color: #ccc; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background: #222; color: #d4af37; }
        .total-row { background: rgba(212, 175, 55, 0.2); font-weight: bold; color: white; font-size: 1.1rem; }

        .delete-btn { background: #8a0000; color: white; border: 1px solid #ff0000; margin-top: 20px; }
        .alert { background: #222; border-left: 4px solid #d4af37; padding: 15px; margin-bottom: 20px; }
        .logout { float: right; color: #e63946; text-decoration: none; font-weight: bold; border: 1px solid #e63946; padding: 5px 15px; border-radius: 4px; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout">LOGOUT</a>
        <h1>Manager Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['name']; ?></p>

        <?php if($message) echo "<div class='alert'>$message</div>"; ?>

        <div style="display:flex; margin-bottom:20px; flex-wrap: wrap;">
            <button class="nav-btn active" onclick="showForm('studentForm', this)">Register Student</button>
            <button class="nav-btn" onclick="showForm('searchForm', this)">Search Student</button>
            
            <?php if($canManagePayments): ?>
                <button class="nav-btn" onclick="showForm('reportForm', this)" style="border-color: #28a745; color: #28a745;">Financial Report</button>
            <?php endif; ?>

            <?php if($isAdmin): ?>
                <button class="nav-btn" onclick="showForm('staffForm', this)" style="border-color: #e63946;">Register Staff</button>
                <button class="nav-btn" onclick="showForm('searchStaffForm', this)" style="border-color: #e63946;">Search Staff</button>
            <?php endif; ?>
        </div>

        <div id="studentForm" class="card">
            <h2>Register New Student</h2>
            <form method="POST">
                <input type="text" name="student_name" placeholder="Student Full Name" required>
                <input type="text" name="student_id" placeholder="Student ID (e.g. std2025001)" required>
                <input type="text" name="student_pass" placeholder="Create Password" required>
                <div style="display:flex; gap:10px;">
                    <select name="student_branch" required><option>Horana</option><option>Gampaha</option><option>Kaduwela</option></select>
                    <select name="student_grade" required><option>Nursery</option><option>Grade 1</option><option>Grade 2</option><option>Grade 3</option><option>Grade 4</option><option>Grade 5</option><option>Grade 6</option><option>Grade 7</option><option>Grade 8</option><option>Grade 9</option><option>Grade 10</option><option>Grade 11</option><option>Grade 12</option><option>Grade 13</option><option>Adult</option></select>
                </div>
                <select name="student_class" required>
                    <option value="" disabled selected>Select Class...</option>
                    <?php $classQuery->data_seek(0); while($row = $classQuery->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['branch'] . " - " . $row['grade'] . " - " . $row['subject'] . " (" . $row['day_time'] . ")"; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="reg_student">REGISTER STUDENT</button>
            </form>
        </div>

        <div id="searchForm" class="card" style="display:none;">
            <h2>Find Student</h2>
            <input type="text" id="searchNameInput" list="studentNames" placeholder="Type name..." autocomplete="off">
            <datalist id="studentNames"><?php while($row = $studentListQuery->fetch_assoc()): ?><option value="<?php echo $row['full_name']; ?>"><?php endwhile; ?></datalist>
            <button onclick="searchStudent()">GET DETAILS</button>
            
            <div id="resultBox" class="result-box">
                <h3>Student Profile</h3>
                <div class="detail-row"><span class="detail-label">Name:</span> <span class="detail-val" id="resName"></span></div>
                <div class="detail-row"><span class="detail-label">ID:</span> <span class="detail-val" id="resID"></span></div>
                <div class="detail-row"><span class="detail-label">Grade:</span> <span class="detail-val" id="resGrade"></span></div>
                <div class="detail-row"><span class="detail-label">Enrolled:</span> <span class="detail-val" id="resClass"></span></div>
                <div id="studentDeleteContainer"></div>
            
                <div id="paymentSection" class="payment-section">
                    <h4 style="color:#d4af37;"><i class="fas fa-money-bill-wave"></i> Payment Status</h4>
                    <div class="detail-row"><span class="detail-label">Last Payment:</span> <span class="detail-val" id="lastPayVal">Loading...</span></div>
                    
                    <h4 style="color:#fff; margin-top:15px; margin-bottom:5px;">Update Payment</h4>
                    <select id="payYear"><option value="2024">2024</option><option value="2025" selected>2025</option><option value="2026">2026</option></select>
                    <select id="payMonth"><option>January</option><option>February</option><option>March</option><option>April</option><option>May</option><option>June</option><option>July</option><option>August</option><option>September</option><option>October</option><option>November</option><option>December</option></select>
                    <input type="number" id="payAmount" placeholder="Amount (LKR)" style="border-color: #28a745; color:#28a745; font-weight:bold;">
                    
                    <div style="text-align:left; margin:10px 0;">
                        <label style="color:#888; font-size:0.9rem;"><input type="checkbox" onchange="toggleReason(this)"> Student skipped month?</label>
                        <select id="skipReason" style="display:none; margin-top:5px;"><option value="" disabled selected>Select Reason</option><option>Medical Reason</option><option>Financial Difficulty</option><option>Out of Country</option><option>Other</option></select>
                    </div>
                    <button class="pay-btn" onclick="updatePayment()">CONFIRM PAYMENT</button>
                </div>
            </div>
        </div>

        <?php if($canManagePayments): ?>
        <div id="reportForm" class="card" style="display:none;">
            <h2 style="color:#28a745;">Payment Report</h2>
            <p style="color:#888; font-size:0.9rem;">Generate report for Accountant/Director</p>
            
            <div style="display:flex; gap:10px; align-items:center;">
                <div style="flex:1;"><label style="color:#888;">From:</label><input type="date" id="reportStart"></div>
                <div style="flex:1;"><label style="color:#888;">To:</label><input type="date" id="reportEnd"></div>
            </div>
            
            <button onclick="getReport()" style="background: #28a745; color: white;">GENERATE REPORT</button>

            <div id="reportResult" style="display:none;">
                <table id="reportTable">
                    <thead><tr><th>Date</th><th>Student Name</th><th>ID</th><th>Month Paid</th><th>Amount (LKR)</th></tr></thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr class="total-row"><td colspan="4" style="text-align:right;">TOTAL EARNED:</td><td id="reportTotal">0.00</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php if($isAdmin): ?>
        <div id="staffForm" class="card" style="display:none;">
            <h2 style="color:#e63946;">Register Staff</h2>
            <form method="POST"><input type="text" name="staff_name" placeholder="Full Name" required><input type="text" name="staff_id" placeholder="Staff ID" required><input type="text" name="staff_pass" placeholder="Password" required><button type="submit" name="reg_staff" style="background:#e63946; color:white;">CREATE ACCOUNT</button></form>
        </div>
        <div id="searchStaffForm" class="card" style="display:none;">
            <h2 style="color:#e63946;">Search Staff</h2>
            <input type="text" id="searchStaffInput" list="staffNames" placeholder="Type name..." autocomplete="off">
            <datalist id="staffNames"><?php if ($staffListQuery) { while($row = $staffListQuery->fetch_assoc()) { echo "<option value='" . $row['full_name'] . "'>"; } } ?></datalist>
            <button onclick="searchStaff()" style="background:#e63946; color:white;">VIEW PROFILE</button>
            <div id="staffResultBox" class="result-box">
                <h3 style="color:#e63946;">Staff Profile</h3>
                <div class="detail-row"><span class="detail-label">Name:</span> <span class="detail-val" id="sResName"></span></div>
                <div class="detail-row"><span class="detail-label">ID:</span> <span class="detail-val" id="sResID"></span></div>
                <div class="detail-row"><span class="detail-label">Joined:</span> <span class="detail-val" id="sResJoined"></span></div>
                <div id="staffDeleteContainer"></div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script>
        const IS_ADMIN = <?php echo $isAdmin ? 'true' : 'false'; ?>;
        const CAN_PAY = <?php echo $canManagePayments ? 'true' : 'false'; ?>;
        let currentStudentID = "";

        function showForm(id, btn) {
            const forms = ['studentForm', 'searchForm', 'staffForm', 'searchStaffForm', 'reportForm'];
            forms.forEach(f => { const el = document.getElementById(f); if(el) el.style.display = 'none'; });
            const target = document.getElementById(id); if(target) target.style.display = 'block';
            let buttons = document.getElementsByClassName('nav-btn');
            for(let b of buttons) b.classList.remove('active');
            if(btn) btn.classList.add('active');
        }

        async function searchStudent() {
            const name = document.getElementById('searchNameInput').value;
            if(!name) { alert("Enter a name"); return; }
            try {
                const res = await fetch('search_student.php', { method:'POST', body:JSON.stringify({name}), headers:{'Content-Type':'application/json'} });
                const data = await res.json();
                if(data.status === 'success') {
                    document.getElementById('resName').innerText = data.data.name;
                    document.getElementById('resID').innerText = data.data.id;
                    currentStudentID = data.data.id; 
                    document.getElementById('resGrade').innerText = data.data.grade;
                    document.getElementById('resClass').innerText = data.data.class;
                    document.getElementById('resultBox').style.display = 'block';

                    if(IS_ADMIN) {
                         const btnHTML = `<button class="delete-btn" onclick="deleteUser('${data.data.id}', '${data.data.name}')">PERMANENTLY REMOVE STUDENT</button>`;
                         document.getElementById('studentDeleteContainer').innerHTML = btnHTML;
                    }
                    if(CAN_PAY) {
                        document.getElementById('paymentSection').style.display = 'block';
                        loadPaymentStatus(data.data.id);
                    }
                } else { alert("Student not found"); }
            } catch(e) { console.error(e); }
        }

        async function searchStaff() {
            const name = document.getElementById('searchStaffInput').value;
            if(!name) { alert("Enter a name"); return; }
            try {
                const res = await fetch('search_staff.php', { method:'POST', body:JSON.stringify({name}), headers:{'Content-Type':'application/json'} });
                const data = await res.json();
                if(data.status === 'success') {
                    document.getElementById('sResName').innerText = data.data.name;
                    document.getElementById('sResID').innerText = data.data.id;
                    document.getElementById('sResJoined').innerText = data.data.joined;
                    document.getElementById('staffResultBox').style.display = 'block';
                    document.getElementById('staffDeleteContainer').innerHTML = `<button class="delete-btn" onclick="deleteUser('${data.data.id}', '${data.data.name}')">PERMANENTLY REMOVE STAFF</button>`;
                } else { alert("Staff not found"); }
            } catch(e) { console.error(e); }
        }

        async function loadPaymentStatus(id) {
            const res = await fetch('get_payment_status.php', { method:'POST', body:JSON.stringify({student_id: id}) });
            const data = await res.json();
            document.getElementById('lastPayVal').innerText = (data.status === 'success') ? data.last_payment : "No records yet";
        }

        function toggleReason(checkbox) { document.getElementById('skipReason').style.display = checkbox.checked ? 'block' : 'none'; }

        async function updatePayment() {
            const year = document.getElementById('payYear').value;
            const month = document.getElementById('payMonth').value;
            const amount = document.getElementById('payAmount').value;
            const reason = (document.getElementById('skipReason').style.display === 'block') ? document.getElementById('skipReason').value : null;

            if(!currentStudentID) return;
            if(!reason && !amount) { alert("Please enter amount."); return; }
            if(confirm(`Confirm payment?`)) {
                const res = await fetch('save_payment.php', { method:'POST', body:JSON.stringify({student_id: currentStudentID, year: year, month: month, amount: amount, reason: reason}) });
                const result = await res.json();
                alert(result.message);
                loadPaymentStatus(currentStudentID);
            }
        }

        async function deleteUser(id, name) {
            if(confirm(`WARNING: Permanently delete ${name}?`)) {
                const res = await fetch('delete_user.php', { method: 'POST', body: JSON.stringify({ id: id }), headers: {'Content-Type': 'application/json'} });
                const result = await res.json();
                alert(result.message);
                if(result.status === 'success') location.reload();
            }
        }

        // --- NEW REPORT FUNCTION ---
        async function getReport() {
            const start = document.getElementById('reportStart').value;
            const end = document.getElementById('reportEnd').value;
            
            if(!start || !end) { alert("Please select both dates."); return; }

            const res = await fetch('get_payment_report.php', {
                method: 'POST',
                body: JSON.stringify({ startDate: start, endDate: end }),
                headers: {'Content-Type': 'application/json'}
            });
            const result = await res.json();

            const tbody = document.querySelector('#reportTable tbody');
            tbody.innerHTML = ''; // Clear old results

            if(result.status === 'success' && result.data.length > 0) {
                result.data.forEach(row => {
                    const tr = `<tr>
                        <td>${row.formatted_date}</td>
                        <td>${row.full_name}</td>
                        <td>${row.student_id}</td>
                        <td>${row.paid_for_month} ${row.paid_for_year}</td>
                        <td>LKR ${row.amount}</td>
                    </tr>`;
                    tbody.innerHTML += tr;
                });
                document.getElementById('reportTotal').innerText = "LKR " + result.total;
                document.getElementById('reportResult').style.display = 'block';
            } else {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:20px;">No payments found for this period.</td></tr>';
                document.getElementById('reportTotal').innerText = "0.00";
                document.getElementById('reportResult').style.display = 'block';
            }
        }
    </script>
</body>
</html>
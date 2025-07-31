<?php
session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "garage_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users with their selected services
$sql = "
    SELECT u.id AS user_id, u.name AS username, u.email, u.created_at, 
           s.id AS service_id, s.service_name, s.service_date
    FROM users u
    LEFT JOIN user_services s ON u.id = s.user_id
    ORDER BY u.created_at DESC, s.service_date DESC
";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Query error: " . $conn->error);
}

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[$row['user_id']]['username'] = $row['username'];
    $users[$row['user_id']]['email'] = $row['email'];
    $users[$row['user_id']]['created_at'] = $row['created_at'];
    $users[$row['user_id']]['services'][] = [
        'service_name' => $row['service_name'],
        'service_date' => $row['service_date']
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Garage</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .dashboard {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            background-color: #fff;
        }

        .logout-btn {
            background: #dc3545;
            border: none;
            padding: 10px 20px;
            color: white;
            cursor: pointer;
            float: right;
            margin-top: -50px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome, Admin</h1>
    <form method="post">
        <button type="submit" name="logout" class="logout-btn">Logout</button>
    </form>
</div>

<div class="dashboard">
    <h2>Users and Their Services</h2>

    <?php foreach ($users as $user_id => $user): ?>
        <h3>User: <?= htmlspecialchars($user['username']) ?></h3>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Registered On: <?= htmlspecialchars($user['created_at']) ?></p>
        
        <h4>Services:</h4>
        <table>
            <tr>
                <th>Service Name</th>
                <th>Service Date</th>
            </tr>
            <?php if (count($user['services']) > 0): ?>
                <?php foreach ($user['services'] as $service): ?>
                    <tr>
                        <td><?= htmlspecialchars($service['service_name']) ?: 'No Service' ?></td>
                        <td><?= htmlspecialchars($service['service_date']) ?: 'N/A' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">No services booked</td></tr>
            <?php endif; ?>
        </table>
        <hr>
    <?php endforeach; ?>

</div>

<?php
// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

</body>
</html>

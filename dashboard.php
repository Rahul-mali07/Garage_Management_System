<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "garage_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user services
$sql = "SELECT * FROM services WHERE user_id='$user_id'";
$services_result = $conn->query($sql);
// Fetch user details
$user_query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
$user_result = mysqli_query($conn, $user_query);
$user_details = mysqli_fetch_assoc($user_result);

if (!$user_details) {
    echo "No user details found in the database.";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - Garage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .services {
            margin-top: 20px;
        }

        .services table {
            width: 100%;
            border-collapse: collapse;
        }

        .services th, .services td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $user_name; ?>!</h2>

        <div class="user-info">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name'] ?? $user_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email'] ?? 'Not available'); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['phone'] ?? 'Not available'); ?></p>
        </div>

        <div class="services">
            <h3>Your Service History</h3>
            <?php if ($services_result->num_rows > 0) { ?>
                <table>
                    <tr>
                        <th>Service Name</th>
                        <th>Service Date</th>
                    </tr>
                    <?php while ($row = $services_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['service_date']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>You have not booked any services yet.</p>
            <?php } ?>
        </div>

        <a href="services.php"><button>Book New Service</button></a>
        <a href="logout.php"><button>Logout</button></a>
        <a href="history.php"><button>History</button></a>
    </div>
</body>
</html>

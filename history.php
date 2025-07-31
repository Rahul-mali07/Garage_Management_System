<?php
session_start();
include('config.php');

// Check if user is logged in and session values exist
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    echo "User not logged in. Redirecting to login page...";
    header("refresh:2;url=login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
$user_result = mysqli_query($conn, $user_query);
$user_details = mysqli_fetch_assoc($user_result);

if (!$user_details) {
    echo "No user details found in the database.";
    exit();
}

// Fetch user's service history
$services_query = "SELECT * FROM user_services WHERE user_id = '$user_id' ORDER BY service_date DESC";
$services_result = mysqli_query($conn, $services_query);

$total_price = 0;
$selected_services = [];

while ($row = mysqli_fetch_assoc($services_result)) {
    $selected_services[] = $row;
    $total_price += $row['service_price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service History - Apna Garage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f7;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #2c3e50;
            padding: 20px;
            color: white;
            text-align: center;
        }
        .container {
            padding: 30px;
            max-width: 800px;
            margin: auto;
            background-color: white;
            margin-top: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .user-details p {
            font-size: 18px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #2c3e50;
            color: white;
        }
        .total-price {
            text-align: right;
            font-size: 20px;
            margin-top: 20px;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .back-btn:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Service History for <?php echo htmlspecialchars($user_name); ?></h1>
</div>

<div class="container">
    <div class="user-details">
        <h3>User Details:</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name'] ?? $user_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email'] ?? 'Not available'); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['phone'] ?? 'Not available'); ?></p>
    </div>

    <h3>Your Selected Services:</h3>
    <?php if (count($selected_services) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Price (₹)</th>
                    <th>Service Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($selected_services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                        <td>₹<?php echo htmlspecialchars($service['service_price']); ?></td>
                        <td><?php echo date("d-m-Y H:i", strtotime($service['service_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-price">
            <strong>Total: ₹<?php echo $total_price; ?></strong>
        </div>
    <?php else: ?>
        <p>No service history found.</p>
    <?php endif; ?>

    <a href="services.php" class="back-btn">Back to Services</a>
</div>

</body>
</html>

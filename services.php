<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

$services = [
    ['name' => 'Oil Change', 'price' => 500],
    ['name' => 'Tire Replacement', 'price' => 1000],
    ['name' => 'Car Wash', 'price' => 300],
    ['name' => 'Brake Inspection', 'price' => 400],
    ['name' => 'Battery Replacement', 'price' => 1200],
    ['name' => 'Engine Tuning', 'price' => 1500],
    ['name' => 'AC Repair', 'price' => 800],
    ['name' => 'Wheel Alignment', 'price' => 600]
];

// Store all services in session so bill.php can access
$_SESSION['all_services'] = $services;

// Include database connection
include('config.php');

// Check if the form is submitted and save the selected services
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['services'])) {
    $selected_services = $_POST['services'];

    foreach ($selected_services as $service_name) {
        // Find the price of the selected service
        foreach ($services as $service) {
            if ($service['name'] == $service_name) {
                $service_price = $service['price'];
                break;
            }
        }

        // Insert the selected service into the user_services table
        $query = "INSERT INTO user_services (user_id, service_name, service_price) VALUES ('$user_id', '$service_name', '$service_price')";
        mysqli_query($conn, $query);
    }

    // Redirect to the bill page after saving the services
    header("Location: bill.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Services - Apna Garage</title>
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
        .service {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .service label {
            font-size: 18px;
        }
        .submit-btn {
            padding: 10px 25px;
            background-color: #27ae60;
            color: white;
            border: none;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .submit-btn:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p>Please select the services you want:</p>
</div>

<div class="container">
    <form action="services.php" method="post">
        <?php foreach ($services as $service): ?>
            <div class="service">
                <label>
                    <input type="checkbox" name="services[]" value="<?php echo $service['name']; ?>">
                    <?php echo $service['name']; ?> - ₹<?php echo $service['price']; ?>
                </label>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Submit" class="submit-btn">
    </form>
</div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

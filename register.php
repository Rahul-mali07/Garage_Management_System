<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "garage_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, password)
            VALUES ('$name', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Garage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        input, button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 15px;
        }

        a {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Garage Registration</h2>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phone" placeholder="Phone Number" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Register</button>
        </form>
        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "garage_db";

// Create DB connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = "";
$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $message = $conn->real_escape_string($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if ($conn->query($sql) === TRUE) {
            $response = "Message sent successfully! Redirecting to home...";
            header("refresh:5;url=index.php");
        } else {
            $response = "Error: " . $conn->error;
        }
    } else {
        $response = "Please fill in all the fields.";
    }
}

// Fetch message history
$result = $conn->query("SELECT name, email, message, created_at FROM contact_messages ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Apna Garage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #20232a;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .nav {
            background-color: #333;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .nav a {
            color: white;
            text-align: center;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .nav a:hover {
            background-color: #575757;
            border-radius: 5px;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .response {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .response.success { color: green; }
        .response.error { color: red; }

        form label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 20px;
            background-color: #20232a;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #333;
        }

        .history {
            margin-top: 40px;
        }

        .message {
            background: #f7f7f7;
            padding: 15px;
            border-left: 4px solid #20232a;
            margin-bottom: 10px;
        }

        .message strong {
            color: #111;
        }

        .message small {
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Apna Garage</h1>
        <p>We care for your vehicle!</p>
    </div>

    <div class="nav">
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>

    <div class="container">
        <h2>Contact Us</h2>
        <?php if (!empty($response)): ?>
            <p class="response <?php echo strpos($response, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($response); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="contact_submit.php">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Your Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="message">Your Message:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>

        <div class="history">
            <h3>Message History</h3>
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="message">
                        <strong><?php echo htmlspecialchars($msg['name']); ?></strong>
                        <small>(<?php echo htmlspecialchars($msg['email']); ?>)</small><br>
                        <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                        <small><?php echo htmlspecialchars($msg['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No previous messages found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

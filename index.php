<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apna Garage - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            background-image: url("Garage background image.jpg");
            color: #333;
        }

        /* Header with Logo */
        .header {
            background-color: #1f1f1f;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .header img {
            height: 70px;
            border-radius: 10px;
        }

        .header h1 {
            font-size: 36px;
            margin: 0;
        }

        .header p {
            font-size: 18px;
            margin: 5px 0 0;
            color: #ccc;
        }

        /* Navigation */
        .nav {
            background-color: #2c2c2c;
            text-align: center;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 25px;
            font-size: 18px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav a:hover {
            color: #ff9800;
        }

        /* Hero Section */
        .hero-section {
            background-image: url('garage-hero.jpg'); /* Replace with your actual image */
            background-size: cover;
            background-position: center;
            height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .hero-text {
            position: relative;
            z-index: 1;
        }

        .hero-text h2 {
            font-size: 48px;
            margin: 0;
        }

        .hero-text p {
            font-size: 22px;
            margin-top: 10px;
        }

        /* Main Content */
        .main-content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 50px 20px;
            gap: 30px;
        }

        .service-box {
            background-color: #fff;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .service-box img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .service-box h3 {
            margin: 15px 0 10px;
            color: #333;
        }

        .service-box p {
            color: #666;
            font-size: 15px;
        }

        .cta-button {
            background-color: #ff9800;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #e68900;
        }

        /* Footer */
        .footer {
            background-color: #1f1f1f;
            color: #ccc;
            text-align: center;
            padding: 20px 0;
            margin-top: 60px;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
                align-items: center;
            }

            .nav a {
                margin: 0 15px;
            }

            .hero-text h2 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>


    <!-- Header Section with Logo -->
    <div class="header">
        <div class="header-content">
            <img src="logo.png" alt="Apna Garage Logo"> <!-- Place your logo image here -->
            <div>
                <h1> Garage Management System</h1>
                <p>Your Trusted Garage for All Car Services</p>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="login.php">Login</a>
        <a href="contact.php">Contact</a>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-text">
            <h2>Welcome to Apna Garage</h2>
            <p>Your car is in safe hands with us</p>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <!-- Service 1 -->
        <div class="service-box">
             <!-- Replace with your image -->
            <h3>Oil Change</h3>
            <p>Keep your engine running smoothly with our top-quality oil change services.</p>
            <a href="services.php" class="cta-button">Book Now</a>
        </div>

        <!-- Service 2 -->
        <div class="service-box">
            <alt="Tire Replacement"> <!-- Replace with your image -->
            <h3>Tire Replacement</h3>
            <p>Drive safely with new tires. Get your tire replacement done today.</p>
            <a href="services.php" class="cta-button">Book Now</a>
        </div>

        <!-- Service 3 -->
        <div class="service-box">
         <!-- Replace with your image -->
            <h3>Car Wash</h3>
            <p>Get your car sparkling clean with our eco-friendly car wash service.</p>
            <a href="services.php" class="cta-button">Book Now</a>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2025 Apna Garage. All rights reserved.</p>
    </div>

</body>
</html>

<?php
// Database credentials - **MAKE SURE TO UPDATE THESE WITH YOUR ACTUAL DETAILS**
$servername = "localhost"; // Or your database host
$username = "root";     // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "tourism_db";        // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form and sanitize it to prevent basic XSS
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : null; // Country is optional
    $remarks = isset($_POST['remarks']) ? htmlspecialchars($_POST['remarks']) : null; // Remarks are optional

    // Prepare and execute the SQL query using prepared statements
    $sql = "INSERT INTO contacts (name, email, country, remarks) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $country, $remarks);

    if ($stmt->execute()) {
        echo "Thank you for contacting us! We will get back to you shortly.";
        // Optionally, you can redirect the user to a thank-you page:
        // header("Location: thank_you.html");
        // exit();
    } else {
        echo "Oops! Something went wrong. Please try again later. Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // If the script is accessed directly without a POST request
    echo "This script is intended to handle form submissions.";
}

$conn->close();
?>
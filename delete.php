<?php
// Check if patient ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger mt-3'>Patient ID is missing.</div>";
    exit; 
}

$patient_id = $_GET['id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospitaldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete patient from the database
$sql_delete = "DELETE FROM hospital_management WHERE id=$patient_id";

if ($conn->query($sql_delete) === TRUE) {
    // Redirect to home page
    header("Location: index.php");
    exit; // Stop script execution after redirect
} else {
    echo "<div class='alert alert-danger mt-3'>Error deleting patient: " . $conn->error . "</div>";
}

$conn->close();
?>

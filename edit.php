<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient - Life Style Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Edit Patient</h2>
        <?php
        // Check if patient ID is provided
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo "<div class='alert alert-danger mt-3'>Patient ID is missing.</div>";
            exit; // Stop script execution
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

        // Retrieve patient details from database
        $sql = "SELECT * FROM hospital_management WHERE id = $patient_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger mt-3'>Patient not found.</div>";
            exit; // Stop script execution
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $phone = $conn->real_escape_string($_POST['phone']);
            $address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : NULL;
            $health_issue = $conn->real_escape_string($_POST['health_issue']);

            // Validate phone number
            if (!preg_match("/^\d{10}$/", $phone)) {
                echo "<div class='alert alert-danger mt-3'>Please enter a valid 10-digit phone number.</div>";
            } 
            // Validate email
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='alert alert-danger mt-3'>Please enter a valid email address.</div>";
            } 
            else {
                // Update patient details in the database
                $sql_update = "UPDATE hospital_management SET name='$name', email='$email', phone='$phone', address='$address', health_issue='$health_issue' WHERE id=$patient_id";

                if ($conn->query($sql_update) === TRUE) {
                    echo "<div class='alert alert-success mt-3'>Patient details updated successfully</div>";
                    // Redirect to patient list page after successful update
                    header("Location: index.php");
                    exit; // Stop script execution after redirect
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error updating patient details: " . $conn->error . "</div>";
                }
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$patient_id"; ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" pattern="\d{10}" title="Please enter a 10-digit phone number" value="<?php echo $row['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>">
            </div>
            <div class="mb-3">
                <label for="health_issue" class="form-label">Health Issue</label>
                <input type="text" class="form-control" id="health_issue" name="health_issue" value="<?php echo $row['health_issue']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Patient</button>
        </form>
    </div>
</body>

</html>

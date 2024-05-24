<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient - Life Style Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Add Patient</h2>
        <form action="add.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" pattern="\d{10}" title="Please enter a 10-digit phone number" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="health_issue" class="form-label">Health Issue</label>
                <input type="text" class="form-control" id="health_issue" name="health_issue" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Patient</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $phone = $conn->real_escape_string($_POST['phone']);
            $address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : NULL;
            $health_issue = $conn->real_escape_string($_POST['health_issue']);
            $registered_at = date("Y-m-d");

            // Validate phone number
            if (!preg_match("/^\d{10}$/", $phone)) {
                echo "<div class='alert alert-danger mt-3'>Please enter a valid 10-digit phone number.</div>";
            } 
            // Validate email
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='alert alert-danger mt-3'>Please enter a valid email address.</div>";
            } 
            else {
                $sql = "INSERT INTO hospital_management (name, email, phone, address, health_issue) 
                        VALUES ('$name', '$email', '$phone', " . ($address ? "'$address'" : "NULL") . ", '$health_issue')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success mt-3'>New patient added successfully</div>";
                    header("location: index.php");
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error:  could not add the patient " . $sql . "<br>" . $conn->error . "</div>";
                }
            }

            $conn->close();
            
        }
        ?>
        
        <a href="index.php" class="btn btn-secondary mt-3">Go to Main Page</a>
    </div>
</body>

</html>

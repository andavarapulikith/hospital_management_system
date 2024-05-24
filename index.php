<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Style Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center; 
        }

        .hospital-image {
            max-width: 100%; 
            height: auto;
            border-radius: 10px; 
            margin-bottom: 20px; 
        }

        .table {
            
            margin-bottom: 20px; 
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Life Style Hospital</h1>
        <img src="hospital_image.jpg" alt="Hospital Image" class="hospital-image">
        <div class="row">
            <div >
            <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Patient's List</h2>
            <a href="add.php" class="btn btn-primary">Add Patient</a>
        </div>
                <br><br>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Health Issue</th>
                            <th>Registered Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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

                        $sql = "SELECT id, name, email, phone, address, health_issue, registered_at FROM hospital_management";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['address']}</td>
                                    <td>{$row['health_issue']}</td>
                                    <td>{$row['registered_at']}</td>
                                    <td>
                                        <a class='btn btn-primary' href='edit.php?id={$row['id']}'>Edit</a>
                                        <a class='btn btn-danger' href='delete.php?id={$row['id']}'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No patients found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</body>

</html>
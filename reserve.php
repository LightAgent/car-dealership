<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Car</title>
    <link rel="stylesheet" href="bootstrap5/css/bootstrap.min.css">
</head>
<body>
    <?php include("templates/header.php");?>
    <div class="container">
        <h2>Reserve Car</h2>
        <?php
        if(isset($_GET['model']) && isset($_GET['year']) && isset($_GET['plateID']) && isset($_GET['baseRate']) && isset($_GET['location']) && isset($_GET['status'])) {
            echo "<p><strong>Model:</strong> ".$_GET['model']."</p>";
            echo "<p><strong>Year:</strong> ".$_GET['year']."</p>";
            echo "<p><strong>Plate ID:</strong> ".$_GET['plateID']."</p>";
            echo "<p><strong>Base Rate:</strong> ".$_GET['baseRate']."</p>";
            echo "<p><strong>Location:</strong> ".$_GET['location']."</p>";
            echo "<p><strong>Status:</strong> ".$_GET['status']."</p>";

            // Connect to your database
            require 'config/db_connect.php';

            // Query to get CarID and LocationID
            $plateID = $_GET['plateID'];
            $car_query = "SELECT CarID, LocationID FROM Cars WHERE PlateID = '$plateID'";
            $car_result = $conn->query($car_query);

            if ($car_result->num_rows > 0) {
                $car_row = $car_result->fetch_assoc();
                $carID = $car_row['CarID'];
                $locationID = $car_row['LocationID'];
            } else {
                echo "<p>Error: Car not found.</p>";
                exit(); // Exit if car not found
            }
            ?>
            <form method="POST" action="reserve_submit.php">
                <input type="hidden" name="carID" value="<?php echo $carID; ?>">
                <input type="hidden" name="locationID" value="<?php echo $locationID; ?>">
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                </div>
                <div class="mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="userName" name="userName" required>
                </div>
                <div class="mb-3">
                    <label for="dropoffLocationID" class="form-label">Drop-off Location ID</label>
                    <input type="number" class="form-control" id="dropoffLocationID" name="dropoffLocationID" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Reservation</button>
            </form>
            <?php
        } else {
            echo "<p>Invalid request. Please go back and try again.</p>";
        }
        ?>
    </div>
</body>
</html>





<!DOCTYPE html>
<html>
<head>
    <title>Car List</title>
    <style>
        .car-row {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }
        .car-details {
            display: none;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
    // Start the session
    session_start();

    // Create a new connection to the car_dealership database
    $connect = new mysqli('localhost', 'root', '', 'car_dealership');

    // Check connection
    if ($connect->connect_error) {
        die("Failed to connect: " . $connect->connect_error);
    }

    // Prepare the SQL statement to select all cars
    $query = "SELECT * FROM Cars";
    $result = $connect->query($query);

    // Check if there are any cars in the database
    if ($result->num_rows > 0) {
        // Print the list of cars
        echo "<h1>List of Cars</h1>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='car-row' onclick='toggleDetails(this)'>";
            echo "Model: " . $row["Model"] . " - Year: " . $row["Year_"] . " - Plate ID: " . $row["PlateID"];
            echo "</div>";
            echo "<div class='car-details'>";
            echo "<button>Reserve</button>";
            echo "<button>Pickup</button>";
            echo "<button>Return</button>";
            echo "<button>Payment</button>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    // Close the connection
    $connect->close();
    ?>

    <script>
        function toggleDetails(element) {
            var details = element.nextElementSibling;
            if (details.style.display === "none") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <link rel="stylesheet" href="bootstrap5/css/bootstrap.min.css">
    <script src="bootstrap5/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("templates/header.php");?>
    <div class="container">
        <h2>Available Cars</h2>
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-expanded="false" aria-controls="searchCollapse">
            Show/Hide Search
        </button>
        <div class="collapse" id="searchCollapse">
            <div class="card card-body">
                <form method="GET">
                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-control" id="model" name="model">
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" class="form-control" id="year" name="year">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>
                <div class="mb-3">
                    <label for="baseRateMin" class="form-label">Base Rate (Min)</label>
                    <input type="range" class="form-range" id="baseRateMin" name="baseRateMin" min="0" max="100" step="0.01" value="0.0">
                    <output for="baseRateMin" id="baseRateMinValue">0.00</output>
                </div>
                <div class="mb-3">
                    <label for="baseRateMax" class="form-label">Base Rate (Max)</label>
                    <input type="range" class="form-range" id="baseRateMax" name="baseRateMax" min="0" max="100" step="0.01" value="100.0">
                    <output for="baseRateMax" id="baseRateMaxValue">100.00</output>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="Available">Available</option>
                        <option value="Rented">Rented</option>
                        <option value="Out of Service">Out of Service</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            </div>
        </div>
        
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Plate ID</th>
                    <th>Base Rate</th>
                    <th>Location Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'config/db_connect.php';
                
                // Initialize the WHERE clause
                $whereClause = "";
                
                // Check if form submitted
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Check if fields are not empty and construct the WHERE clause
                    if (!empty($_GET["model"])) {
                        $whereClause .= " AND Model LIKE '%" . $_GET["model"] . "%'";
                    }
                    if (isset($_GET["baseRateMin"]) && isset($_GET["baseRateMax"])) {
                        $baseRateMin = $_GET["baseRateMin"] == 0 ? 0.00 : $_GET["baseRateMin"];
                        $baseRateMax = $_GET["baseRateMax"] == 0 ? 0.00 : $_GET["baseRateMax"];
                        $whereClause .= " AND BaseRate BETWEEN " . $baseRateMin . " AND " . $baseRateMax;
                    }
                    if (!empty($_GET["year"])) {
                        $whereClause .= " AND Year_ = " . $_GET["year"];
                    }
                    if (!empty($_GET["location"])) {
                        $whereClause .= " AND LocationName LIKE '%" . $_GET["location"] . "%'";
                    }
                    if (!empty($_GET["status"])) {
                        $whereClause .= " AND Status_ = '" . $_GET["status"] . "'";
                    }
                }

                // Fetch data from the database with the constructed WHERE clause
                $sql = "SELECT Model, Year_, PlateID, BaseRate, LocationName, Status_ FROM Cars NATURAL JOIN Locations WHERE 1=1 " . $whereClause;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["Model"] . "</td><td>" . $row["Year_"] . "</td><td>" . $row["PlateID"] . "</td><td>" . $row["BaseRate"] . "</td><td>" . $row["LocationName"] . "</td><td class='status' style='color:";
                        // Set color based on status
                        if ($row["Status_"] == "Available") {
                            echo "#02de18;'>Available</td>";
                        } elseif ($row["Status_"] == "Rented") {
                            echo "blue;'>Rented</td>";
                        } elseif ($row["Status_"] == "Out of Service") {
                            echo "red;'>Out of Service</td>";
                        }
                        // Add reservation button if status is Available
                        if ($row["Status_"] == "Available") {
                            echo "<td><button class='btn btn-primary'>Reserve</button></td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script>
        var baseRateMin = document.getElementById('baseRateMin');
        var baseRateMax = document.getElementById('baseRateMax');
        var baseRateMinValue = document.getElementById('baseRateMinValue');
        var baseRateMaxValue = document.getElementById('baseRateMaxValue');
        
        baseRateMin.addEventListener('input', function() {
            baseRateMinValue.value = baseRateMin.valueAsNumber;
        });

        baseRateMax.addEventListener('input', function() {
            baseRateMaxValue.value = baseRateMax.valueAsNumber;
        });
    </script>

</body>
</html>

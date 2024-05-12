<head>
    <link rel="stylesheet" href="../bootstrap5/css/bootstrap.min.css">
    <script src="../bootstrap5/js/bootstrap.bundle.min.js"></script>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/car-dealership/index.php">Car Dealership</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a <?php if ($_SERVER['SCRIPT_NAME'] == "/car-dealership/pages/register.php") { ?> 
                class="nav-link active" 
            <?php   } else {  ?>
                class="nav-link"
            <?php } ?>
                aria-current="page" href="/car-dealership/pages/register.php">Register</a>
            </li>
            <!-- <li class="nav-item">
            <a class="<?php echo $_SERVER['SCRIPT_NAME'] == "/car-dealership/pages/register.php"? "nav-link active" :"nav-link"?>" href="/pizza/add.php">Add Pizza</a>
            </li> -->
        </ul>
        <p class="navbar-text" style="margin-left: 5px;">Welcome: <?php echo htmlspecialchars($_COOKIE["name"]??"Unknown")?></p>
        <p class="navbar-text">Email: <?php echo htmlspecialchars($_SESSION["email"]??"Unknown mail")?></p>
        </div>
    </div>
</nav>
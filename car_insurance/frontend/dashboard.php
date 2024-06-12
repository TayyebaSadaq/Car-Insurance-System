<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: "Century Gothic", sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 10px 8px 10px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .main {
            transition: margin-left 0.5s;
            padding: 20px;
            margin-left: 250px;
            /* Adjusted to make space for the side nav */
        }

        .header {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1000px;
            /* Set maximum width for the container */
            margin: 0 auto;
            /* Center the container */
            display: flex;
            justify-content: space-around;
            /* Changed to display side by side */
            align-items: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        canvas {}

        #menuBtn {
            font-size: 30px;
            cursor: pointer;
            position: absolute;
            top: 15px;
            left: 15px;
        }
    </style>
</head>

<body>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/car_insurance/frontend/dashboard.php"><i class="fas fa-chart-pie"></i> Dashboard</a>
    <a href="/car_insurance/frontend/driver/driver.php"><i class="fas fa-user"></i> Drivers</a>
    <a href="/car_insurance/frontend/claims/claims.php"><i class="fas fa-file-alt"></i> Claims</a>
    <a href="/car_insurance/frontend/cars/cars.php"><i class="fas fa-car"></i> Cars</a>
</div>

<span id="menuBtn" onclick="openNav()">&#9776;</span>

<div class="main">
    <div class="header">
        Dashboard
    </div>

    <div style="margin: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 48%;
        max-width: 400px;
        height: 300px;">
        <canvas id="genderChart"></canvas>
    </div>

    <div style="margin: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 48%;
        max-width: 400px;
        height: 300px;">
        <canvas id="ageChart"></canvas>
    </div>

    <div style="margin: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 48%;
        max-width: 400px;
        height: 300px;">
        <canvas id="occupationChart"></canvas>
    </div>


    <?php
    // Database connection
    $servername = 'localhost';
    $db_name = 'car_insurance';
    $username = 'root';
    $password = '';


    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get gender differences in the number of claims made
    $genderQuery = "SELECT GENDER, COUNT(*) AS COUNT FROM driverprofile GROUP BY GENDER";
    $genderResult = $conn->query($genderQuery);
    $genderLabels = [];
    $genderData = [];

    while ($row = $genderResult->fetch_assoc()) {
        $genderLabels[] = $row['GENDER'];
        $genderData[] = $row['COUNT'];
    }

    // Query to get claim frequency on age groups
    $ageQuery = "SELECT CLM_FREQ, COUNT(*) AS COUNT FROM claimdetails GROUP BY CLM_FREQ";
    $ageResult = $conn->query($ageQuery);
    $ageLabels = [];
    $ageData = [];

    while ($row = $ageResult->fetch_assoc()) {
        $ageLabels[] = $row['CLM_FREQ'];
        $ageData[] = $row['COUNT'];
    }

    // Query to get occupation distribution from driverprofile
    $occupationQuery = "SELECT OCCUPATION, COUNT(*) AS COUNT FROM driverprofile GROUP BY OCCUPATION";
    $occupationResult = $conn->query($occupationQuery);
    $occupationLabels = [];
    $occupationData = [];

    while ($row = $occupationResult->fetch_assoc()) {
        $occupationLabels[] = $row['OCCUPATION'];
        $occupationData[] = $row['COUNT'];
    }

    $conn->close();
    ?>

    <script>
        var genderCtx = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($genderLabels); ?>,
                datasets: [{
                    label: 'Gender Differences in Claims Made',
                    data: <?php echo json_encode($genderData); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    display: false, // Hides the scale
                }
            }
        });

        var ageCtx = document.getElementById('ageChart').getContext('2d');
        var ageChart = new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($ageLabels); ?>,
                datasets: [{
                    label: 'Claim Frequency on Age Groups',
                    data: <?php echo json_encode($ageData); ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var occupationCtx = document.getElementById('occupationChart').getContext('2d');
        var occupationChart = new Chart(occupationCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($occupationLabels); ?>,
                datasets: [{
                    label: 'Occupation Distribution',
                    data: <?php echo json_encode($occupationData); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    display: false // Hides the scale
                }
            }
        });

        // Sidebar navigation functions
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.querySelector(".main").
                style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.querySelector(".main").style.marginLeft = "0";
        }
    </script>
</div>
</body>

</html>

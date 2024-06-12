<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Drivers</title>
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
        }

        .header {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        canvas {
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #menuBtn {
            font-size: 30px;
            cursor: pointer;
            position: absolute;
            top: 15px;
            left: 15px;
        }

        table {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .main {
            transition: margin-left 0.5s;
            padding: 20px;
            margin-left: 0;
            /* Set initial margin-left to 0 */
        }

        .container {
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            max-width: 1000px;
            /* Adjust the max-width to your preference */
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

    <div class="container my-5">
        <h1>Driver Profile</h1>
        <a class="btn btn-primary" href="create.php" role="button">Add Driver</a>
        <br>

        <!-- Display success message if exists -->
        <?php
        if (isset($_GET['message'])) {
            echo "<div class='alert alert-success my-3'>" . htmlspecialchars($_GET['message']) . "</div>";
        }
        ?>

        <!-- Search form -->
        <form action="" method="GET" class="my-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by Driver ID" name="search">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
                <a href="driver.php" class="btn btn-outline-secondary">Clear</a> <!-- Clear button -->
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Driver ID</th>
                    <th>Number of Kids</th>
                    <th>Age</th>
                    <th>Income</th>
                    <th>Marital Status</th>
                    <th>Gender</th>
                    <th>Education</th>
                    <th>Occupation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = 'localhost';
                $db_name = 'car_insurance';
                $username = 'root';
                $password = '';

                // Create connection
                $conn = new mysqli($servername, $username, $password, $db_name);

                // Check connection
                if ($conn->connect_error) {
                    die('Connection failed: ' . $conn->connect_error);
                }

                // Pagination variables
                $limit = 10; // Number of rows per page
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
                $offset = ($page - 1) * $limit; // Offset for MySQL query
                
                // Prepare the search query
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $search_query = $search ? "WHERE ID LIKE '%$search%'" : '';

                // Read rows with pagination and search
                $sql = "SELECT * FROM driverprofile $search_query LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Read data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "
            <tr>
                <td>" . $row['ID'] . "</td>
                <td>" . $row['KIDSDRIV'] . "</td>
                <td>" . $row['AGE'] . "</td>
                <td>" . $row['INCOME'] . "</td>
                <td>" . $row['MSTATUS'] . "</td>
                <td>" . $row['GENDER'] . "</td>
                <td>" . $row['EDUCATION'] . "</td>
                <td>" . $row['OCCUPATION'] . "</td>
                <td>
                    <a class='btn btn-primary' href='update.php?id=" . $row['ID'] . "' role='button'>Update</a>
                    <a class='btn btn-danger' href='delete.php?id=" . $row['ID'] . "' role='button'>Delete</a>
                </td>
            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No driver profiles found</td></tr>";
                }

                // Close the result set
                $result->close();

                // Calculate total number of pages
                $sql_total = "SELECT COUNT(*) AS total FROM driverprofile $search_query";
                $result_total = $conn->query($sql_total);
                $row_total = $result_total->fetch_assoc();
                $total_pages = ceil($row_total['total'] / $limit);

                // Close the database connection
                $conn->close();
                ?>

            </tbody>
        </table>

        <!-- Pagination links -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=1<?php echo $search ? '&search=' . $search : ''; ?>" aria-label="First">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . $search : ''; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo; Previous</span>
                    </a>
                </li>

                <?php if ($page > 2): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 2; ?><?php echo $search ? '&search=' . $search : ''; ?>"><?php echo $page - 2; ?></a></li>
                <?php endif; ?>
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . $search : ''; ?>"><?php echo $page - 1; ?></a></li>
                <?php endif; ?>

                <li class="page-item active"><a class="page-link" href="#"><?php echo $page; ?></a></li>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . $search : ''; ?>"><?php echo $page + 1; ?></a></li>
                <?php endif; ?>
                <?php if ($page < $total_pages - 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 2; ?><?php echo $search ? '&search=' . $search : ''; ?>"><?php echo $page + 2; ?></a></li>
                <?php endif; ?>

                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . $search : ''; ?>" aria-label="Next">
                        <span aria-hidden="true">Next &raquo;</span>
                    </a>
                </li>

                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $total_pages; ?><?php echo $search ? '&search=' . $search : ''; ?>" aria-label="Last">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <script>
            // Sidebar navigation functions
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
                document.querySelector(".main").style.marginLeft = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.querySelector(".main").style.marginLeft = "0";
            }
        </script>
    </div>
</body>

</html>

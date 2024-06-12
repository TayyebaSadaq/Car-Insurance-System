<?php
$ID = "";
$CAR_TYPE = "";
$RED_CAR = "";
$CAR_AGE = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST["ID"];
    $CAR_TYPE = $_POST["car_type"];
    $RED_CAR = $_POST["red_car"];
    $CAR_AGE = $_POST["car_age"];

    // Validate input data
    if (
        !isset($ID) ||
        !isset($CAR_TYPE) ||
        !isset($RED_CAR) ||
        !isset($CAR_AGE)
    ) {
        $errorMessage = "Please fill out all required fields";
    } else {
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "car_insurance");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the Car ID already exists
        $checkSql = "SELECT ID FROM cardetails WHERE ID = '$ID'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            $errorMessage = "Car ID already exists. Please use a different ID.";
        } else {
            // Prepare SQL statement
            $sql = "INSERT INTO cardetails (ID, CAR_TYPE, RED_CAR, CAR_AGE) VALUES ('$ID', '$CAR_TYPE', '$RED_CAR', '$CAR_AGE')";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                $successMessage = "New record created successfully";
                // Clear the form values
                $ID = $CAR_TYPE = $RED_CAR = $CAR_AGE = "";
            } else {
                $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close database connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Create Car Profile</title>
</head>

<body>
    <div class="container my-5">
        <h2>New Car</h2>

        <?php
        if (!empty($errorMessage)) {
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>' . $errorMessage . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Car ID</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="ID" value="<?php echo $ID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Car Type</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="car_type" value="<?php echo $CAR_TYPE; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Red Car</label>
                <div class="col-sm-9">
                    <select class="form-select" name="red_car">
                        <option value="Yes" <?php if ($RED_CAR == "Yes")
                            echo "selected"; ?>>Yes</option>
                        <option value="No" <?php if ($RED_CAR == "No")
                            echo "selected"; ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Car Age</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="car_age" value="<?php echo $CAR_AGE; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo '
                <div class="row mb-3">
                    <div class="offset-sm
                    -3 col-sm-3 col-form-label">
                    <div class="alert alert-success alert-dismissable fade show" role="alert">
                        <strong>' . $successMessage . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>     
                    </div>
                </div>
            </div>';
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="cars.php" role="button">Back to Cars</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
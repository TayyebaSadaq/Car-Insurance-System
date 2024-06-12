<?php
$servername = 'localhost';
$db_name = 'car_insurance';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ID = "";
$CAR_TYPE = "";
$RED_CAR = "";
$CAR_AGE = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["id"])) {
        header("Location: cars.php");
        exit;
    }
    $ID = $_GET["id"];

    // Read data of the car
    $sql = "SELECT * FROM cardetails WHERE ID = '$ID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: cars.php");
        exit;
    }

    $CAR_TYPE = $row["CAR_TYPE"];
    $RED_CAR = $row["RED_CAR"];
    $CAR_AGE = $row["CAR_AGE"];
} else {
    // POST method: Update data of the car
    $ID = $_POST["ID"];
    $CAR_TYPE = $_POST["carType"];
    $RED_CAR = $_POST["redCar"];
    $CAR_AGE = $_POST["carAge"];

    do {
        if (
            !isset($ID) ||
            !isset($CAR_TYPE) ||
            !isset($RED_CAR) ||
            !isset($CAR_AGE)
        ) {
            $errorMessage = "Please fill out all required fields";
            break;
        }

        $sql = "UPDATE cardetails SET CAR_TYPE='$CAR_TYPE', RED_CAR='$RED_CAR', CAR_AGE='$CAR_AGE' WHERE ID='$ID'";
        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Error updating record: " . $conn->error;
            break;
        }

        $successMessage = "Record updated successfully";

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Car Details</title>
</head>

<body>
    <div class="container my-5">
        <h2>Update Car Details</h2>

        <?php
        if (!empty($errorMessage)) {
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>' . $errorMessage . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

        if (!empty($successMessage)) {
            echo '
            <div class="alert alert-success" role="alert">
                <strong>' . $successMessage . '</strong>
            </div>';
        }
        ?>

        <form method="post">
            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Car ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="ID" value="<?php echo $ID; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Car Type</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="carType" value="<?php echo $CAR_TYPE; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Red Car</label>
                <div class="col-sm-9">
                    <select class="form-select" name="redCar">
                        <option value="Yes" <?php if ($RED_CAR == "Yes") echo "selected"; ?>>Yes</option>
                        <option value="No" <?php if ($RED_CAR == "No") echo "selected"; ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Car Age</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="carAge" value="<?php echo $CAR_AGE; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="cars.php" role="button">Back to Cars</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

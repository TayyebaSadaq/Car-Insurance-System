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
$KIDSDRIV = "";
$AGE = "";
$INCOME = "";
$MSTATUS = "";
$GENDER = "";
$EDUCATION = "";
$OCCUPATION = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["id"])) {
        header("Location: driver.php");
        exit;
    }
    $ID = $_GET["id"];

    // Read data of the driver
    $sql = "SELECT * FROM driverprofile WHERE ID = '$ID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: driver.php");
        exit;
    }

    $KIDSDRIV = $row["KIDSDRIV"];
    $AGE = $row["AGE"];
    $INCOME = $row["INCOME"];
    $MSTATUS = $row["MSTATUS"];
    $GENDER = $row["GENDER"];
    $EDUCATION = $row["EDUCATION"];
    $OCCUPATION = $row["OCCUPATION"];
} else {
    // POST method: Update data of the driver
    $ID = $_POST["ID"];
    $KIDSDRIV = $_POST["KIDSDRIV"];
    $AGE = $_POST["AGE"];
    $INCOME = $_POST["INCOME"];
    $MSTATUS = $_POST["MSTATUS"];
    $GENDER = $_POST["GENDER"];
    $EDUCATION = $_POST["EDUCATION"];
    $OCCUPATION = $_POST["OCCUPATION"];

    do {
        if (
            !isset($ID) ||
            (!isset($KIDSDRIV) && $KIDSDRIV !== "0") ||
            (!isset($AGE) && $AGE !== "0") ||
            (!isset($INCOME) && $INCOME !== "0") ||
            !isset($MSTATUS) ||
            !isset($GENDER) ||
            !isset($OCCUPATION)
        ) {
            $errorMessage = "Please fill out all required fields";
            break;
        }

        $sql = "UPDATE driverprofile SET KIDSDRIV='$KIDSDRIV', AGE='$AGE', INCOME='$INCOME', MSTATUS='$MSTATUS', GENDER='$GENDER', EDUCATION='$EDUCATION', OCCUPATION='$OCCUPATION' WHERE ID='$ID'";
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
    <title>Update Driver Profile</title>
</head>

<body>
    <div class="container my-5">
        <h2>Update Driver Profile</h2>

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
                <label class="col-sm-3 col-form-label">Driver ID</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="ID" value="<?php echo $ID; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Number of Kids</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="KIDSDRIV" value="<?php echo $KIDSDRIV; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="AGE" value="<?php echo $AGE; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Income</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="INCOME" value="<?php echo $INCOME; ?>">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Marital Status</label>
                <div class="col-sm-9">
                    <select class="form-select" name="MSTATUS">
                        <option value="Yes" <?php if ($MSTATUS == "Yes") echo "selected"; ?>>Yes</option>
                        <option value="No" <?php if ($MSTATUS == "No") echo "selected"; ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                    <select class="form-select" name="GENDER">
                        <option value="M" <?php if ($GENDER == "M") echo "selected"; ?>>Male</option>
                        <option value="F" <?php if ($GENDER == "F") echo "selected"; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Education</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="EDUCATION" value="<?php echo $EDUCATION; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Occupation</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="OCCUPATION" value="<?php echo $OCCUPATION; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="driver.php" role="button">Back to Drivers</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

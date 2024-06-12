<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST["ID"];
    $KIDSDRIV = $_POST["kidsdriv"];
    $AGE = $_POST["age"];
    $INCOME = $_POST["income"];
    $MSTATUS = $_POST["mstatus"];
    $GENDER = $_POST["gender"];
    $EDUCATION = $_POST["education"];
    $OCCUPATION = $_POST["occupation"];

    // Validate input data
    if (
        !isset($ID) ||
        (!isset($KIDSDRIV) && $KIDSDRIV !== "0") ||
        (!isset($AGE) && $AGE !== "0") ||
        (!isset($INCOME) && $INCOME !== "0") ||
        !isset($MSTATUS) ||
        !isset($GENDER) ||
        !isset($EDUCATION) ||
        !isset($OCCUPATION)
    ) {
        $errorMessage = "Please fill out all required fields";
    } else {

        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "car_insurance");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the Driver ID already exists
        $checkSql = "SELECT ID FROM driverprofile WHERE ID = '$ID'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            $errorMessage = "Driver ID already exists. Please use a different ID.";
        } else {
            // Prepare SQL statement
            $sql = "INSERT INTO driverprofile (ID, KIDSDRIV, AGE, INCOME, MSTATUS, GENDER, EDUCATION, OCCUPATION) VALUES ('$ID', '$KIDSDRIV', '$AGE', '$INCOME', '$MSTATUS', '$GENDER', '$EDUCATION', '$OCCUPATION')";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                $successMessage = "New record created successfully";
                // Clear the form values
                $ID = $KIDSDRIV = $AGE = $INCOME = $MSTATUS = $GENDER = $EDUCATION = $OCCUPATION = "";
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
    <title>Create Profile</title>
</head>

<body>
    <div class="container my-5">
        <h2>New Driver</h2>

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
                <label class="col-sm-3 col-form-label">Driver ID</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="ID" value="<?php echo $ID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Number of Kids</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="kidsdriv" value="<?php echo $KIDSDRIV; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="age" value="<?php echo $AGE; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Income</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="income" value="<?php echo $INCOME; ?>">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Marital Status</label>
                <div class="col-sm-9">
                    <select class="form-select" name="mstatus">
                        <option value="Yes" <?php if ($MSTATUS == "Yes") echo "selected"; ?>>Yes</option>
                        <option value="No" <?php if ($MSTATUS == "No") echo "selected"; ?>>No</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                    <select class="form-select" name="gender">
                        <option value="M" <?php if ($GENDER == "M") echo "selected"; ?>>Male</option>
                        <option value="F" <?php if ($GENDER == "F") echo "selected"; ?>>Female</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Education</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="education" value="<?php echo $EDUCATION; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Occupation</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="occupation" value="<?php echo $OCCUPATION; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo '
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-6">
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
                    <a class="btn btn-outline-primary" href="driver.php" role="button">Back to Drivers</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

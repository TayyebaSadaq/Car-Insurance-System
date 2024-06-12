<?php
$ID = "";
$OLDCLAIM = "";
$CLM_FREQ = "";
$CLM_AMT = "";
$CLAIM_FLAG = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST["ID"];
    $OLDCLAIM = $_POST["oldclaim"];
    $CLM_FREQ = $_POST["clm_freq"];
    $CLM_AMT = $_POST["clm_amt"];
    $CLAIM_FLAG = $_POST["claim_flag"];

    // Validate input data
    if (
        !isset($ID) ||
        !isset($OLDCLAIM) ||
        !isset($CLM_FREQ) ||
        !isset($CLM_AMT) ||
        !isset($CLAIM_FLAG)
    ) {
        $errorMessage = "Please fill out all required fields";
    } else {
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "car_insurance");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the Claim ID already exists
        $checkSql = "SELECT ID FROM claimdetails WHERE ID = '$ID'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            $errorMessage = "Claim ID already exists. Please use a different ID.";
        } else {
            // Prepare SQL statement
            $sql = "INSERT INTO claimdetails (ID, OLDCLAIM, CLM_FREQ, CLM_AMT, CLAIM_FLAG) VALUES ('$ID', '$OLDCLAIM', '$CLM_FREQ', '$CLM_AMT', '$CLAIM_FLAG')";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                $successMessage = "New record created successfully";
                // Clear the form values
                $ID = $OLDCLAIM = $CLM_FREQ = $CLM_AMT = $CLAIM_FLAG = "";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Create Claim</title>
</head>

<body>
    <div class="container my-5">
        <h2>New Claim</h2>

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
                <label class="col-sm-3 col-form-label">Claim ID</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="ID" value="<?php echo $ID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Old Claim</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="oldclaim" value="<?php echo $OLDCLAIM; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim Frequency</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="clm_freq" value="<?php echo $CLM_FREQ; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim Amount</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="clm_amt" value="<?php echo $CLM_AMT; ?>">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim Flag</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="claim_flag" value="<?php echo $CLAIM_FLAG; ?>">
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
                    <a class="btn btn-outline-primary" href="claims.php" role="button">Back to Claims</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

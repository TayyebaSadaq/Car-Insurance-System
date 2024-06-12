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

$claimID = "";
$oldClaim = "";
$claimFrequency = "";
$claimAmount = "";
$claimFlag = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["id"])) {
        header("Location: claims.php");
        exit;
    }
    $claimID = $_GET["id"];

    // Read data of the claim
    $sql = "SELECT * FROM claimdetails WHERE ID = '$claimID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: claims.php");
        exit;
    }

    $oldClaim = $row["OLDCLAIM"];
    $claimFrequency = $row["CLM_FREQ"];
    $claimAmount = $row["CLM_AMT"];
    $claimFlag = $row["CLAIM_FLAG"];
} else {
    // POST method: Update data of the claim
    $claimID = $_POST["ID"];
    $oldClaim = $_POST["oldClaim"];
    $claimFrequency = $_POST["claimFrequency"];
    $claimAmount = $_POST["claimAmount"];
    $claimFlag = $_POST["claimFlag"];

    do {
        if (
            !isset($claimID) ||
            !isset($oldClaim) ||
            !isset($claimFrequency) ||
            !isset($claimAmount) ||
            !isset($claimFlag)
        ) {
            $errorMessage = "Please fill out all required fields";
            break;
        }

        $sql = "UPDATE claimdetails SET OLDCLAIM='$oldClaim', CLM_FREQ='$claimFrequency', CLM_AMT='$claimAmount', CLAIM_FLAG='$claimFlag' WHERE ID='$claimID'";
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
    <title>Update Claim</title>
</head>

<body>
    <div class="container my-5">
        <h2>Update Claim</h2>

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
            <input type="hidden" name="ID" value="<?php echo $claimID; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="ID" value="<?php echo $claimID; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Old Claim</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="oldClaim" value="<?php echo $oldClaim; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim Frequency</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="claimFrequency" value="<?php echo $claimFrequency; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim Amount</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="claimAmount" value="<?php echo $claimAmount; ?>">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Claim Flag</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="claimFlag" value="<?php echo $claimFlag; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="claims.php" role="button">Back to Claims</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

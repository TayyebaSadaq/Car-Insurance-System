<?php
if (isset($_GET["id"])) {
    $ID = $_GET["id"];

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

    $sql = "DELETE FROM claimdetails WHERE ID = $ID";
    if ($conn->query($sql) === TRUE) {
        $message = "Claim deleted successfully";
    } else {
        $message = "Error deleting claim: " . $conn->error;
    }

    $conn->close();
}

header("Location: claims.php?message=" . urlencode($message));
exit;
?>

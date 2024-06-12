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

    $sql = "DELETE FROM cardetails WHERE ID = $ID";
    if ($conn->query($sql) === TRUE) {
        $message = "Car deleted successfully";
    } else {
        $message = "Error deleting car: " . $conn->error;
    }

    $conn->close();
}

header("Location: cars.php?message=" . urlencode($message));
exit;
?>

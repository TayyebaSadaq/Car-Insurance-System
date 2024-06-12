<?php
if (isset($_GET["id"])) {
    $ID = $_GET["id"];

    $servername = 'localhost';
    $db_name = 'car_insurance';
    $username = 'root';
    $password = '';

    // Create connection    
    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM driverprofile WHERE ID = $ID";

    if ($conn->query($sql) === TRUE) {
        $message = "Item deleted successfully";
    } else {
        $message = "Error deleting item: " . $conn->error;
    }

    $conn->close();
}

header("Location: driver.php?message=" . urlencode($message));
exit;
?>

<?php

$servername = "127.0.0.1";
$username = "root";
$password = "kucinglucu";
$dbname = "sensor";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM result ORDER BY created_at";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = [];
    $last = [];

    /* Get all data from database */
    while ($row = $result->fetch_assoc()) {
        array_push($data, $row);
        $last = $row;
    }
    if (isset($_GET['last'])) {
        var_dump($last);
    } else {
        var_dump($data);
    }
} else {
    echo "0 results";
}
$conn->close();
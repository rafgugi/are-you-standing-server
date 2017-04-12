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

$x = $_GET['x'];
$y = $_GET['y'];
$z = $_GET['z'];

// $sql = "INSERT INTO data (x, y, z, nama) VALUES ($x, $y, $z, 'Duduk')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
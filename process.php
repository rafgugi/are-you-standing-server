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

$sql = "SELECT * FROM data";
$result = $conn->query($sql);


function euclidean_sort($a, $b) {
    return $a['euclidean'] > $b['euclidean'];
}

if ($result->num_rows > 0) {
    $vote = [];
    $data = [];
    $globalVote = [];

    /* Get all data from database */
    while ($row = $result->fetch_assoc()) {
        $vote[$row['nama']] = 0;
        $globalVote[$row['nama']] = 0;
        array_push($data, $row);
    }
    $result = [];

    /* Iterate through datatests */
    $xyzs = explode(':', $_GET['result']);
    foreach ($xyzs as $xyz) {
        $xyz = explode('_', $xyz);
        $x = $xyz[0];
        $y = $xyz[1];
        $z = $xyz[2];

        foreach ($data as $row) {
            $dot = [
                'euclidean' => sqrt(pow($x - $row['x'], 2) + pow($y - $row['y'], 2) + pow($z - $row['z'], 2)),
                'state' => $row['nama'],
            ];
            array_push($result, $dot);
        }
        usort($result, 'euclidean_sort');

        /* Vote */
        for ($i=0; $i < 5; $i++) { 
            $vote[$result[$i]['state']]++;
        }

        /* Get highest voting state */
        arsort($vote);
        $state = '';
        foreach ($vote as $key => $value) {
            $state = $key;
            break;
        }
        $globalVote[$state]++;
    }

    arsort($globalVote);
    $persen = $globalVote['Berdiri'] / ($globalVote['Berdiri'] + $globalVote['Duduk']);
    if ($persen < 0.7 && $persen > 0.3) {
        $state = 'Jogging';
    } else {
        foreach ($globalVote as $key => $value) {
            $state = $key;
            break;
        }
    }

    /* Insert into result table */
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO result (state, created_at) VALUES ('$state', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    //*/

} else {
    echo "0 results";
}
$conn->close();
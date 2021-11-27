<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skripsi";

// batasan by user input [dummy]
$input_ph = 9;
$input_ppm = 1000;



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sensor_ph = $_GET["sensor_ph"];
$sensor_ppm = $_GET["sensor_ppm"];
$sensor_level_air = $_GET["sensor_level_air"];
$sql = "INSERT INTO arduino_data
VALUES (null, '.$sensor_ph.' , '.$sensor_ppm.', '.$sensor_level_air.')";


if ($conn->query($sql) === TRUE) {
  if ($sensor_ph < $input_ph) {

    echo "tambahkan cairah ph up";
  } else {
    echo "tambahkan cairan ph down";
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skripsi";

// batasan by user input [dummy]
$input_ph = 9;
$input_ppm = 1000;

// fetch from batasan table

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// get date from time zone
date_default_timezone_set('Asia/Jakarta');
$date = date("Y/m/d H:i:s");

$device_id = $_GET["device_id"];
$sensor_ph = $_GET["sensor_ph"];
$sensor_ppm = $_GET["sensor_ppm"];
$sensor_level_air = $_GET["sensor_level_air"];

// Query insert to datbase
$sql = "INSERT INTO arduino_data
VALUES ('$device_id', '$sensor_ph' , '$sensor_ppm', '$sensor_level_air','$date')";

// Response
if ($conn->query($sql) === TRUE) {
    // membandingkan data sensor dan data yang diinput user
    // for actuator
  if ($sensor_ph < $input_ph) {

    echo "tambahkan cairah ph up";
  } else {
    echo "tambahkan cairan ph down";
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

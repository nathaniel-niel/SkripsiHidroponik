<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skripsi";


// response data
$response = "";
// fetch from batasan table

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// batasan by user input
$device_id = $_GET["device_id"];
$input_ph = $_GET["batasan_ph"];
$input_ppm = $_GET["batasan_ppm"];
$sql_input = "SELECT * FROM batasan ORDER BY date DESC LIMIT 1";
$result = mysqli_query($conn, $sql_input);

while ($row = mysqli_fetch_assoc($result)) :
  echo "<script>console.log('PHP: " . $row['device_id'] . "');</script>";
  echo "<script>console.log('PHP: " . $row['batasan_ph'] . "');</script>";
  echo "<script>console.log('PHP: " . $row['batasan_ppm'] . "');</script>";
endwhile;

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

  if ($sensor_ph > $input_ph){
    $response .= "add pH down";
  }
  elseif($sensor_ph < $input_ph){
    $response .= "add pH up";
  }

  if ($sensor_ppm < $input_ppm){
    $response .= "add ppm";
  }
  echo $response;
  $response = "";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

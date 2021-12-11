<?php
require '../../global.php';

// get date from time zone
date_default_timezone_set('Asia/Jakarta');
$date = date("Y/m/d H:i:s");

$device_id = $_GET["device_id"];
$sensor_ph = $_GET["sensor_ph"];
$sensor_ppm = $_GET["sensor_ppm"];
$sensor_level_air = $_GET["sensor_level_air"];
$response = "";

// Query insert to datbase
$sql = "INSERT INTO arduino_data
VALUES ('$device_id', '$sensor_ph' , '$sensor_ppm', '$sensor_level_air','$date')";

// fetch batasan for comapring value between user input and arduino sensor data
$sql_input = "SELECT * FROM batasan WHERE device_id = '$device_id'  ORDER BY date DESC LIMIT 1";
$result = mysqli_query($conn, $sql_input);

while ($row = mysqli_fetch_assoc($result)) :
    
    $input_ph = $row['batasan_ph'];
    $input_ppm = $row['batasan_ppm'];

endwhile;

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

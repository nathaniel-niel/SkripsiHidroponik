<?php
 require '../../../global.php';

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
  $input_banyak_air = $row['banyak_air'];

endwhile;

// Response
if ($conn->query($sql) === TRUE) {
  // membandingkan data sensor dan data yang diinput user
  // for actuator
  /*
  Dictionary
  pH up -> pu
  pH down -> pd
  ppm -> pm
  writing format : 
  */
  $batas_bawah = $input_ph * 95 / 100;
  $batas_atas = $input_ph * 105 / 100;
  $response = "$input_banyak_air*";
  if ($sensor_ph > $batas_atas) {
    $diff = $sensor_ph - $input_ph;
    $response .= "pd_$diff ";
  } elseif ($sensor_ph < $batas_bawah) {
    $diff = $input_ph - $sensor_ph;
    $response .= "pu_$diff ";
  }
  if ($sensor_ppm < $input_ppm) {
    $diff = $input_ppm - $sensor_ppm;
    $response .= "pm_$diff ";
  }
  echo $response;
  $response = "";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

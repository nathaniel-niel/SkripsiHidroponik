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

$batasan_ph = $_GET["batasan_ph"];
$batasan_ppm = $_GET["batasan_ppm"];
$batasan_air = $_GET["batasan_air"];
$sql = "INSERT INTO arduino_input 
VALUES (null, '.$batasan_ph.' , '.$batasan_ppm.', '.$batasan_air.')";


if ($conn->query($sql) === TRUE  )  {
  if ( $batasan_ph < $input_ph) {
     
      echo "tambahkan cairah ph up";
    }
    else{
      echo "tambahkan cairan ph down";
    }
 
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>

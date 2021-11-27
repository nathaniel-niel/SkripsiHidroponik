<?php
require '../global.php';

function savedData($data)
{
    global $conn;
    // form
    $batasan_ph = $data['batasan_ph'];
    $batasan_ppm = $data['batasan_ppm'];

    //set date
    date_default_timezone_set('Asia/Jakarta');
    $date = date("d/m/Y H:i:s");

    $sql = "INSERT INTO batasan VALUES ('', '$batasan_ph' , '$batasan_ppm', '$date')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function savedNewDevice($data)
{
    global $conn;
    // form
    $device_id = $data['device_id'];
    $device_name = $data['device_name'];

    $sql = "INSERT INTO device_collection VALUES ('', '$device_id' , '$device_name')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

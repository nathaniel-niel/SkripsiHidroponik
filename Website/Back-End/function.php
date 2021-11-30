<?php
require '../global.php';

function savedBatasan($data)
{
    global $conn;
    // form
    $device_id = $data['dev'];
    $batasan_ph = $data['batasan_ph'];
    $batasan_ppm = $data['batasan_ppm'];

    echo "<script>console.log('Debug Objects: " . $device_id . "' );</script>";

    //set date
    date_default_timezone_set('Asia/Jakarta');
    $date = date("d/m/Y H:i:s");

    $sql = "INSERT INTO batasan VALUES ('$device_id', '$batasan_ph' , '$batasan_ppm', '$date')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function savedNewDevice($data)
{
    global $conn;
    // form
    $device_id = $data['device_id'];
    $device_name = $data['device_name'];

    //set date
    date_default_timezone_set('Asia/Jakarta');
    $date = date("d/m/Y H:i:s");

    if (mysqli_num_rows($device_name) > 0) {
        $name_error = "Sorry... device name already taken";
    } else {
        $sql = "INSERT INTO device_collection VALUES ('$device_id' , '$device_name', '$date')";

        mysqli_query($conn, $sql);
        return mysqli_affected_rows($conn);
    }
}

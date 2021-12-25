<?php
require '../../global.php';

function savedBatasan($data)
{
    global $conn;
    // form
    $device_id = $data['dev'];
    $batasan_ph = $data['batasan_ph'];
    $batasan_ppm = $data['batasan_ppm'];
    $banyak_air = $data['banyak_air'];

    //set date
    date_default_timezone_set('Asia/Jakarta');
    $date = date("Y/m/d H:i:s");

    $sql = "INSERT INTO batasan VALUES ('$device_id', '$batasan_ph' , '$batasan_ppm', '$banyak_air' ,'$date')";

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
    $date = date("Y/m/d H:i:s");

    $sql = "INSERT INTO device_collection VALUES ('$device_id' , '$device_name','$date')";

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function deleteDevice($data)
{
    global $conn;

    $device_id = $_GET['device_id'];

    $sql1 = "DELETE FROM arduino_data WHERE device_id = '$device_id'";
    $sql2 = "DELETE FROM batasan WHERE device_id = '$device_id'";
    $sql3 = "DELETE FROM device_collection WHERE device_id = '$device_id'";

    mysqli_query($conn, $sql1);
    mysqli_query($conn, $sql2);
    mysqli_query($conn, $sql3);
    return mysqli_affected_rows($conn);
}

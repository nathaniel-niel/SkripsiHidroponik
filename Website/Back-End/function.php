<?php
require '../global.php';

function savedBatasan($data)
{
    global $conn;
    // form
<<<<<<< HEAD
    $batasan_ph = $data['batasan_ph'];
    $batasan_ppm = $data['batasan_ppm'];
=======
    $device_id = $data['dev'];
    $batasan_ph = $data['batasan_ph'];
    $batasan_ppm = $data['batasan_ppm'];

    echo "<script>console.log('Debug Objects: " . $device_id . "' );</script>";
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2

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

<<<<<<< HEAD
    $sql = "INSERT INTO device_collection VALUES ('', '$device_id' , '$device_name')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
=======
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
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2
}

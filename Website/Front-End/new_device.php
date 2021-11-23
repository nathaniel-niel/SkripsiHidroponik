<?php
require '../Back-End/function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
    <link rel="stylesheet" href="style_datalog.css" />

    <title>Hello, world!</title>
</head>

<!-- BODY -->

<body>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- bar navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.html">JNC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="datalog.php">Data Log</a>
                <a class="nav-link active" href="new_device.php">New Device</a>
            </div>
        </div>
    </nav>

    <!-- add new arduino -->
    <form action="" method="post">
        <table>
            <tr>
                <td><label for="device_id" class="h5">DEVICE ID </label></td>
                <td>:</td>
                <td><input type="text" id="device_id" name="device_id" value="" required></td>
            </tr>
            <br>
            <tr>
                <td><label for="device_name" class="h5">DEVICE NAME </label></td>
                <td>:</td>
                <td> <input type="text" id="device_name" name="device_name" value="" required /></td>
            </tr>
            <tr>
                <td><button type="submitNewDevice" name="submitNewDevice">Save</button></td>
            </tr>
        </table>
    </form>

</html>

<?php
if (isset($_POST["submitNewDevice"])) {
    if (savedNewDevice($_POST) > 0) {
        echo "
      <script>
      alert('Device Berhasil Ditambahkan!');
      </script>
      ";
    } else {
        echo "
      <script>
      alert('Device Gagal Ditambahkan!');
      </script>
      ";
    }
}
?>
<?php
require '../Back-End/function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
<<<<<<< HEAD
  <link rel="stylesheet" href="style_devicecollection.css" />
=======
  <link rel="stylesheet" href="style/style_deviceCollection.css" />
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2

  <title>Hello Bang!</title>

</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

  <!-- bar navigasi -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
<<<<<<< HEAD
    <a class="navbar-brand" href="index.html">JNC</a>
=======
    <a class="navbar-brand" href="deviceCollection.php">JNC</a>
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
<<<<<<< HEAD
        <a class="nav-link" href="new_device.php">Home <span class="sr-only">(current)</span></a>
        <a class="nav-link" href="dashboard.php">Dashboard</a>
        <a class="nav-link" href="datalog.php">Data Log</a>
        <a class="nav-link active" href="devicecollection.php">Device Collection</a>
=======
        <a class="nav-link active" href="deviceCollection.php">Device Collection</a>
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2
      </div>
    </div>
  </nav>

  <!-- Layout Collection of Devices -->
  <div class="container" id="main-layout">
    <!-- Kolom Title & Button Add New Device -->
    <div class="row align-items-start">
      <!-- Title -->
      <div class="col">
        <h2>Collection of Devices</h2>
      </div>
      <!-- Button Add New Device -->
      <div class="col">
        <button type="button" class="btn btn-primary" id="button-new-device" data-toggle="modal" data-target="#exampleModalCenter" data-whatever="@getbootstrap">
          Add New Device
        </button>
      </div>
    </div>

    <!-- Popup/Model Add New Device -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Title -->
            <h5 class="modal-title" id="exampleModalLabel">Add New Device</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form -->
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
          </div>

        </div>
      </div>
    </div>

    <?php
    // Attempt select query execution
<<<<<<< HEAD
    $sql = "SELECT device_name FROM device_collection";
=======
    $sql = "SELECT * FROM device_collection ORDER BY date";
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2
    $result = mysqli_query($conn, $sql);
    ?>

    <!-- Jumbotron Devices -->
    <?php
    while ($row = mysqli_fetch_assoc($result)) : ?>

<<<<<<< HEAD
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <th id="device-name-title"><?= $row['device_name']; ?></th>
        </div>
      </div>
=======
      <a href="deviceDetail.php?device_id=<?= $row['device_id']; ?>&device_name=<?= $row['device_name']; ?>">
        <div class="container">
          <div id="device-name-title"><?= $row['device_name']; ?></div>
        </div>
      </a>
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2

    <?php
    endwhile;
    ?>

<<<<<<< HEAD








=======
>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2
    <!-- Notifikasi -->
    <h2>Notification</h2>

    <table class="table table-bordered table-striped">
      <tr>
        <th id="header">Device Name</th>
        <th id="header">Notification</th>
        <th id="header">Date</th>
      </tr>
      <tr>
        <td id="content">Device A</td>
        <td id="content">
          Ketinggian air sudah rendah, mohon isi kembali wadah air
        </td>
        <td id="content">19/10/2021 10.23</td>
      </tr>
      <tr>
        <td id="content">Device B</td>
        <td id="content">
          Ketinggian air sudah rendah, mohon isi kembali wadah air
        </td>
        <td id="content">19/10/2021 10.23</td>
      </tr>
      <tr>
        <td id="content">Device B</td>
        <td id="content">
          Ketinggian air sudah rendah, mohon isi kembali wadah air
        </td>
        <td id="content">19/10/2021 10.23</td>
      </tr>
      <tr>
        <td id="content">Device A</td>
        <td id="content">
          Ketinggian air sudah rendah, mohon isi kembali wadah air
        </td>
        <td id="content">19/10/2021 10.23</td>
      </tr>
    </table>

  </div>
</body>

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
<?php
require '../global.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
  <link rel="stylesheet" href="style/style_datalog.css" />

  <title>Hello, world!</title>
</head>

<!-- BODY -->

<body>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

  <!-- bar navigasi -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="devicecollection.php">JNC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
<<<<<<< HEAD
        <a class="nav-link active" href="datalog.php">Data Log</a>
        <a class="nav-link" href="devicecollection.php">Device Collection</a>
=======
        <a class="nav-link" href="devicecollection.php">Device Collection</a>

>>>>>>> a4fb85ee09a648d0ccc70b1695dec007ad9af2f2
      </div>
    </div>
  </nav>

  <!-- Main Layout -->
  <div class="p-3 border bg-light">
    LOG INFORMASI

    <?php
    $index = 1;
    // Attempt select query execution
    $sql = "SELECT * FROM arduino_data";
    $result = mysqli_query($conn, $sql);
    ?>
    <table class="table table-bordered table-striped">
      <tr>
        <th id="header">No</th>
        <th id="header">pH</th>
        <th id="header">PPM</th>
        <th id="header">Water Level</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <td><?= $index; ?></td>
          <td><?= $row['sensor_ph']; ?></td>
          <td><?= $row['sensor_ppm']; ?></td>
          <td><?= $row['sensor_level_air']; ?></td>
        </tr>
      <?php $index++;
      endwhile; ?>
    </table>
  </div>
</body>

</html>
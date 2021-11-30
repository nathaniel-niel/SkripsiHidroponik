<?php
require '../Back-End/function.php';

if (isset($_POST["submitBatasan"])) {
  if (savedBatasan($_POST) > 0) {
    echo "
    <script>
    alert('Berhasil Tersimpan!');
    </script>
    ";
  } else {
    echo "
    <script>
    alert('Gagal Tersimpan!');
    </script>
    ";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="style/style_deviceDetail.css" />

  <title>DEVICE DETAIL</title>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

  <!-- bar navigasi -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="deviceCollection.php">JNC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="deviceCollection.php">Device Collection</a>
        <a class="nav-link active" href="deviceDetail.php">Detail Device</a>
      </div>
    </div>
  </nav>

  <!-- GET Device ID From url -->
  <?php
  $dev_id = $_GET["device_id"];
  ?>

  <!-- Input Form & Informasi Layout -->
  <div class="container" id="main-layout">
    <!-- Title -->
    <h1 id="judul"><?= $_GET["device_name"]; ?></h1>

    <!-- Layout Input & Limit -->
    <div class="row" style="margin-top: 40px;">
      <div class="col-sm-8">
        <!-- Kolom Input Form -->
        <div class="jumbotron jumbotron-fluid" style="height: 300px;">
          <div class="container">
            <h2>Input Form</h2>

            <!-- Input Form -->
            <table id="">
              <form action="" method="post">
                <td><input type="hidden" step=".01" id="dev" name="dev" value="<?= $dev_id ?>" required></td>

                <!-- Batasan -->
                <tr>
                  <td id="col-label"><label for="batasan_ph" class="h5" style="margin-left: 30px; font-size: 25px">pH Limit</label></td>
                  <td id="col-input"><input type="number" step=".01" id="batasan_ph" name="batasan_ph" value="" required style="border-radius: 10px; height: 40px;"></td>
                </tr>
                <tr>
                  <td id=" col-label"><label for="batasan_ppm" class="h5" style="margin-left: 30px; font-size: 25px">PPM Limit</label></td>
                  <td id="col-input"><input type="number" id="batasan_ppm" name="batasan_ppm" value="" required style="border-radius: 10px; height: 40px;" /></td>
                </tr>
                <tr class="bottomright">
                  <!-- Button Submit -->
                  <td><button type="submit" name="submitBatasan" id="save-btn">Save</button></td>
                </tr>
              </form>
            </table>
          </div>
        </div>
      </div>

      <!-- Kolom Limit -->
      <div class="col-sm-4">
        <div class="jumbotron jumbotron-fluid" style="height: 300px;">
          <div class="container">

            <!-- pH limit -->
            <h3 style="text-align: center;">pH Limit</h3>
            <?php
            $sql = "SELECT batasan_ph FROM batasan WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            ?>

            <?php $row = mysqli_fetch_assoc($result)  ?>
            <?php if (!$row) : ?>
              <div id='limit-value'>
                <td> 0 </td>
              </div>
            <?php else : ?>
              <div id="limit-value">
                <td><?= $row['batasan_ph']; ?></td>
              </div>
            <?php endif; ?>

            <!-- PPM Limit -->
            <h3 style="text-align: center;">PPM Limit</h3>
            <?php
            $sql = "SELECT batasan_ppm FROM batasan WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            ?>

            <?php $row = mysqli_fetch_assoc($result) ?>
            <?php if (!$row) : ?>
              <div id='limit-value'>
                <td> 0 </td>
              </div>
            <?php else : ?>
              <div id="limit-value">
                <td><?= $row['batasan_ppm']; ?></td>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row align-items-start">
      <div class="col">
        <?php
        // Attempt select query execution
        $sql = "SELECT sensor_ph FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>
        <!-- Kolom Data pH Rate -->
        <div class="jumbotron jumbotron-fluid">
          <h3>pH Rate</h3>
          <?php $row = mysqli_fetch_assoc($result)  ?>
          <?php if (!$row) :
            echo "<div id='info-value'> 0 </div>";
          else : ?>
            <div id="info-value">
              <td><?= $row['sensor_ph']; ?></td>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col">
        <?php
        // Attempt select query execution
        $sql = "SELECT sensor_ppm FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>
        <!-- Kolom Data PPM Rate -->
        <div class="jumbotron jumbotron-fluid">
          <h3>PPM Rate</h3>
          <?php $row = mysqli_fetch_assoc($result) ?>
          <?php if (!$row) :
            echo "<div id='info-value'> 0 </div>";
          else : ?>
            <div id="info-value">
              <td><?= $row['sensor_ppm']; ?></td>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col">
        <?php
        // Attempt select query execution
        $sql = "SELECT sensor_level_air FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>
        <!-- Kolom Data Water Level -->
        <div class="jumbotron jumbotron-fluid">
          <h3>Water Level</h3>
          <?php $row = mysqli_fetch_assoc($result) ?>
          <?php if (!$row) :
            echo "<div id='info-value'> EMPTY </div>";
          else : ?>
            <?php if ($row['sensor_level_air'] == "HIGH") { ?>
              <div id="info-value" style="color: green;">
                <td><?= $row['sensor_level_air']; ?></td>
              </div>
            <?php } else if ($row['sensor_level_air'] == "MED") { ?>
              <div id="info-value" style="color: orange;">
                <td><?= $row['sensor_level_air']; ?></td>
              </div>
            <?php } else if ($row['sensor_level_air'] == "LOW") { ?>
              <div id="info-value" style="color: red;">
                <td><?= $row['sensor_level_air']; ?></td>
              </div>
            <?php } else if ($row['sensor_level_air'] == "EMPTY") { ?>
              <div id="info-value" style="color: black;">
                <td><?= $row['sensor_level_air']; ?></td>
              </div>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Layout Data Log -->
    <div class="jumbotron jumbotron-fluid">
      <h3>Data Log</h3>

      <?php
      $index = 1;
      // Attempt select query execution
      $sql = "SELECT * FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 5";
      $result = mysqli_query($conn, $sql);
      ?>

      <table class="table table-bordered table-striped">
        <tr>
          <th id="t-head">No</th>
          <th id="t-head">Date</th>
          <th id="t-head">pH</th>
          <th id="t-head">PPM</th>
          <th id="t-head">Water Level</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td><?= $index; ?></td>
            <td><?= $row['date']; ?></td>
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
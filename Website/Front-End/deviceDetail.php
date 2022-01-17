<?php
require '../Back-End/function.php';

if (isset($_POST["submitBatasan"])) :
  if (savedBatasan($_POST) > 0) :
    echo "
    <script>
    alert('BATASAN BERHASIL DISIMPAN!');
    </script>
    ";
  else :
    echo "
    <script>
    alert('BATASAN GAGAL DISIMPAN!');
    </script>
    ";
  endif;
endif;

if (isset($_POST["submitDeleteDevice"])) :
  if (deleteDevice($_POST) > 0) :
    echo "
    <script>
    alert('DEVICE BERHASIL DIHAPUS!');
    document.location.href = 'index.php';
    </script>
    ";
  else :
    echo "
    <script>
    alert('DEVICE GAGAL DIHAPUS!');
    </script>
    ";
  endif;
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
  <link rel="stylesheet" href="style/style_deviceDetail.css" />

  <title>DEVICE DETAILS</title>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

  <!-- NAVIGATION BAR -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="index.php">JNC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="index.php">Device Collection</a>
        <a class="nav-link active" href="deviceDetail.php">Device Details</a>
      </div>
    </div>
  </nav>

  <!-- GET DEVICE ID FROM URL -->
  <?php
  $dev_id = $_GET["device_id"];
  ?>


  <!-- INPUT FORM & INFORMASI LAYOUT -->
  <div class="container" id="main-layout">
    <!-- KOLOM NAMA DEVICE & BUTTON DELETE DEVICE -->
    <div class="row align-items-start">

      <!-- DEVICE NAME -->
      <div class="col">
        <h2 id="section" style="margin-left: 30px;"><?= $_GET["device_name"]; ?></h2>
      </div>

      <!-- BUTTON DELETE DEVICE -->
      <div class="col">
        <button type="submitDeleteDevice" class="btn btn-primary" id="button-del-device" data-toggle="modal" data-target=".bd-example-modal-sm" data-whatever="@getbootstrap" style="background-color: red; border-color:red;">
          <a id="add-new-device-text"> Delete Device </a>
          <span class="bi bi-plus-lg"></span>
        </button>
      </div>
    </div>

    <!-- POPUP/MODEL DELETE DEVICE -->
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 300px;">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Title -->
            <h5 class="modal-title" id="exampleModalLabel">DELETE DEVICE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="height: 125px;">
            <!-- FORM -->
            <form action="" method="post">
              <h3 id='confirmation'>Are you sure?</h3>
              <div class='footer'>

                <button type="submitDeleteDevice" class="btn btn-primary" data-dismiss="modal">NO</button>
                <button type="submitDeleteDevice" name="submitDeleteDevice" class="btn btn-primary" id="btn-save" style="background-color: red; border-color:red;">YES</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Layout Input & Limit -->
    <div class="row" style="margin-top: 40px;">
      <div class="col-sm-8">
        <!-- Kolom Input Form -->
        <div class="jumbotron jumbotron-fluid" style="height: 425px;">
          <div class="container">
            <h2 id="section">Input Form</h2>
            <!-- Input Form -->
            <table id="">
              <form action="" method="post">
                <td><input type="hidden" step=".01" id="dev" name="dev" value="<?= $dev_id ?>" required></td>

                <!-- Input Batasan -->
                <div class="form-group">
                  <label for="input-form" id="label-form">pH Limit</label>
                  <input type="number" min=0 step=".1" id="input-form" name="batasan_ph" value="" placeholder="Input pH" required>
                </div>
                <div class="form-group">
                  <label for="input-form" id="label-form">PPM Limit</label>
                  <input type="number" min=0 id="input-form" name="batasan_ppm" value="" placeholder="Input PPM" required />
                </div>

                <!-- Input Banyak Air dalam ml -->
                <div class="form-group">
                  <label for="input-form" id="label-form">Water Volume (ml)</label>
                  <input type="number" min=0 id="input-form" name="banyak_air" value="" placeholder="Input Water Volume" required />
                </div>

                <tr class="bottomright">
                  <!-- Button Submit -->
                  <td><button type="submit" name="submitBatasan" id="save-btn">Save</button></td>
                </tr>
              </form>
            </table>
          </div>
        </div>
      </div>

      <!-- Kolom Tampil Limit -->
      <div class="col-sm-4">
        <div class="jumbotron jumbotron-fluid" style="height: 425px;">
          <div class="container">

            <!-- Tampil pH limit -->
            <h3 id="section" style="text-align: center;">pH Limit</h3>
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

            <!-- Tampil PPM Limit -->
            <h3 id="section" style="text-align: center;">PPM Limit</h3>
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

            <!-- Tampil Water Volume -->
            <h3 id="section" style="text-align: center;">Water Volume</h3>
            <?php
            $sql = "SELECT banyak_air FROM batasan WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            ?>

            <?php $row = mysqli_fetch_assoc($result) ?>
            <?php if (!$row) : ?>
              <div id='limit-value'>
                <td> 0 ml</td>
              </div>
            <?php else : ?>
              <div id="limit-value">
                <td><?= $row['banyak_air']; ?> ml </td>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- pH FROM SENSOR -->
    <div class="row align-items-start">
      <div class="col">
        <?php
        // Attempt select query execution
        $sql = "SELECT sensor_ph FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="jumbotron jumbotron-fluid">
          <h3 id="section">pH Rate</h3>
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

      <!-- PPM FROM SENSOR -->
      <div class="col">
        <?php
        // Attempt select query execution
        $sql = "SELECT sensor_ppm FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="jumbotron jumbotron-fluid">
          <h3 id="section">PPM Rate</h3>
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

      <!--WATER LEVEL FROM SENSOR -->
      <div class="col">
        <?php
        // Attempt select query execution
        $sql = "SELECT sensor_level_air FROM arduino_data WHERE device_id='$dev_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="jumbotron jumbotron-fluid">
          <h3 id="section">Water Level</h3>
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

    <!-- DATA LOG -->
    <div class="jumbotron jumbotron-fluid la">
      <h3 id="section">Data Log</h3>

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
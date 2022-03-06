<?php
require '../Back-End/function.php';

if (isset($_POST["submitNewDevice"])) :
  if (savedNewDevice($_POST) > 0) :
    echo "
    <script>
    alert('DEVICE BERHASIL DITAMBAHKAN!');
    </script>
    ";
  else :
    echo "
    <script>
    alert('Device GAGAL DITAMBAHKAN!');
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/style_index.css" />

  <title>Skripsi Hidropinik</title>
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
        <a class="nav-link active" href="index.php">Device Collection</a>
      </div>
    </div>
    <a href="#down">
      <div class="notification-box">
        <span class="notification-count">!</span>
        <div class="notification-bell">
          <span class="bell-top"></span>
          <span class="bell-middle"></span>
          <span class="bell-bottom"></span>
          <span class="bell-rad"></span>
        </div>
    </a>
  </nav>

  <!-- LAYOUT COLLECTION OF DEVICES -->
  <div class="container" id="main-layout">
    <!-- KOLOM TITLE & BUTTON ADD NEW DEVICE -->
    <div class="row align-items-start">
      <!-- TITLE -->
      <div class="col">
        <h2>Collection of Devices</h2>
      </div>
      <!-- BUTTON ADD NEW DEVICE -->
      <div class="col">
        <button type="button" class="btn btn-primary" id="button-new-device" data-toggle="modal" data-target="#exampleModalCenter" data-whatever="@getbootstrap">
          <a id="add-new-device-text"> Add New Device </a>
          <span class="bi bi-plus-lg"></span>
        </button>
      </div>
    </div>

    <!-- POPUP/MODEL ADD NEW DEVICE -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Title -->
            <h5 class="modal-title" id="exampleModalLabel">Add New Device</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="height: 250px;">
            <!-- FORM -->
            <form action="" method="post">
              <table>
                <tr>
                  <td id="col-label"><label for="device_id" class="h5">Device ID </label></td>
                  <td id="col-input"><input placeholder="Max. 10 characters" type="text" id="device_id" name="device_id" value="" required style="width: 90%;"></td>
                </tr>
                <br>
                <tr>
                  <td id="col-label"><label for="device_name" class="h5">Device Name </label></td>
                  <td id="col-input"> <input placeholder="Max. 10 characters" type="text" id="device_name" name="device_name" value="" required style="width: 90%;" /></td>
                </tr>
                <tr id="bottomright">
                  <td><button type="submitNewDevice" name="submitNewDevice" class="btn btn-primary" id="btn-save">Save</button></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
    // Attempt select query execution
    $sql = "SELECT * FROM device_collection ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
    ?>

    <!-- Jumbotron Devices Collection-->
    <div class="container" id="layout-jumbot">
      <div class="row row-cols-3">
        <?php
        while ($row = mysqli_fetch_assoc($result)) : ?>
          <div class="col">
            <a href="deviceDetail.php?device_id=<?= $row['device_id']; ?>&device_name=<?= $row['device_name']; ?>" style="text-decoration: none;">
              <div class="jumbotron" id="jumbot-divcol">
                <div id="device-name-title"><?= $row['device_name']; ?></div>
              </div>
            </a>
          </div>
        <?php
        endwhile;
        ?>
      </div>
    </div>

    <!-- Notifikasi -->
    <h2 id="down">Notification</h2>
    <?php
    $sql = "SELECT device_collection.device_name, arduino_data.sensor_level_air, arduino_data.date FROM device_collection 
              LEFT JOIN arduino_data 
              ON device_collection.device_id=arduino_data.device_id ORDER BY arduino_data.date DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);
    ?>

    <table class="table table-bordered" id="table-notification">

      <tr bgcolor="#c2c2c9">
        <th id="header">Device Name</th>
        <th id="header">Notification</th>
        <th id="header">Date</th>
      </tr>

      <?php while ($row = mysqli_fetch_assoc($result)) :
        if ($row) :
      ?>
          <tr bgcolor="#FFFF8F">
            <?php if ($row['sensor_level_air'] == "MED") { ?>
              <td style="text-align: center;"><?= $row['device_name']; ?></td>
              <td>
                Ketinggian air sudah berkurang, mohon diperhatikan
              </td>
              <td style="text-align: center;"><?= $row['date']; ?></td>
          </tr>
        <?php } else if ($row['sensor_level_air'] == "LOW") { ?>
          <tr bgcolor="#FA8072">
            <td style="text-align: center;"><?= $row['device_name']; ?></td>
            <td>
              Ketinggian air sudah rendah, mohon untuk tambahkan air
            </td>
            <td style="text-align: center;"><?= $row['date']; ?></td>
          <?php } ?>
          </td>
          </tr>
        <?php endif; ?>
      <?php endwhile; ?>
    </table>
  </div>
</body>

</html>
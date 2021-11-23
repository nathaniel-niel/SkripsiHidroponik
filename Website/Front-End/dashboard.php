<?php
require '../Back-End/function.php';

if (isset($_POST["submit"])) {
  if (savedData($_POST) > 0) {
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
  <link rel="stylesheet" href="style_dashboard.css" />

  <title>Hello, world!</title>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

  <!-- bar navigasi -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="index.html">JNC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
        <a class="nav-link active" href="dashboard.php">Dashboard</a>
        <a class="nav-link" href="datalog.php">Data Log</a>
        <a class="nav-link" href="devicecollection.html">Device Collection</a>
      </div>
    </div>
  </nav>

  <!-- Input Form & Informasi Layout -->
  <div class="container" id="main-layout">
    <div class="row g-2">
      <!-- Layout Input Form -->
      <div class="col-6">
        <div class="p-3 border" id="layout-input-form">
          INPUT FORM
          <div class="container position">
            <form action="" method="post">
              <div class="row g-2">
                <div class="col-4">
                  <label for="batasan_ph" class="h5">Batasan pH</label>
                </div>
                <div class="col-4">
                  <input type="number" step=".01" id="batasan_ph" name="batasan_ph" value="" required>
                </div>
              </div>

              <div class="row g-2">
                <div class="col-4">
                  <label for="batasan_ppm" class="h5">Batasan PPM</label>
                </div>
                <div class="col-4">
                  <input type="number" id="batasan_ppm" name="batasan_ppm" value="" required />
                </div>
              </div>


              <button type="submit" name="submit">Save</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Layout Informasi -->
      <div class="col-6">
        <div class="p-3 border" id="layout-informasi">
          INFORMASI
          <?php
          // Attempt select query execution
          $sql = "SELECT * FROM arduino_input ORDER BY id DESC LIMIT 1";
          $result = mysqli_query($conn, $sql);
          ?>
          <table class="table table-bordered table-striped">
            <tr>
              <th id="t-head">pH</th>
              <th id="t-head">PPM</th>
              <th id="t-head">Water Level</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td><?= $row['batasan_ph']; ?></td>
                <td><?= $row['batasan_ppm']; ?></td>
                <td><?= $row['batasan_air']; ?></td>
              </tr>
            <?php
            endwhile; ?>
          </table>

        </div>
      </div>
    </div>
  </div>

  <!-- Layout Notifikasi -->
  <div class="container">
    <div class="p-3 border" id="layout-notifikasi">
      NOTIFIKASI
      <div class="container position">
        <table class="table table-striped">
          <th id="notif">
            <tr>
              <td id="message">
                Ketinggian air sudah rendah, mohon isi kembali wadah air
              </td>
              <td id="message-datetime">19/10/2021 10.23</td>
            </tr>
            <tr>
              <td id="message">
                Ketinggian air sudah rendah, mohon isi kembali wadah air
              </td>
              <td id="message-datetime">19/10/2021 10.23</td>
            </tr>
            <tr>
              <td id="message">
                Ketinggian air sudah rendah, mohon isi kembali wadah air
              </td>
              <td id="message-datetime">19/10/2021 10.23</td>
            </tr>
          </th>
        </table>
      </div>
    </div>
  </div>
</body>

</html>
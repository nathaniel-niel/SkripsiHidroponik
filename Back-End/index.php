<?php
require 'function.php';

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
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Input</title>
</head>

<body>
  <h2>User Input</h2>

  <form action="" method="post">
    <ul>
      <li>
        <label for="batasan_ph">Batasan pH:</label><br />
        <input type="text" id="batasan_ph" name="batasan_ph" value="" required />
      </li>
      <li>
        <label for="batasan_ppm">Batasan PPM:</label><br />
        <input type="text" id="batasan_ppm" name="batasan_ppm" value="" required />
      </li>
      <li>
        <button type="submit" name="submit">Save</button>
      </li>
    </ul>
  </form>
</body>

</html>
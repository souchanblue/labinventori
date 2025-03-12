<?php
session_start();
include_once '../dbconnect.php';
?>
<?php
$res = mysqli_query($conn, "SELECT * FROM slogin WHERE id = " . $_SESSION['id']);

$konten = $_POST['konten'];
$oleh = $_SESSION['user'];

$update = "INSERT INTO notes (contents, admin, tanggal_notes) 
           VALUES ('$konten', '$oleh', NOW())";
$hasil = mysqli_query($conn, $update);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Barang Keluar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f9f9f9;
    }

    .bee-container {
      text-align: center;
    }

    .bee-container img {
      width: 300px;
      height: auto;
    }
  </style>
  <script>
    setTimeout(function() {
      window.history.back();
    }, 100);
  </script>
</head>

<body>
  <div class="bee-container">
    <img src="../stock/assets/images/bee.gif" alt="Bee Icon">
  </div>
</body>

</html>
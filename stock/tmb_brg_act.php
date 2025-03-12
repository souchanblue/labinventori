<?php
include '../dbconnect.php';
$nama = $_POST['nama'];
$jenis = $_POST['jenis'];
$ukuran = $_POST['ukuran'];
$merk = $_POST['merk'];
$satuan = $_POST['satuan'];
$stock = $_POST['stock'];
$lokasi = $_POST['lokasi'];

$query = mysqli_query($conn, "INSERT INTO sstock_brg (nama, jenis, merk, ukuran, stock, satuan, lokasi) 
VALUES ('$nama', '$jenis', '$merk', '$ukuran', '$stock', '$satuan', '$lokasi')");
?>

<!DOCTYPE html>
<html>

<head>
  <title>Tambah Barang</title>
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
    }, 899);
  </script>
</head>

<body>
  <div class="bee-container">
    <img src="../stock/assets/images/kucing.gif" alt="Bee Icon">
  </div>
</body>

</html>
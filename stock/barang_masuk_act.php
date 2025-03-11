<?php 
include '../dbconnect.php';
$barang=$_POST['barang']; 
$qty=$_POST['qty'];
$tanggal=$_POST['tanggal'];
$ket=$_POST['ket'];

$dt=mysqli_query($conn,"select * from sstock_brg where idx='$barang'");
$data=mysqli_fetch_array($dt);
$sisa=$data['stock']+$qty;
$query1 = mysqli_query($conn,"update sstock_brg set stock='$sisa' where idx='$barang'");

$query2 = mysqli_query($conn,"insert into sbrg_masuk (idx,tgl,jumlah,keterangan) values('$barang','$tanggal','$qty','$ket')");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Barang Masuk</title>
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

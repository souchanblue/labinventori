<?php 
include '../dbconnect.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname']) && isset($_POST['role'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nickname = $_POST['nickname'];
    $role = $_POST['role'];

    $query = "INSERT INTO slogin (username, password, nickname, role) VALUES ('$username', '$password', '$nickname', '$role')";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah User</title>
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

<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['role'])) {
	header("location:stock");
}

if (isset($_GET['pesan'])) {
	if ($_GET['pesan'] == "gagal") {
		echo "Username atau Password salah!";
	} else if ($_GET['pesan'] == "logout") {
		echo "Anda berhasil keluar dari sistem";
	} else if ($_GET['pesan'] == "belum_login") {
		echo "Anda harus Login";
	} else if ($_GET['pesan'] == "noaccess") {
		echo "Akses Ditutup";
	}
}

if (isset($_POST['btn-login'])) {
	$uname = mysqli_real_escape_string($conn, $_POST['username']);
	$upass = mysqli_real_escape_string($conn, md5($_POST['password']));

	// menyeleksi data user dengan username dan password yang sesuai
	$login = mysqli_query($conn, "select * from slogin where username='$uname' and password='$upass';");
	// menghitung jumlah data yang ditemukan
	$cek = mysqli_num_rows($login);

	// cek apakah username dan password di temukan pada database
	if ($cek > 0) {

		$data = mysqli_fetch_assoc($login);

		if ($data['role'] == "stock") {
			// buat session login dan username
			$_SESSION['user'] = $data['nickname'];
			$_SESSION['user_login'] = $data['username'];
			$_SESSION['id'] = $data['id'];
			$_SESSION['role'] = "stock";
			header("location:stock");
		} else {
			header("location:index.php?pesan=gagal");
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
	<style>
		body {
			background-image: url("bg.gif");
			background-size: cover;
			background-position: center;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: 'Playfair Display', serif;
			background-color: rgba(161, 97, 97, 0.3);
			background-blend-mode: lighten;
		}


		.card {
			border-radius: 10px;
			padding: 20px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0);
			border: 3px solid #8a4049;
			padding: 10px;
			border-radius: 10px;
			background-color: rgb(255, 243, 224, 0.7);
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
		}

		h1 {
			font-size: 4rem;
			font-weight: bold;
			color: #8a4049;
			text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
			padding: 10px;
			border-radius: 10px;
		}

		p {
			font-size: 1.3rem;
			font-weight: bold;
			color: #8a4049;
			text-align: start;
		}

		.btn {
			color: white;
			background-color: #8a4049;
			border: none;
		}

		.btn:hover {
			background-color: rgb(124, 22, 22);
		}

		.form-control {
			border-radius: 5px;
		}
	</style>
	<link rel="icon" type="image/png" href="favicon.png">
</head>

<body>

	<div align="center">
		<div class="card">
			<h1>LabStock Manager</h1>

			<form method="post">
				<div class="form-group">
					<p>Username :</p>
					<input type="text" class="form-control" placeholder="Username" name="username" autofocus>
				</div>
				<p>password :</p>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Password" name="password">
				</div>
				<button type="submit" class="btn btn-block" name="btn-login">Masuk</button>
			</form>
		</div>
	</div>

</body>

</html>
<?php
$host = 'mysql-15bd42a2-bayuvtrde32-5c65.d.aivencloud.com'; // Ganti dengan host Aiven Anda
$port = '14075'; // Ganti dengan port Aiven Anda
$username = 'avnadmin'; // Ganti dengan username Aiven Anda
$password = 'AVNS_HfgidnLdGf7VS_JQdDH'; // Ganti dengan password Aiven Anda
$database = 'defaultdb'; // Ganti dengan nama database Anda

$conn = mysqli_connect($host . ':' . $port, $username, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

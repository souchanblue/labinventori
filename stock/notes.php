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
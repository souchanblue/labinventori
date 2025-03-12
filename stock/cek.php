<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != "stock") {
    header("location:../index.php?pesan=belum_login");
    exit();
}
?>

<?php
session_start(); // Pastikan ini di baris pertama
include '../dbconnect.php';
include 'cek.php';
?>

<!doctype html>
<html class="no-js" lang="en">

<?php
if (isset($_POST['update'])) {
    $id = $_POST['id']; //iddata
    $idx = $_POST['idx']; //idbarang
    $jumlah = $_POST['jumlah'];
    $penerima = $_POST['penerima'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];

    $lihatstock = mysqli_query($conn, "select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
    $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
    $stockskrg = $stocknya['stock']; //jumlah stocknya skrg

    $lihatdataskrg = mysqli_query($conn, "select * from sbrg_keluar where id='$id'"); //lihat qty saat ini
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg);
    $qtyskrg = $preqtyskrg['jumlah']; //jumlah skrg

    if ($jumlah >= $qtyskrg) {
        //ternyata inputan baru lebih besar jumlah keluarnya, maka kurangi lagi stock barang
        $hitungselisih = $jumlah - $qtyskrg;
        $kurangistock = $stockskrg - $hitungselisih;

        $queryx = mysqli_query($conn, "update sstock_brg set stock='$kurangistock' where idx='$idx'");
        $updatedata1 = mysqli_query($conn, "update sbrg_keluar set tgl='$tanggal',jumlah='$jumlah',penerima='$penerima',keterangan='$keterangan' where id='$id'");

        //cek apakah berhasil
        if ($updatedata1 && $queryx) {

            echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= keluar.php'/>  ";
        } else {
            echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= keluar.php'/> ";
        };
    } else {
        //ternyata inputan baru lebih kecil jumlah keluarnya, maka tambahi lagi stock barang
        $hitungselisih = $qtyskrg - $jumlah;
        $tambahistock = $stockskrg + $hitungselisih;

        $query1 = mysqli_query($conn, "update sstock_brg set stock='$tambahistock' where idx='$idx'");

        $updatedata = mysqli_query($conn, "update sbrg_keluar set tgl='$tanggal', jumlah='$jumlah', penerima='$penerima', keterangan='$keterangan' where id='$id'");

        //cek apakah berhasil
        if ($query1 && $updatedata) {

            echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= keluar.php'/>  ";
        } else {
            echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= keluar.php'/> ";
        };
    };
};

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $idx = $_POST['idx'];

    $lihatstock = mysqli_query($conn, "select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
    $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
    $stockskrg = $stocknya['stock']; //jumlah stocknya skrg

    $lihatdataskrg = mysqli_query($conn, "select * from sbrg_keluar where id='$id'"); //lihat qty saat ini
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg);
    $qtyskrg = $preqtyskrg['jumlah']; //jumlah skrg

    $adjuststock = $stockskrg + $qtyskrg;

    $queryx = mysqli_query($conn, "update sstock_brg set stock='$adjuststock' where idx='$idx'");
    $del = mysqli_query($conn, "delete from sbrg_keluar where id='$id'");


    //cek apakah berhasil
    if ($queryx && $del) {

        echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
              </div>
            <meta http-equiv='refresh' content='1; url= keluar.php'/>  ";
    } else {
        echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
              </div>
             <meta http-equiv='refresh' content='1; url= keluar.php'/> ";
    }
};
?>

<head>
    <meta charset="utf-8">
    <link rel="icon"
        type="image/png"
        href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Barang keluar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144808195-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-144808195-1');
    </script>

    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body style="background-color: #EAEAEA">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <style>
            .alert {
                margin-bottom: 0;
            }

            .sidebar-menu {
                background: #2DAA9E;
                color: #EAEAEA;
                height: 100vh;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .sidebar-header {
                padding: 20px;
                text-align: center;
                border-bottom: 2px solid #EAEAEA;
                background: #2DAA9E;
            }

            .sidebar-header img {
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .main-menu nav ul {
                padding: 0;
                list-style: none;
            }

            .main-menu {
                padding: 0;
            }

            .main-menu nav ul li {
                padding: 15px 20px;
                border-bottom: 1px solid #EAEAEA;
            }

            .main-menu nav ul li a {
                color: rgb(255, 255, 255);
                text-decoration: none;
                font-weight: bold;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .main-menu nav ul li a:hover {
                background: #66D2CE;
                border-radius: 5px;
            }

            .main-menu nav ul .collapse li a {
                padding-left: 40px;
                font-weight: normal;
            }

            .main-menu nav ul li.active a {
                background: #66D2CE;
                border-radius: 5px;
            }

            .main-menu nav ul li a i {
                color: #EAEAEA;
            }
        </style>

        <div class="sidebar-menu">
            <div class="sidebar-header">
                <a href="#" id="change-photo">
                    <img src="<?php echo isset($_SESSION['foto']) ? $_SESSION['foto'] : 'logo.jpg'; ?>" alt="logo" id="profile-photo" width="300px">
                </a>

                <!-- Input file tersembunyi -->
                <input type="file" id="file-input" accept="image/*" style="display: none;">
            </div>
            <script>
                document.getElementById('change-photo').addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('file-input').click();
                });

                document.getElementById('file-input').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Tampilkan preview gambar langsung
                            document.getElementById('profile-photo').src = event.target.result;

                            // Kirim file ke server untuk disimpan
                            const formData = new FormData();
                            formData.append('foto', file);

                            fetch('upload_foto.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Foto berhasil diupload!');
                                    } else {
                                        alert('Gagal mengupload foto.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="index.php"><i class="ti-book"></i><span>Notes </span></a>
                            </li>
                            <li>
                                <a href="stock.php"><i class="ti-package"></i><span>Stock Barang</span></a>
                            </li>
                            <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout"></i><span>Transaksi Data
                                    </span></a>
                                <ul class="collapse">
                                    <li><a href="masuk.php">Barang Masuk / Kembali</a></li>
                                    <li class="active"><a href="keluar.php">Barang Keluar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="logout.php"><i class="ti-arrow-circle-left"></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Tambahkan link Google Fonts di head -->
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Cinzel:wght@400;700&family=Lora:wght@400;700&family=Raleway:wght@400;700&family=Quicksand:wght@400;700&family=Dancing+Script:wght@400;700&family=Great+Vibes&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">

        <style>
            /* Ganti font untuk seluruh elemen */
            body {
                font-family: 'Lora', serif;
                /* Font utama */
            }

            /* Ganti font untuk judul */
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'Playfair Display', serif;
                /* Font untuk judul */
            }

            /* Ganti font untuk tombol */
            .btn {
                font-family: 'Raleway', sans-serif;
                /* Font untuk tombol */
            }

            /* Ganti font untuk tabel */
            .table {
                font-family: 'Quicksand', sans-serif;
                /* Font untuk tabel */
            }

            /* Ganti font untuk modal */
            .modal-title {
                font-family: 'Cinzel', serif;
                /* Font untuk judul modal */
            }

            /* Ganti font untuk teks khusus (misalnya, teks script) */
            .vintage-script {
                font-family: 'Dancing Script', cursive;
                /* Font untuk teks script */
            }

            /* Ganti font untuk teks monospace (misalnya, kode atau teks mesin ketik) */
            .vintage-monospace {
                font-family: 'Courier Prime', monospace;
                /* Font untuk teks monospace */
            }
        </style>

        <!-- main content area start -->
                <!-- main content area start -->
                <div class="main-content" style="background-color: #EAEAEA;">
        <style>
                .header-area {
                    background: #2DAA9E;
                    padding: 10px 20px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    border-bottom: 2px solid #EAEAEA;
                }

                .header-area h2 {
                    color: rgb(255, 255, 255);
                    font-weight: bold;
                }

                .nav-btn span {
                    display: block;
                    width: 25px;
                    height: 3px;
                    margin: 3px 0;
                    background: rgb(255, 255, 255);
                }

                .date {
                    color: rgb(255, 255, 255);
                    font-weight: bold;
                    padding: 5px 10px;
                    border-radius: 10px;
                }
            </style>

            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <form action="#">
                                <h2>Halo, <?= $_SESSION['user']; ?>!</h2>
                            </form>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li>
                                <h3>
                                    <div class="date">
                                        <script type='text/javascript'>
                                            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                            var date = new Date();
                                            var day = date.getDate();
                                            var month = date.getMonth();
                                            var thisDay = date.getDay();
                                            thisDay = myDays[thisDay];
                                            var yy = date.getYear();
                                            var year = (yy < 1000) ? yy + 1900 : yy;
                                            document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                                        </script>
                                    </div>
                                </h3>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
           <style>
                .card {
                    background-color: #2DAA9E;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                /* Gaya untuk tabel dengan tema warna */
                .data-tables.datatable-dark {
                    background-color: #EAEAEA;
                    color:rgb(0, 0, 0);
                    border: 1px solid #2DAA9E;
                    border-radius: 8px;
                    padding: 10px;
                }

                .data-tables.datatable-dark table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .data-tables.datatable-dark th {
                    background-color: #2DAA9E;
                    color: rgb(255, 255, 255);
                    padding: 10px;
                    text-align: center;
                }

                .data-tables.datatable-dark td {
                    padding: 8px;
                    border: 1px solid #2DAA9E;
                    background-color: rgb(255, 255, 255);
                    text-align: center;
                    /* Pusatkan teks dalam sel */

                }

                .data-tables.datatable-dark tbody tr:nth-child(odd) {
                    background-color: #2DAA9E;
                }

                .btn-danger {
                    background-color: #B4846C;
                    color: rgb(255, 255, 255);
                    border: 1px solid #B4846C;
                }

                .btn-danger:hover {
                    background-color: #B4846C;
                    color: #FCDEC0;
                }

                /* Input form styling */
                .form-control {
                    border: 1px solid #2DAA9E;
                    background-color: rgb(255, 255, 255);
                    color:rgb(0, 0, 0);
                }

                .form-control:focus {
                    border-color: #2DAA9E;
                    outline: none;
                    box-shadow: 0 0 5px #2DAA9E;
                }

                /* Tombol simpan */
                .btn-success {
                    background-color: #B4846C;
                    color: #EAEAEA;
                    border: 1px solid #B4846C;
                }

                .btn-success:hover {
                    background-color: #145A32;
                    color: #EAEAEA;
                }

                /* Tombol close */
                .btn-secondary {
                    background-color: #C96868;
                    color: #EAEAEA;
                    border: 1px solid #B4846C;
                }

                .btn-secondary:hover {
                    background-color: #B4846C;
                    color: #EAEAEA;
                }

                .card {
                    background-color: #EAEAEA;
                    /* Warna latar belakang card */
                }

                .thead-dark {
                    background-color: #EAEAEA;
                    /* Warna latar belakang header tabel */
                    color: white;
                    /* Warna teks header tabel */
                }

                .btn-info {
                    background-color: #7EACB5;
                    /* Warna tombol Tambah Barang */
                    border-color: #7EACB5;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-info:hover {
                    background-color:rgb(112, 153, 161);
                    /* Warna hover untuk tombol Tambah Barang */
                    border-color: #7EACB5;
                }

                .btn-warning {
                    background-color: #3D8D7A;
                    /* Warna tombol Edit */
                    border-color: #3D8D7A;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-warning:hover {
                    background-color: #3D8D7A;
                    /* Warna hover untuk tombol Edit */
                    border-color: #3D8D7A;
                }

                .btn-danger {
                    background-color: #B4846C;
                    /* Warna tombol Delete */
                    border-color: #B4846C;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-danger:hover {
                    background-color: #B4846C;
                    /* Warna hover untuk tombol Delete */
                    border-color: #6A4A42;
                }

                .btn-success {
                    background-color:rgb(255, 255, 255);
                    /* Warna tombol Save dan Hapus */
                    border-color:rgb(0, 0, 0);
                    color: black;
                    /* Warna teks tombol */
                }

                .btn-success:hover {
                    background-color: #54C392;
                    /* Warna hover untuk tombol Save dan Hapus */
                    border-color: #54C392;
                }

                .btn-secondary {
                    background-color: #181C14;
                    /* Warna tombol Close dan Batal */
                    border-color: #181C14;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-secondary:hover {
                    background-color:rgb(13, 15, 11);
                    /* Warna hover untuk tombol Close dan Batal */
                    border-color: #181C14;
                }

                /* Tombol edit dan delete */
                .btn-warning {
                    background-color: #3D8D7A;
                    color:rgb(255, 255, 255);
                    border: 1px solid #3D8D7A;
                }

                .btn-warning:hover,
                .btn-warning:active {
                    background-color:rgb(49, 112, 97) !important;
                    color:rgb(255, 255, 255) !important;
                    box-shadow: none !important;
                    border: 1px solid #3D8D7A;

                }

                .btn-danger {
                    background-color: #A02334;
                    color:rgb(255, 255, 255);
                    border: 1px solid #A02334;
                }

                i {
                    color: white;
                }

                .btn-danger:hover,
                .btn-danger:active {
                    background-color: #A02334 !important;
                    color:rgb(255, 255, 255) !important;
                    box-shadow: none !important;
                    border: 1px solid #A02334;

                }
            </style>
            <div class="main-content-inner">

                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <h2 style="color:rgb(0, 0, 0);">Barang Keluar</h2>
                                    <button style="margin-bottom:20px; background-color: #629584; border-color: rgb(255, 255, 255);" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2 text-white">
                                        <span class="glyphicon glyphicon-plus"></span>Tambah
                                    </button>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="dataTable3" class="display" style="width:100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Barang</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah</th>
                                                <th>Penerima</th>
                                                <th>Keterangan</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $brg = mysqli_query($conn, "SELECT * FROM sbrg_keluar sb, sstock_brg st where st.idx=sb.idx ORDER BY id DESC");
                                            $no = 1;
                                            while ($b = mysqli_fetch_array($brg)) {
                                                $idb = $b['idx'];
                                                $id = $b['id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php $tanggals = $b['tgl'];
                                                        echo date("d-M-Y", strtotime($tanggals)) ?></td>
                                                    <td><?php echo $b['nama'] ?> <?php echo $b['jenis'] ?> <?php echo $b['merk'] ?></td>
                                                    <td><?php echo $b['ukuran'] ?></td>
                                                    <td><?php echo $b['jumlah'] ?></td>
                                                    <td><?php echo $b['penerima'] ?></td>
                                                    <td><?php echo $b['keterangan'] ?></td>
                                                    <td>
                                                        <button data-toggle="modal" data-target="#edit<?= $id; ?>" class="btn btn-warning"><i class="ti-pencil"></i></button>
                                                        <button data-toggle="modal" data-target="#del<?= $id; ?>" class="btn btn-danger"><i class="ti-trash"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- The Modal -->
                                                <div class="modal fade" id="edit<?= $id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="post">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Data</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <label for="tanggal">Tanggal</label>
                                                                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo $b['tgl'] ?>">

                                                                    <label for="nama">Barang</label>
                                                                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $b['nama'] ?> <?php echo $b['merk'] ?> <?php echo $b['jenis'] ?>" disabled>

                                                                    <label for="ukuran">Ukuran</label>
                                                                    <input type="text" id="ukuran" name="ukuran" class="form-control" value="<?php echo $b['ukuran'] ?>" disabled>

                                                                    <label for="jumlah">Jumlah</label>
                                                                    <input type="number" id="jumlah" name="jumlah" class="form-control" value="<?php echo $b['jumlah'] ?>">

                                                                    <label for="penerima">Penerima</label>
                                                                    <input type="text" id="penerima" name="penerima" class="form-control" value="<?php echo $b['penerima'] ?>">

                                                                    <label for="keterangan">Keterangan</label>
                                                                    <input type="text" id="keterangan" name="keterangan" class="form-control" value="<?php echo $b['keterangan'] ?>">
                                                                    <input type="hidden" name="id" value="<?= $id; ?>">
                                                                    <input type="hidden" name="idx" value="<?= $idb; ?>">
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success" name="update">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- The Modal -->
                                                <div class="modal fade" id="del<?= $id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="post">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Hapus Barang <?php echo $b['nama'] ?> - <?php echo $b['jenis'] ?> - <?php echo $b['ukuran'] ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus barang ini dari daftar stock?
                                                                    <br>
                                                                    *Stock barang akan bertambah
                                                                    <input type="hidden" name="id" value="<?= $id; ?>">
                                                                    <input type="hidden" name="idx" value="<?= $idb; ?>">
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="exportbrgklr.php" target="_blank" class="mt-4 btn btn-info text-white">Export Data</a>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                .card {
                    background-color: #2DAA9E;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                /* Gaya untuk tabel dengan tema warna */
                .data-tables.datatable-dark {
                    background-color: #EAEAEA;
                    color:rgb(0, 0, 0);
                    border: 1px solid #2DAA9E;
                    border-radius: 8px;
                    padding: 10px;
                }

                .data-tables.datatable-dark table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .data-tables.datatable-dark th {
                    background-color: #2DAA9E;
                    color: rgb(255, 255, 255);
                    padding: 10px;
                    text-align: center;
                }

                .data-tables.datatable-dark td {
                    padding: 8px;
                    border: 1px solid #2DAA9E;
                    background-color: rgb(255, 255, 255);
                    text-align: center;
                    /* Pusatkan teks dalam sel */

                }

                .data-tables.datatable-dark tbody tr:nth-child(odd) {
                    background-color: #2DAA9E;
                }

                .btn-danger {
                    background-color: #B4846C;
                    color: rgb(255, 255, 255);
                    border: 1px solid #B4846C;
                }

                .btn-danger:hover {
                    background-color: #B4846C;
                    color: #FCDEC0;
                }

                /* Input form styling */
                .form-control {
                    border: 1px solid #2DAA9E;
                    background-color: rgb(255, 255, 255);
                    color:rgb(0, 0, 0);
                }

                .form-control:focus {
                    border-color: #2DAA9E;
                    outline: none;
                    box-shadow: 0 0 5px #2DAA9E;
                }

                /* Tombol simpan */
                .btn-success {
                    background-color: #B4846C;
                    color: #EAEAEA;
                    border: 1px solid #B4846C;
                }

                .btn-success:hover {
                    background-color: #145A32;
                    color: #EAEAEA;
                }

                /* Tombol close */
                .btn-secondary {
                    background-color: #C96868;
                    color: #EAEAEA;
                    border: 1px solid #B4846C;
                }

                .btn-secondary:hover {
                    background-color: #B4846C;
                    color: #EAEAEA;
                }

                .card {
                    background-color: #EAEAEA;
                    /* Warna latar belakang card */
                }

                .thead-dark {
                    background-color: #EAEAEA;
                    /* Warna latar belakang header tabel */
                    color: white;
                    /* Warna teks header tabel */
                }

                .btn-info {
                    background-color: #7EACB5;
                    /* Warna tombol Tambah Barang */
                    border-color: #7EACB5;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-info:hover {
                    background-color:rgb(112, 153, 161);
                    /* Warna hover untuk tombol Tambah Barang */
                    border-color: #7EACB5;
                }

                .btn-warning {
                    background-color: #3D8D7A;
                    /* Warna tombol Edit */
                    border-color: #3D8D7A;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-warning:hover {
                    background-color: #3D8D7A;
                    /* Warna hover untuk tombol Edit */
                    border-color: #3D8D7A;
                }

                .btn-danger {
                    background-color: #B4846C;
                    /* Warna tombol Delete */
                    border-color: #B4846C;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-danger:hover {
                    background-color: #B4846C;
                    /* Warna hover untuk tombol Delete */
                    border-color: #6A4A42;
                }

                .btn-success {
                    background-color:rgb(255, 255, 255);
                    /* Warna tombol Save dan Hapus */
                    border-color:rgb(0, 0, 0);
                    color: black;
                    /* Warna teks tombol */
                }

                .btn-success:hover {
                    background-color: #54C392;
                    /* Warna hover untuk tombol Save dan Hapus */
                    border-color: #54C392;
                }

                .btn-secondary {
                    background-color: #181C14;
                    /* Warna tombol Close dan Batal */
                    border-color: #181C14;
                    color: white;
                    /* Warna teks tombol */
                }

                .btn-secondary:hover {
                    background-color:rgb(13, 15, 11);
                    /* Warna hover untuk tombol Close dan Batal */
                    border-color: #181C14;
                }

                /* Tombol edit dan delete */
                .btn-warning {
                    background-color: #3D8D7A;
                    color:rgb(255, 255, 255);
                    border: 1px solid #3D8D7A;
                }

                .btn-warning:hover,
                .btn-warning:active {
                    background-color:rgb(49, 112, 97) !important;
                    color:rgb(255, 255, 255) !important;
                    box-shadow: none !important;
                    border: 1px solid #3D8D7A;

                }

                .btn-danger {
                    background-color: #A02334;
                    color:rgb(255, 255, 255);
                    border: 1px solid #A02334;
                }

                i {
                    color: white;
                }

                .btn-danger:hover,
                .btn-danger:active {
                    background-color: #A02334 !important;
                    color:rgb(255, 255, 255) !important;
                    box-shadow: none !important;
                    border: 1px solid #A02334;

                }
            </style>


                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
    </div>
    <!-- page container area end -->

    <!-- modal input -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Input Barang Keluar</h4>
                </div>
                <div class="modal-body">
                    <form action="barang_keluar_act.php" method="post">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="barang" class="custom-select form-control">
                                <option selected>Pilih barang</option>
                                <?php
                                $det = mysqli_query($conn, "select * from sstock_brg order by nama ASC") or die(mysqli_error($conn));
                                while ($d = mysqli_fetch_array($det)) {
                                ?>
                                    <option value="<?php echo $d['idx'] ?>"><?php echo $d['nama'] ?> <?php echo $d['merk'] ?> <?php echo $d['jenis'] ?>, Uk. <?php echo $d['ukuran'] ?> --- Stock : <?php echo $d['stock'] ?></option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input name="qty" type="number" min="1" class="form-control" placeholder="Qty">
                        </div>
                        <div class="form-group">
                            <label>Penerima</label>
                            <input name="penerima" type="text" class="form-control" placeholder="Penerima barang">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input name="ket" type="text" class="form-control" placeholder="Keterangan">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
                    $('input').on('keydown', function(event) {
                        if (this.selectionStart == 0 && event.keyCode >= 65 && event.keyCode <= 90 && !(event.shiftKey) && !(event.ctrlKey) && !(event.metaKey) && !(event.altKey)) {
                            var $t = $(this);
                            event.preventDefault();
                            var char = String.fromCharCode(event.keyCode);
                            $t.val(char + $t.val().slice(this.selectionEnd));
                            this.setSelectionRange(1, 1);
                        }
                    });


                    $(document).ready(function() {
                        $('#dataTable3').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'print'
                            ]
                        });
                    });
    </script>

    <!-- jquery latest version -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            $('input').on('keydown', function(event) {
                if (this.selectionStart == 0 && event.keyCode >= 65 && event.keyCode <= 90 && !(event.shiftKey) && !(event.ctrlKey) && !(event.metaKey) && !(event.altKey)) {
                    var $t = $(this);
                    event.preventDefault();
                    var char = String.fromCharCode(event.keyCode);
                    $t.val(char + $t.val().slice(this.selectionEnd));
                    this.setSelectionRange(1, 1);
                }
            });
        });
    </script>
</body>

</html>
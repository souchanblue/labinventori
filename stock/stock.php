<?php
session_start(); // Pastikan ini di baris pertama
include '../dbconnect.php';
include 'cek.php';
?>

<!doctype html>
<html class="no-js" lang="en">

<?php
if (isset($_POST['update'])) {
    $idx = $_POST['idbrg'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $merk = $_POST['merk'];
    $ukuran = $_POST['ukuran'];
    $satuan = $_POST['satuan'];
    $lokasi = $_POST['lokasi'];

    $updatedata = mysqli_query($conn, "update sstock_brg set nama='$nama', jenis='$jenis', merk='$merk', ukuran='$ukuran', satuan='$satuan', lokasi='$lokasi' where idx='$idx'");

    //cek apakah berhasil
    if ($updatedata) {

        echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
              </div>
            <meta http-equiv='refresh' content='1; url= stock.php'/>  ";
    } else {
        echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
              </div>
             <meta http-equiv='refresh' content='1; url= stock.php'/> ";
    }
};

if (isset($_POST['hapus'])) {
    $idx = $_POST['idbrg'];

    $delete = mysqli_query($conn, "delete from sstock_brg where idx='$idx'");
    //hapus juga semua data barang ini di tabel keluar-masuk
    $deltabelkeluar = mysqli_query($conn, "delete from sbrg_keluar where id='$idx'");
    $deltabelmasuk = mysqli_query($conn, "delete from sbrg_masuk where id='$idx'");

    //cek apakah berhasil
    if ($delete && $deltabelkeluar && $deltabelmasuk) {

        echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
              </div>
            <meta http-equiv='refresh' content='1; url= stock.php'/>  ";
    } else {
        echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
              </div>
             <meta http-equiv='refresh' content='1; url= stock.php'/> ";
    }
};
?>

<head>
    <meta charset="utf-8">
    <link rel="icon"
        type="image/png"
        href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Alat dan Bahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
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
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body style="background-color: #EAEAEA;">
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
                            <li class="active">
                                <a href="stock.php"><i class="ti-package"></i><span>Stock Barang</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout"></i><span>Transaksi Data
                                    </span></a>
                                <ul class="collapse">
                                    <li><a href="masuk.php">Barang Masuk / Kembali</a></li>
                                    <li><a href="keluar.php">Barang Keluar</a></li>
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

            <?php
            $periksa_bahan = mysqli_query($conn, "select * from sstock_brg where stock <1");
            while ($p = mysqli_fetch_array($periksa_bahan)) {
                if ($p['stock'] <= 1) {
            ?>
                    <script>
                        $(document).ready(function() {
                            $('#pesan_sedia').css("color", "white");
                            $('#pesan_sedia').append("<i class='ti-flag'></i>");
                        });
                    </script>
            <?php
                    echo "<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>Stok  <strong><u>" . $p['nama'] . "</u> <u>" . ($p['merk']) . "</u> &nbsp <u>" . $p['ukuran'] . "</u></strong> yang tersisa sudah habis</div>";
                }
            }
            ?>
            <div class="main-content-inner">
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <h2 style="color:rgb(0, 0, 0);">Daftar Barang</h2>
                                    <button style="margin-bottom:20px; background-color: #629584; border-color:rgb(255, 255, 255);" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2">
                                        <span class="glyphicon glyphicon-plus"></span>Tambah Barang
                                    </button>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="dataTable3" class="display" style="width:100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jenis</th>
                                                <th>Merk</th>
                                                <th>Ukuran</th>
                                                <th>Stock</th>
                                                <th>Satuan</th>
                                                <th>Lokasi</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $brgs = mysqli_query($conn, "SELECT * from sstock_brg order by nama ASC");
                                            $no = 1;
                                            while ($p = mysqli_fetch_array($brgs)) {
                                                $idb = $p['idx'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $p['nama'] ?></td>
                                                    <td><?php echo $p['jenis'] ?></td>
                                                    <td><?php echo $p['merk'] ?></td>
                                                    <td><?php echo $p['ukuran'] ?></td>
                                                    <td><?php echo $p['stock'] ?></td>
                                                    <td><?php echo $p['satuan'] ?></td>
                                                    <td><?php echo $p['lokasi'] ?></td>
                                                    <td>
                                                        <button data-toggle="modal" data-target="#edit<?= $idb; ?>" class="btn btn-warning"><i class="ti-pencil"></i></button>
                                                        <button data-toggle="modal" data-target="#del<?= $idb; ?>" class="btn btn-danger"><i class="ti-trash"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- The Modal -->
                                                <div class="modal fade" id="edit<?= $idb; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="post">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Barang <?php echo $p['nama'] ?> - <?php echo $p['jenis'] ?> - <?php echo $p['ukuran'] ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <label for="nama">Nama</label>
                                                                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $p['nama'] ?>">

                                                                    <label for="jenis">Jenis</label>
                                                                    <input type="text" id="jenis" name="jenis" class="form-control" value="<?php echo $p['jenis'] ?>">

                                                                    <label for="merk">Merk</label>
                                                                    <input type="text" id="merk" name="merk" class="form-control" value="<?php echo $p['merk'] ?>">

                                                                    <label for="ukuran">Ukuran</label>
                                                                    <input type="text" id="ukuran" name="ukuran" class="form-control" value="<?php echo $p['ukuran'] ?>">

                                                                    <label for="stock">Stock</label>
                                                                    <input type="text" id="stock" name="stock" class="form-control" value="<?php echo $p['stock'] ?>" disabled>

                                                                    <label for="satuan">Satuan</label>
                                                                    <input type="text" id="satuan" name="satuan" class="form-control" value="<?php echo $p['satuan'] ?>">

                                                                    <label for="lokasi">Lokasi</label>
                                                                    <input type="text" id="lokasi" name="lokasi" class="form-control" value="<?php echo $p['lokasi'] ?>">
                                                                    <input type="hidden" name="idbrg" value="<?= $idb; ?>">
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
                                                <div class="modal fade" id="del<?= $idb; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="post">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Hapus Barang <?php echo $p['nama'] ?> - <?php echo $p['jenis'] ?> - <?php echo $p['ukuran'] ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus barang ini dari daftar stock?
                                                                    <input type="hidden" name="idbrg" value="<?= $idb; ?>">
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
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="exportstkbhn.php" target="_blank" class="mt-4 btn btn-info">Export Data</a>
                                <a href="tambah_admin.php" class="mt-4 btn btn-warning">Tambah Admin</a>
                            </div>
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

            <!-- main content area end -->
        </div>
        <!-- page container area end -->

        <!-- modal input -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Masukkan stok manual</h4>
                    </div>
                    <div class="modal-body">
                        <form action="tmb_brg_act.php" method="post">
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="nama" type="text" class="form-control" placeholder="Nama Barang" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <input name="jenis" type="text" class="form-control" placeholder="Jenis / Kategori Barang">
                            </div>
                            <div class="form-group">
                                <label>Merk</label>
                                <input name="merk" type="text" class="form-control" placeholder="Merk Barang">
                            </div>
                            <div class="form-group">
                                <label>Ukuran</label>
                                <input name="ukuran" type="text" class="form-control" placeholder="Ukuran">
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <select style="padding: 8px 12px; line-height: 1.5;" name="satuan" class="custom-select form-control">

                                    <option selected>Pilih satuan</option>
                                    <option value="Kilogram">Kilogram (kg)</option>
                                    <option value="Gram">Gram (g)</option>
                                    <option value="Liter">Liter (L)</option>
                                    <option value="Mililiter">Mililiter (mL)</option>
                                    <option value="Milimeter">Milimeter (mm)</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Pack">Pack</option>
                                </select>
                            <div class="form-group">
                                <label>Stock</label>
                                <input name="stock" type="number" min="0" class="form-control" placeholder="Qty">
                            </div>

                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input name="lokasi" type="text" class="form-control" placeholder="Lokasi barang">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-success" value="Simpan">
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
        <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
        <!-- all line chart activation -->
        <script src="assets/js/line-chart.js"></script>
        <!-- all pie chart -->
        <script src="assets/js/pie-chart.js"></script>
        <!-- others plugins -->
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/scripts.js"></script>


</body>

</html>
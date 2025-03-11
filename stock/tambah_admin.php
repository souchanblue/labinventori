<!doctype html>
<html class="no-js" lang="en">

<?php
include '../dbconnect.php';
include 'cek.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password menggunakan MD5
    $nickname = $_POST['nickname'];
    $role = $_POST['role'];

    $updatedata = mysqli_query($conn, "UPDATE slogin SET username='$username', password='$password', nickname='$nickname', role='$role' WHERE id='$id'");

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
    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM slogin WHERE id='$id'");

    if ($delete) {
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
    <link rel="icon" type="image/png" href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>User Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        function gtag() { dataLayer.push(arguments); }
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

<body style="background-color: #FCDEC0;">
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
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
        <!-- main content area start -->
        <div class="main-content" style="background-color: #FCDEC0;">
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

            <div class="main-content-inner" style="background-color: #FCDEC0;">
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <h2 style="color: #7D5A50;">Daftar User</h2>
                                    <button style="margin-bottom:20px; background-color: #B4846C; border-color: #B4846C;" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2">
                                        <span class="glyphicon glyphicon-plus"></span>Tambah User
                                    </button>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="dataTable3" class="display" style="width:100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Nama Lengkap</th>
                                                <th>Role</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $users = mysqli_query($conn, "SELECT * from slogin order by username ASC");
                                            $no = 1;
                                            while ($p = mysqli_fetch_array($users)) {
                                                $id = $p['id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $p['username'] ?></td>
                                                    <td><?php echo $p['password'] ?></td>
                                                    <td><?php echo $p['nickname'] ?></td>
                                                    <td><?php echo ($p['role'] === 'stock') ? 'admin' : $p['role']; ?></td>
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
                                                                    <h4 class="modal-title">Edit User <?php echo $p['username'] ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <label for="username">Username</label>
                                                                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $p['username'] ?>">

                                                                    <label for="password">Password</label>
                                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password baru">

                                                                    <label for="nickname">Nama Lengkap</label>
                                                                    <input type="text" id="nickname" name="nickname" class="form-control" value="<?php echo $p['nickname'] ?>">

                                                                    <label for="role">Role</label>
                                                                    <select name="role" class="custom-select form-control">
                                                                    <option value="stock" <?php if ($p['role'] == 'stock') echo 'selected'; ?>>Admin</option>
                                                                    </select>
                                                                    <input type="hidden" name="id" value="<?= $id; ?>">
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
                                                                    <h4 class="modal-title">Hapus User <?php echo $p['username'] ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus user ini?
                                                                    <input type="hidden" name="id" value="<?= $id; ?>">
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
                            </div>
                        </div>
                    </div>
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
                        <h4 class="modal-title">Tambah User</h4>
                    </div>
                    <div class="modal-body">
                        <form action="tmb_user_act.php" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" type="text" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input name="nickname" type="text" class="form-control" placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" class="custom-select form-control">
                                    <option value="stock">Admin</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning text-white" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-danger text-white" value="Simpan">
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
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
        <style>
            .sidebar-menu {
                background: #7D5A50;
                color: #FCDEC0;
                height: 100vh;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .sidebar-header {
                padding: 20px;
                text-align: center;
                border-bottom: 2px solid #B4846C;
                background: #7D5A50;
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
                border-bottom: 1px solid #B4846C;
            }

            .main-menu nav ul li a {
                color: #FCDEC0;
                text-decoration: none;
                font-weight: bold;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .main-menu nav ul li a:hover {
                background: #B4846C;
                border-radius: 5px;
            }

            .main-menu nav ul .collapse li a {
                padding-left: 40px;
                font-weight: normal;
            }

            .main-menu nav ul li.active a {
                background: #B4846C;
                border-radius: 5px;
            }

            .main-menu nav ul li a i {
                color: #FCDEC0;
            }
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
            .header-area {
                    background: #B4846C;
                    padding: 10px 20px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    border-bottom: 2px solid #FCDEC0;
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
                .btn-info {
                        background-color: #B4846C;
                        color: #FCDEC0;
                        border: 1px solid #B4846C;
                    }
                    .btn-info:hover {
                        background-color: #B4846C;
                        color: #FCDEC0;
                        border: 1px solid #B4846C;
                    }

                    .card {
                        background-color: rgb(245, 215, 184);
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    /* Gaya untuk tabel dengan tema warna */
                    .data-tables.datatable-dark {
                        background-color: #F1DEC9;
                        color: #7D5A50;
                        border: 1px solid #B4846C;
                        border-radius: 8px;
                        padding: 10px;
                    }

                    .data-tables.datatable-dark table {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    .data-tables.datatable-dark th {
                        background-color: #B4846C;
                        color: rgb(255, 255, 255);
                        padding: 10px;
                        text-align: center;
                    }

                    .data-tables.datatable-dark td {
                        padding: 8px;
                        border: 1px solid #E5B299;
                        background-color: rgb(255, 255, 255);
                        text-align: center;
                    }

                    .data-tables.datatable-dark tbody tr:nth-child(odd) {
                        background-color: #E5B299;
                    }

                    /* Tombol edit dan delete */
                    .btn-warning {
                        background-color: #E5B299;
                        color: #7D5A50;
                        border: 1px solid #B4846C;
                    }

                    .btn-warning:hover {
                        background-color: #B4846C;
                        color: rgb(255, 255, 255);
                    }

                    .btn-danger {
                        background-color: #7D5A50;
                        color: rgb(255, 255, 255);
                        border: 1px solid #B4846C;
                    }

                    .btn-danger:hover {
                        background-color: #B4846C;
                        color: #FCDEC0;
                    }

                    /* Input form styling */
                    .form-control {
                        border: 1px solid #B4846C;
                        background-color: rgb(255, 255, 255);
                        color: #7D5A50;
                    }

                    .form-control:focus {
                        border-color: #7D5A50;
                        outline: none;
                        box-shadow: 0 0 5px #B4846C;
                    }

                    /* Tombol simpan */
                    .btn-success {
                        background-color: #229954;
                        color: #FCDEC0;
                        border: 1px solid #145A32;
                    }

                    .btn-success:hover {
                        background-color: #145A32;
                        color: #FCDEC0;
                    }

                    /* Tombol close */
                    .btn-secondary {
                        background-color: #E5B299;
                        color: #7D5A50;
                        border: 1px solid #B4846C;
                    }

                    .btn-secondary:hover {
                        background-color: #B4846C;
                        color: #FCDEC0;
                    }
        </style>

</body>

</html>
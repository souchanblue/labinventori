<?php
session_start(); // Pastikan ini di baris pertama
include '../dbconnect.php';
include 'cek.php';
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon"
        type="image/png"
        href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Notes</title>
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
                color:rgb(255, 255, 255);
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

                <!-- Input file yang tersembunyi -->
                <input type="file" id="file-input" accept="image/*" style="display: none;">

            </div>
            <script>
                document.getElementById('change-photo').addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah reload halaman
                    document.getElementById('file-input').click(); // Buka input file
                });

                document.getElementById('file-input').addEventListener('change', function(e) {
                    const file = e.target.files[0]; // Ambil file yang dipilih
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Tampilkan preview gambar
                            document.getElementById('profile-photo').src = event.target.result;

                            // Kirim file ke server pakai fetch
                            const formData = new FormData();
                            formData.append('foto', file);

                            fetch('upload_foto.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success && data.redirect) {
                                        window.location.href = data.redirect; // Pindah ke halaman sukses
                                    } else {
                                        alert('Gagal mengupload foto.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        };
                        reader.readAsDataURL(file); // Baca file sebagai URL
                    }
                });
            </script>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="index.php"><i class="ti-book"></i><span>Notes </span></a>
                            </li>
                            <li>
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

        <!-- Sidebar sudah disesuaikan, warna lebih kalem dan icon lebih jelas! 🚀 Kalau ada yang mau disempurnakan, kasih tahu aja ya! -->

        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
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

            <!-- Header sekarang lebih kontras dan tetap vintage! Kalau ada yang mau diubah lagi, tinggal bilang ya! ✨ -->
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
            <div class="chat-container" style="padding: 20px; background: #EAEAEA;">
                <?php
                $queri = "SELECT * FROM notes WHERE status='aktif' ORDER BY tanggal_notes ASC";
                $hasil = MySQLi_query($conn, $queri);

                $lastDate = null;
                while ($data = mysqli_fetch_array($hasil)) {
                    $isCurrentUser = ($_SESSION['user'] == $data['admin']);
                    $bubbleClass = $isCurrentUser ? 'chat-bubble-right' : 'chat-bubble-left';
                    $bubbleColor = $isCurrentUser ? '#E3D2C3' : '#EAD8B1';
                    $align = $isCurrentUser ? 'flex-end' : 'flex-start';
                    $tanggal = date('d M Y', strtotime($data['tanggal_notes']));
                    $waktu = date('H:i', timestamp: strtotime($data['tanggal_notes']));

                    if ($tanggal !== $lastDate) {
                        echo "<div class='chat-date-bubble'><span>$tanggal</span></div>";
                        $lastDate = $tanggal;
                    }
                ?>
                    <div class="chat-bubble <?php echo $bubbleClass; ?>" style="background: <?php echo $bubbleColor; ?>; align-self: <?php echo $align; ?>;">
                        <div class="chat-content">
                            <span class="chat-author">
                                <?php echo $data['admin']; ?>
                            </span>
                            <p class="chat-text">
                                <?php echo $data['contents']; ?>
                            </p>
                            <span class="chat-time">
                                <?php echo $waktu; ?>
                            </span>
                        </div>
                    </div>
                <?php } ?>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <form method='POST' action='notes.php' class="chat-input" style="position: sticky; bottom: 0; width: 100%; padding: 10px; background: transparent;">
                    <div class="chat-bubble chat-bubble-input" style="width: 100%; display: flex; gap: 10px; align-items: center;">
                        <textarea name='konten' class='form-control chat-textarea' placeholder='Tulis catatan...' required style="flex: 1; background: transparent; border: 1px solid #66D2CE; border-radius: 10px; padding: 10px; color:rgb(0, 0, 0);"></textarea>
                        <button type='submit' name='submit' class='btn btn-primary chat-send' style="background: #2DAA9E; border-color: #66D2CE; border-radius: 20px; padding: 10px 20px; font-weight: bold;">Kirim</button>
                    </div>
                </form>
            </div>

            <style>
                body {
                    background: #EAEAEA;

                }

                .chat-container {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    position: relative;
                    padding-bottom: 80px;
                    /* Memberikan ruang untuk form input */
                }

                .chat-date-bubble {
                    align-self: center;
                    background: #2DAA9E;
                    color: rgb(255, 255, 255);
                    padding: 5px 10px;
                    border-radius: 20px;
                    font-weight: bold;
                }

                .chat-bubble {
                    max-width: 100%;
                    padding: 10px;
                    border-radius: 20px;
                    word-wrap: break-word;
                    /* Memaksa kata panjang untuk pecah */
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                .chat-bubble-left {
                    align-self: flex-start;
                }

                .chat-bubble-right {
                    align-self: flex-end;
                    background: #4F959D;
                }

                .chat-bubble-input {
                    align-self: flex-end;
                    background: rgb(255, 255, 255);
                }

                .chat-author {
                    font-weight: bold;
                }

                .chat-text {
                    margin: 5px 0 0;
                }

                .chat-time {
                    font-size: 12px;
                    color:rgb(0, 0, 0);
                    text-align: right;
                    display: block;
                }

                .chat-input {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end;
                    gap: 10px;
                    position: sticky;
                    bottom: 0;
                    width: 100%;
                    background: #EAEAEA;
                    padding: 10px;
                    box-sizing: border-box;
                }

                .chat-textarea {
                    width: 100%;
                    min-height: 60px;
                    resize: none;
                    border: 1px solid #E3D2C3;
                    border-radius: 10px;
                    padding: 10px;
                    background: transparent;
                    color: #4F959D;
                }

                .chat-send {
                    align-self: flex-end;
                    margin-top: 10px;
                    background: #4F959D;
                    border-color: #7D5A50;
                    border-radius: 20px;
                    padding: 10px 20px;
                    font-weight: bold;
                }
            </style>
        </div>
    </div>
    <!-- page container area end -->

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

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
</body>

</html>
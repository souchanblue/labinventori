<!DOCTYPE html>
<html>
<head>
    <title>Upload Berhasil</title>
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
        .success-container {
            text-align: center;
        }
        .success-container img {
            width: 300px;
            height: auto;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php'; // Balik ke halaman utama
        }, 500); // Tunggu 1.5 detik
    </script>
</head>
<body>
    <div class="success-container">
        <img src="../stock/assets/images/kucing.gif" alt="Success Icon">
    </div>
</body>
</html>

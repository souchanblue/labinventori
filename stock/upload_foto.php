<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $uploadDir = 'uploads/'; 
    $fileName = time() . '_' . basename($_FILES['foto']['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
        $_SESSION['foto'] = $targetFilePath; // Simpan path ke session
        
        // Redirect ke halaman sukses
        echo json_encode(['success' => true, 'redirect' => 'success.php']);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>

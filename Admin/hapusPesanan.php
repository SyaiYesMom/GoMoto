<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $idPembeli = $_GET['id'];

    // Ambil data produk dari pesanan yang akan dihapus
    $query = "SELECT PRODUCT_NAME FROM PEMBELI WHERE ID_PEMBELI = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPembeli);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $productName = $row['PRODUCT_NAME'];

    // Hapus pesanan dari tabel PEMBELI
    $query = "DELETE FROM PEMBELI WHERE ID_PEMBELI = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPembeli);
    $stmt->execute();

    // Update stok produk di tabel PRODUK (tanpa menambah stok)
    $query = "UPDATE PRODUK SET STOK = STOK WHERE NAMA_PRODUK = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $productName);
    $stmt->execute();

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);
?>

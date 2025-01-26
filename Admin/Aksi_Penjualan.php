<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pbd");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Validasi input dan eksekusi query
if (isset($_POST['id_pembeli'])) {
    $idPembeli = intval($_POST['id_pembeli']); // Ambil ID pembeli dari input

    // Query update
    $query = "UPDATE pembeli SET STATUS_PEMBELIAN = 'SELESAI' WHERE ID_PEMBELI = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPembeli);

    if ($stmt->execute()) {
        echo "Status pembelian berhasil diubah menjadi SELESAI.";
        header("Location: Penjualan.php");
    } else {
        echo "Gagal mengubah status pembelian: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID Pembeli tidak ditemukan atau tombol 'Ubah' tidak diklik.";
}

$conn->close();
?>

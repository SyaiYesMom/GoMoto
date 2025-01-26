<?php
// Koneksi ke database
require_once '../../config.php';

// Ambil ID_PEMBELI dari form
if (isset($_POST['id_pembeli'])) {
    $id_pembeli = $_POST['id_pembeli'];

    // Ambil PRODUCT_NAME dari tabel PEMBELI
    $query_pembeli = "SELECT PRODUCT_NAME FROM pembeli WHERE ID_PEMBELI = $id_pembeli";
    $result_pembeli = mysqli_query($conn, $query_pembeli);

    if ($result_pembeli && mysqli_num_rows($result_pembeli) > 0) {
        $row_pembeli = mysqli_fetch_assoc($result_pembeli);
        $product_name = $row_pembeli['PRODUCT_NAME'];

        // Cari ID_PRODUK berdasarkan PRODUCT_NAME di tabel PRODUK
        $query_produk = "SELECT ID_PRODUK FROM produk WHERE NAMA_PRODUK = '$product_name'";
        $result_produk = mysqli_query($conn, $query_produk);

        if ($result_produk && mysqli_num_rows($result_produk) > 0) {
            $row_produk = mysqli_fetch_assoc($result_produk);
            $id_produk = $row_produk['ID_PRODUK'];

            // Update STOK di tabel PRODUK (+1)
            $update_stok = "UPDATE produk SET STOK = STOK + 1 WHERE ID_PRODUK = $id_produk";
            if (mysqli_query($conn, $update_stok)) {
                // Hapus data pembeli dari tabel PEMBELI
                $delete_pembeli = "DELETE FROM pembeli WHERE ID_PEMBELI = $id_pembeli";
                if (mysqli_query($conn, $delete_pembeli)) {
                    // Redirect kembali ke nota.php setelah berhasil menghapus dan update stok
                    header("Location: nota.php");
                    exit();
                } else {
                    echo "Error: Gagal menghapus data pembeli. " . mysqli_error($conn);
                }
            } else {
                echo "Error: Gagal update stok produk. " . mysqli_error($conn);
            }
        } else {
            echo "Error: Produk tidak ditemukan. " . mysqli_error($conn);
        }
    } else {
        echo "Error: Data pembeli tidak ditemukan. " . mysqli_error($conn);
    }
} else {
    echo "Error: ID_PEMBELI tidak ditemukan.";
}

// Tutup koneksi
mysqli_close($conn);
?>

<?php
// Atur header HTTP agar browser langsung mencetak halaman
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="nota_pembelian.pdf"');

// Tambahkan kode untuk mencetak halaman
echo '<script>window.print();</script>';

// Tambahkan kode untuk menampilkan halaman
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Nota Pembelian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body class="bg-gray-100 font-Inter">
    <!-- Header -->
    <header></header>
    <!-- Main Content -->
    <main>
    <section class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-2xl mt-0 font-bold mb-0">Pesanan Anda</h1>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nama Produk</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Alamat</th>
                        <th class="px-4 py-2">Provinsi</th>
                        <th class="px-4 py-2">Kota</th>
                        <th class="px-4 py-2">Kode Pos</th>
                        <th class="px-4 py-2">No. Telepon </th>
                        <th class="px-4 py-2">Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Koneksi ke database
                    require_once '../../config.php';

                    // Ambil data pembeli dari database
                    $pembeli = mysqli_query($conn, "SELECT * FROM pembeli");

                    // Tampilkan data pembeli
                    if (mysqli_num_rows($pembeli) > 0) {
                        while ($row = mysqli_fetch_assoc($pembeli)) {
                            echo "<tr class='bg-gray-50 hover:bg-gray-100'>";
                            echo "<td class='px-4 py-2'>" . $row['PRODUCT_NAME'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['NAMA'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['JALAN'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['PROVINSI'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['KOTA'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['KODE_POS'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['NO_TELEPON'] . "</td>";
                            echo "<td class='px-4 py-2'>Rp. " . number_format($row['GRANDTOTAL'], 0, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </section>
    </main>
</body>
</html>

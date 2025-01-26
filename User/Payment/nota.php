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
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }
    table th, table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        color:rgb(0, 0, 0); /* Warna teks diubah menjadi hitam */
    }
    table th {
        background-color: #e9d8fd;
        color: white; /* Warna teks header tetap putih */
    }
    table tr {
        background-color:#f2f2f2;
    }
    table tr:hover {
        background-color: #ddd;
    }
    </style>
</head>
<body class="bg-gray-100 font-Inter">
    <!-- Header -->
    <header class="header bg-purple-200">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center space-x-4">
                <a href="../Index_After_Login.php">
                    <img alt="Naked motorcycle" src="..\..\Source\ICON\LOGO.png" width="250" height="60"/>
                </a>
            </div>
            <div class="relative w-1/2">
                <form action="..\Search_After_Login.php" method="GET"> 
                    <input 
                        class="w-full py-2 pl-10 pr-4 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600" 
                        placeholder="Sport, Matic, Trail, Underbone" 
                        type="text" 
                        name="query" 
                    />
                    <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i> 
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
    <section class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-2xl mt-0 font-bold mb-0">Pesanan Anda</h1>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-purple-200 text-black">Nama Produk</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Nama</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Alamat</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Provinsi</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Kota</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Total Pembayaran</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Status</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Edit Pesanan</th>
                        <th class="px-4 py-2 bg-purple-200 text-black">Detail Pesanan</th>
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
                            echo "<td class='px-4 py-2'>Rp. " . number_format($row['GRANDTOTAL'], 0, ',', '.') . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['STATUS_PEMBELIAN'] . "</td>";
                            echo "<td class='px-4 py-2'>";
                            echo "<form action='delete_pembeli.php' method='POST' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\");'>";
                            echo "<input type='hidden' name='id_pembeli' value='" . $row['ID_PEMBELI'] . "'>";
                            echo "<button type='submit' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700'>";
                            echo "<i class='fas fa-trash'></i> Hapus Pesanan";
                            echo "</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "<td class='px-4 py-2'>";
                            echo "<a href='detail.php' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'>Print Nota</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='px-4 py-2 text-center'>Anda belum membeli barang apapun. Ayo beli sekarang!.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
        <section class="bg-purple-100 py-12">
            <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-2"></h2>
                    <h2 class="text-2xl font-bold mb-4">Beli Sekarang & Dapatkan harga Menarik!</h2>
                    <p class="mb-4">Kami menjual motor dengan berbagai pilihan model dan tipe, siap memenuhi kebutuhan berkendara Anda. Dapatkan motor impian Anda sekarang juga, dengan harga terbaik dan kualitas terjamin.</p>
                    <h3 class="text-xl font-bold mb-2"><br><br><br><br><br>JUAL Motor Solo</h3>
                    <p>Beli Sekarang & Dapatkan harga Menarik!</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2">Kontak Kami</h3>
                    <p>Alamat: Jl. Bhayangkara No.55, Tipes, Kec. Serengan, Kota Surakarta, Jawa Tengah 57154</p>
                    <a href="https://maps.app.goo.gl/Ka9n1rTQhA5M5atg7" target="_blank">
                        <img alt="Map showing the location of the store" class="w-full h-64 object-cover mt-4" src="..\..\Source\INDEX\maps.png"/>
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

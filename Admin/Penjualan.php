<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
   
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
        background-color: #4CAF50;
        color: white; /* Warna teks header tetap putih */
    }
    table tr {
        background-color:#f2f2f2;
    }
    table tr:hover {
        background-color: #ddd;
    }
    .notification {
        display: none;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 1000;
    }
</style>
</head>
<body class="bg-gray-900 text-white">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-20 bg-gray-800 flex flex-col items-center py-4">
            <img 
                src="..\Source\ICON\LOGOADMIN.png" 
                alt="Logo" 
                class="w-12 h-12 mb-4" 
                width="50" 
                height="50" 
            />
            <div class="text-red-500 text-2xl font-bold">
                <div class="mb-2">G</div>
                <div class="mb-2">o</div>
                <div class="mb-2">M</div>
                <div class="mb-2">o</div>
                <div class="mb-2">t</div>
                <div class="mb-2">o</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
                <div class="flex space-x-2">
                    <a href="Admin.php">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">LogOut</button>
                    </a>
                    <a href="Admin_Dashboard.php">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Kembali</button>
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                <div class="notification" id="notification">
                    Pesanan telah disetujui!
                </div>
                <?php
                // Koneksi ke database
                require_once '../config.php';

                // Ambil data pembeli dari database
                $pembeli = mysqli_query($conn, "SELECT * FROM pembeli");

                // Tampilkan data pembeli
                if (mysqli_num_rows($pembeli) > 0) {
                    echo "<div class='space-y-4 not-prose'>";
                    echo "<table border='1'>";
                    echo "<tr>";
                    echo "<th>Nama Produk</th>";
                    echo "<th>Nama Pembeli</th>";
                    echo "<th>Jalan Pembeli</th>";
                    echo "<th>Provinsi Pembeli</th>";
                    echo "<th>Kota Pembeli</th>";
                    echo "<th>Kodepos Pembeli</th>";
                    echo "<th>No. Telepon Pembeli</th>";
                    echo "<th>Total Pembayaran</th>";
                    echo "<th>Setujui Pesanan</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($pembeli)) {
                        $ID_PEMBELI = $row['ID_PEMBELI'];
                        echo "<tr>";
                        echo "<td>" . $row['PRODUCT_NAME'] . "</td>";
                        echo "<td>" . $row['NAMA'] . "</td>";
                        echo "<td>" . $row['JALAN'] . "</td>";
                        echo "<td>" . $row['PROVINSI'] . "</td>";
                        echo "<td>" . $row['KOTA'] . "</td>";
                        echo "<td>" . $row['KODE_POS'] . "</td>";
                        echo "<td>" . $row['NO_TELEPON'] . "</td>";
                        echo "<td class='px-4 py-2'>Rp. " . number_format($row['GRANDTOTAL'], 0, ',', '.') . "</td>";
                        echo "<td class='px-4 py-2'><form action='Aksi_Penjualan.php' method='POST' class='inline' onsubmit='showNotification()'>"; // Added onsubmit event
                        echo "<input type='hidden' name='id_pembeli' value='$ID_PEMBELI'>";
                        echo "<button type='submit' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'>
                                <i class='fas fa-edit'></i> Ubah
                            </button>";
                        echo "</form></td></tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "Tidak ada data pembeli";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function showNotification() {
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 1000); // Hide notification after 10 seconds
        }
    </script>
</body>
</html>

<?php
session_start(); // Mulai session

// Ambil nilai grandtotal
$grandtotal = isset($_SESSION['grandtotal']) ? $_SESSION['grandtotal'] : '0';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Motorcycle Prices</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"/>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Timer countdown
            const countdownElement = document.getElementById('countdown');
            let timeRemaining = 600; // 10 minutes in seconds

            function updateTimer() {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (timeRemaining > 0) {
                    timeRemaining--;
                } else {
                    clearInterval(timerInterval);
                    countdownElement.textContent = "Waktu habis!";
                }
            }

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
        });
    </script>
</head>
<body class="bg-gray-100 font-Inter">
    <!-- Header -->
    <header class="header bg-purple-200">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center space-x-4">
                <a href="../Index_After_Login.php">
                    <img alt="Naked motorcycle" src="..\..\Source\ICON\LOGO.png" width="183.75" height="40"/>
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
        <!-- Payment Summary Section -->
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Payment</h1>
            <div class="space-y-4">
                <div class="mb-4">
                    <div class="mb-2">
                        <span class="text-gray-600">No. Rekening:</span>
                        <span class="text-red-500 font-bold">999 123456789 </span>
                    </div>
                    <div class="text-green-600 text-sm mb-2">
                        Proses verifikasi kurang dari <span id="countdown">10:00</span> setelah pembayaran berhasil
                    </div>
                    <div class="text-red    -600 text-sm mb-2">
                        Pesanan tidak bisa dibatalkan ketika sudah dibayar
                    </div>
                    <div class="text-gray-600 text-sm mb-2">
                        Bayar pesanan ke Virtual Account di atas sebelum membuat pesanan kembali dengan Virtual Account agar nomor tetap sama.
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between items-center cursor-pointer">
                        <span class="text-gray-600 font-bold">Petunjuk Transfer mBanking</span>
                    </div>
                    <div class="mt-2 text-gray-600 text-sm">
                        <ol class="list-decimal pl-5">
                            <li>Login ke mBanking-mu. Pilih <span class="font-bold">Bayar</span>, kemudian pilih <span class="font-bold">e-Commerce</span>.</li>
                            <li>Pilih <span class="font-bold">Penyedia Layanan: GoMoto Indonesia</span>, dan masukkan nomor Virtual Account <span class="font-bold">999 123456789</span>, kemudian pilih <span class="font-bold">Lanjut</span>.</li>
                            <li>Periksa informasi yang tertera di layar. Pastikan Merchant adalah <span class="font-bold">GoMoto Indonesia</span>. Masukkan PIN Anda dan pilih <span class="font-bold">OK</span>.</li>
                        </ol>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class ="text-gray-700 font-bold">Total Pembayaran</span>
                    <span class="text-red-500 font-bold">Rp <?php echo number_format($grandtotal, 0, ',', '.'); ?></span>
                </div>
                <div class="w-full flex justify-center">
                    <a href="nota.php">
                        <button class="bg-red-300 font-bold py-2 px-4 rounded-[10px] border border-purple-600 focus:outline-none focus:ring-2 focus:ring-black mt-6" onclick="showNotification()">
                            Ok
                        </button>
                    </a>
                </div>
                <div class="notification" id="notification" style="display:none;">
                    Pembayaran berhasil! 
                    <button onclick="hideNotification()" class="bg-white text-black px-2 py-1 rounded">OK</button>
                </div>
            </div>
        </section>
        <section class="bg-purple-100 py-12">
            <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
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

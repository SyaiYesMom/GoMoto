<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Motorcycle Prices</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
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
    <main>
        <section class="relative">
            <img alt="Motorcycle in a tunnel" class="w-full h-96 object-cover" src="..\..\Source\INDEX\INDEX3.jpg"/>
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <h1 class="text-white text-4xl font-bold">Cek Harga Motor Favoritmu Sekarang!</h1>
            </div>
        </section>
        <section class="container mx-auto py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                require_once '..\..\config.php'; // Include database connection

                // Product names to search
                $product_names = ['Honda Vario 125', 'Honda Scoopy', 'Honda Beat', 'Honda PCX160'];

                foreach ($product_names as $product_name) {
                    // Prepare statement to prevent SQL injection
                    $stmt = $conn->prepare("SELECT NAMA_PRODUK, DESKRIPSI FROM PRODUK WHERE NAMA_PRODUK = ?");
                    $stmt->bind_param("s", $product_name);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<a href='CO_" . str_replace(' ', '_', htmlspecialchars($row['NAMA_PRODUK'])) . "_After_Login.php' class='block' style='width: 233.8px; height: 512px>";
                            echo "<article class='card'>";
                            echo "<img src='..\..\Source\INDEX\\" . $row['NAMA_PRODUK'] . ".png' alt='Gambar " . htmlspecialchars($row['NAMA_PRODUK']) . "' class='w-full h-48 object-cover'/>";
                            echo "<h2 class='text-lg font-semibold'><br><b>" . htmlspecialchars($row['NAMA_PRODUK']) . "</b></h2>";
                            echo "<p class='text-gray-600'>" . htmlspecialchars($row['DESKRIPSI']) . "</p>";
                            echo "</article>";
                        }
                    } else {
                        echo "<p class='text-red-500'>Produk " . htmlspecialchars($product_name) . " tidak ditemukan.</p>";
                    }
                    $stmt->close();
                }
                $conn->close();
                ?>
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

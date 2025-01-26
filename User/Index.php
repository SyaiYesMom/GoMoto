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
                <a href="Login.php">
                    <button class="bg-red-300 text-black-700 px-4 py-2 rounded-[10px] border border-white focus:ring-2 focus:ring-purple-600">Login</button>
                </a>
                <a href="Register.php">
                    <button class="bg-white text-black-700 px-4 py-2 rounded-[10px] border border-red-300 focus:ring-2 focus:ring-purple-600">Register</button>
                </a>
            </div>
            <div class="relative w-1/2">
                <form action="Search_Before_Login.php" method="GET"> 
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
            <img alt="Motorcycle in a tunnel" class="w-full h-96 object-cover" src="..\Source\INDEX\INDEX1.png"/>
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <h1 class="text-white text-4xl font-bold">Cek Harga Motor Favoritmu Sekarang!</h1>
            </div>
        </section>
        <section class="container mx-auto py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="Product\Naked_Before_Login.php" class="block" style="width: 233.8px; height: 512px;">
                    <img alt="Naked motorcycle" src="..\Source\INDEX\NAKED_INDEX.png"/>
                    <h2><b>NAKED</b></h2>
                    <p>Rasakan performa bertenaga, desain aerodinamis, dan fitur canggih dari motor Naked terbaik. Temukan model impian Anda dari merek ternama seperti Yamaha, Honda ```html
                    , dan Suzuki. Berkendara penuh aksi dimulai di sini!</p>
                </a>
                <a href="Product\Trail_Before_Login.php" class="block" style="width: 233.8px; height: 512px;">
                    <img alt="Trail motorcycle" src="..\Source\INDEX\TRAIL_INDEX.png"/>
                    <h2><b>TRAIL</b></h2>
                    <p>Jelajahi berbagai medan dengan motor trail yang dirancang untuk petualangan. Dengan suspensi kokoh, mesin bertenaga, dan desain tangguh, motor trail siap menemani aksi off-road Anda. Taklukkan alam bersama motor trail terbaik!</p>
                </a>
                <a href="Product\Scoopy_Before_Login.php" class="block" style="width: 233.8px; height: 512px;">
                    <img alt="Scoopy motorcycle" src="..\Source\INDEX\SCOOPY_INDEX.png"/>
                    <h2><br><br><b>SCOOPY</b></h2>
                    <p>Nikmati kemudahan berkendara dengan motor matic yang stylish dan efisien. Dengan fitur modern, ruang penyimpanan luas, dan konsumsi bahan bakar irit, motor matic adalah pilihan sempurna untuk mobilitas harian Anda. Berkendara jadi lebih mudah dan menyenangkan!</p>
                </a>
                <a href="Product\Underbone_Before_Login.php" class="block" style="width: 233.8px; height: 512px;">
                    <img alt="Underbone motorcycle" src="..\Source\INDEX\UNDERBONE_INDEX.png"/>
                    <h2><b>UNDERBONE</b></h2>
                    <p>Rasakan sensasi berkendara yang lincah dengan motor underbone. Dibalut mesin bertenaga, handling yang ringan, dan desain stylish, motor ini cocok untuk mobilitas cepat di perkotaan. Pilihan tepat untuk kepraktisan dan gaya!</p>
                </a>
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
                        <img alt="Map showing the location of the store" class="w-full h-64 object-cover mt-4 px-4" src="..\Source\INDEX\maps.png"/>
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

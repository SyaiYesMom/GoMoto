<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoMoto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
    rel="stylesheet" 
  />
  <style>
    /* Animasi Gambar */
    .animated-img {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .animated-img:hover {
      transform: scale(1.1); /* Perbesar */
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>
<body class="Body">

  <?php
  include '../../config.php'; // Include the database connection

  // Fetch product details
  $productName = 'Yamaha Trail WR 155'; // Specify the product name
  $sql = "SELECT NAMA_PRODUK, HARGA, STOK, DESKRIPSI FROM PRODUK WHERE NAMA_PRODUK = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $productName);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();
  ?>

  <!-- Header -->
  <header class="header bg-purple-200">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-4">
        <a href="..\Login.php">
          <button class="bg-red-300 text-black-700 px-4 py-2 rounded-[10px] border border-white focus:ring-2 focus:ring-purple-600">Login</button>
        </a>
        <a href="..\Register.php">
          <button class="bg-white text-black-700 px-4 py-2 rounded-[10px] border border-red-300 focus:ring-2 focus:ring-purple-600">Register</button>
        </a>
      </div>
      <div class="relative w-1/2">
        <form action="..\Search_Before_Login.php" method="GET"> 
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
  <main class="flex flex-col items-center mt-8">
    <div style="width: 1400px; height: 728px;" class="text-center">
      
      <!-- Back Icon and Title Container -->
      <div class="container mx-auto flex items-left py-0 px-4" style="width: 1400px; height: 32px;">
        <div class="mr-16">
            <a href="Trail_Before_Login.php">
                <i class="fas fa-chevron-left text-xl"></i>
            </a>
        </div>
        <div class="flew-grow text-center ml-26" style="width: 1200px; height: 32px;">
            <h2 class="text-2xl font-bold"><?php echo $product['NAMA_PRODUK']; ?></h2>
        </div>
      </div>

      <!-- Motorcycle Image -->
      <img 
        src="..\..\Source\INDEX\PRODUCT\Trail\CO\<?php echo $product['NAMA_PRODUK']; ?>.jpg" 
        alt="Trail" 
        class="my-8 mx-auto rounded-[10px] animated-img" 
        width="400" 
        height="300" 
        id="motorcycleImage"
      />

      <!-- Description -->
      <div class="text-left px-4">
        <h3 class="text-xl font-bold"><?php echo $product['NAMA_PRODUK']; ?></h3>
        <p class="text-blue-500 text-lg">Rp. <?php echo number_format($product['HARGA'], 0, ',', '.'); ?></p>
        <p class="text-gray-600 mt-2">Stok : <?php echo $product['STOK']; ?></p>
        <p class="text-gray-600 mt-2">
            <?php echo $product['DESKRIPSI']; ?>
        </p>
      </div>

      <!-- Buy Button -->
      <a href="..\Login.php">
        <button class="bg-red-300 font-bold py-2 px-4 rounded-[10px] border border-purple-600 focus:outline-none focus:ring-2 focus:ring-black mt-6">
            Buy Now
        </button>
      </a>
    </div>
  </main>

  <!-- JavaScript -->
  <script>
    // Tambahkan efek shake saat gambar di-klik
    const img = document.getElementById('motorcycleImage');
    img.addEventListener('click', () => {
      img.classList.add('clicked');
      // Hapus kelas 'clicked' setelah animasi selesai
      setTimeout(() => img.classList.remove('clicked'), 500);
    });
  </script>
</body>
</html>

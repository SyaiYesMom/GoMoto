<?php
session_start();
require_once '../../config.php';

// Ambil nilai productName dari session
$productName = $_SESSION['productName'];

// Jika ada request POST untuk mengurangi stok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reduce_stock'])) {
    // Kurangi stok produk
    $sql = "UPDATE PRODUK SET STOK = STOK - 1 WHERE NAMA_PRODUK = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();

    // Berikan response JSON
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Stock reduced successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to reduce stock"]);
    }
    exit; // Hentikan eksekusi script setelah memberikan response
}

// Lanjutkan dengan logika Checkout.php yang sudah ada
$ongkir = "200000";
$fee = "5000";

$sql = "SELECT NAMA_PRODUK, HARGA, STOK FROM PRODUK WHERE NAMA_PRODUK = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productName);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Calculate grandtotal only if $product is set
if ($product) {
    $grandtotal = $product['HARGA'] + $ongkir + $fee;
} else {
    // Handle the case where the product is not found
    die("Product not found.");
}

// Simpan grandtotal ke session
$_SESSION['grandtotal'] = $grandtotal;

// Jika ada request POST untuk menyimpan data pembeli
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $jalan = $_POST['jalan'];
    $provinsi = $_POST['provinsi'];
    $kota = $_POST['kota'];
    $kodePos = $_POST['kodePos'];
    $noTelepon = $_POST['noTelepon'];

    // Validasi input
    if (empty($nama) || empty($jalan) || empty($provinsi) || empty($kota) || empty($kodePos) || empty($noTelepon)) {
        echo json_encode(["status" => "error", "message" => "Semua field harus diisi!"]);
        exit;
    }

    // Simpan data pembeli ke database
    $sql = "INSERT INTO pembeli (nama, jalan, provinsi, kota, kode_pos, no_telepon, product_name, grandtotal, STATUS_PEMBELIAN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'MENUNGGU VERIFIKASI')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssd", $nama, $jalan, $provinsi, $kota, $kodePos, $noTelepon, $productName, $grandtotal);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Kurangi stok produk hanya jika data pembeli berhasil disimpan
        $sql = "UPDATE PRODUK SET STOK = STOK - 1 WHERE NAMA_PRODUK = ? AND STOK > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $productName);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Data pembeli berhasil disimpan dan stok berkurang"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal mengurangi stok atau stok habis"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan data pembeli"]);
    }
    exit;
}
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
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .header {
            padding: 20px;
            background-color: #EAB8F1;
        }
        .logo {
            width: 183.75px;
            height: 40px;
        }
        .input-error {
            color: red;
            font-size: 0.875rem;
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="header bg-purple-200">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center space-x-4">
                <img alt="Naked motorcycle" src="..\..\Source\ICON\LOGO.png" width="183.75" height="40"/>
            </div>
            <div class="relative w-1/2">
                <form action="Search_After_Login.php" method="GET"> 
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
        <!-- Billing Summary Section -->
        <section class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">CheckOut</h1>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-700"><?php echo $productName; ?></span>
                    <span class="text-gray-700 font-semibold">Rp. <?php echo number_format($product['HARGA'], 0, ',', '.'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Ongkir</span>
                    <span class="text-gray-700 font-semibold">Rp. <?php echo number_format($ongkir, 0, ',', '.'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Stok</span>
                    <span class="text-gray-700 font-semibold"><?php echo $product['STOK']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Fee</span>
                    <span class="text-gray-700 font-semibold">Rp. <?php echo number_format($fee, 0, ',', '.'); ?></span>
                </div>
                <!-- Shipping Address -->
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-700">Nama</label>
                        <input type="text" id="nama" class="w-full p-2 border rounded-lg" placeholder="Masukkan Nama Anda" onkeypress="return isLetter(event)">
                        <span id="inputErrorNama" class="input-error">Hanya huruf yang diperbolehkan!</span>
                    </div>
                    <div>
                        <label class="text-gray-700">Jalan</label>
                        <input type="text" id="jalan" class="w-full p-2 border rounded-lg" placeholder="Masukkan Nama Jalan">
                        <span id="jalanError" class="input-error">Kolom wajib di isi</span>
                    </div>
                    <div>
                        <label class="text-gray-700">Provinsi</label>
                        <input type="text" id="provinsi" class="w-full p-2 border rounded-lg" placeholder="Masukkan Provinsi" onkeypress="return isLetter(event)">
                        <span id="inputErrorProvinsi" class="input-error">Hanya huruf yang diperbolehkan!</span>
                    </div>
                    <div>
                        <label class="text-gray-700">Kota</label>
                        <input type="text" id="kota" class="w-full p-2 border rounded-lg" placeholder="Masukkan Kota" onkeypress="return isLetter(event)">
                        <span id="inputErrorKota" class="input-error">Hanya huruf yang diperbolehkan!</span>
                    </div>
                    <div>
                        <label class="text-gray-700">Kode Pos</label>
                        <input type="text" id="kodePos" class="w-full p-2 border rounded-lg" placeholder="Masukkan Kode Pos" onkeypress="return isNumber(event)">
                        <span id="inputErrorKodePos" class="input-error">Hanya angka yang diperbolehkan!</span>
                    </div>
                    <div>
                        <label class="text-gray-700">No Telepon</label>
                        <input type="text" id="noTelepon" class="w-full p-2 border rounded-lg" placeholder="Masukkan No Telepon" onkeypress="return isNumber(event)">
                        <span id="inputErrorNoTelepon" class="input-error">Hanya angka yang diperbolehkan!</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-900 font-bold">Total Pembayaran</span>
                        <span class="text-gray-900 font-bold">Rp. <?php echo number_format($grandtotal, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center">
                    <input id="agreeCheckbox" type="checkbox" class="form-checkbox h-4 w-4 text-blue-600"/>
                    <label class="text-gray-700 ml-2" for="agreeCheckbox">I agree to the <span class="text-blue-600">Privacy Policy</span> and Terms of Service</label>
                </div>
                <button id="buyNowButton" onclick="handleBuyNow()" class="bg-red-300 font-bold py-2 px-4 rounded-[10px] border border-purple-600 focus:outline-none focus:ring-2 focus:ring-black mt-6">
                    Buy Now
                </button>
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

    <script>
    function validateInputs() {
        let isValid = true;
        const inputs = [
            { id: 'nama', errorId: 'namaError' },
            { id: 'jalan', errorId: 'jalanError' },
            { id: 'provinsi', errorId: 'provinsiError' },
            { id: 'kota', errorId: 'kotaError' },
            { id: 'kodePos', errorId: 'kodePosError' },
            { id: 'noTelepon', errorId: 'noTeleponError' }
        ];

        inputs.forEach(input => {
            const inputElement = document.getElementById(input.id);
            const errorElement = document.getElementById(input.errorId);
            if (inputElement.value.trim() === '') {
                errorElement.classList.remove('hidden');
                isValid = false;
            } else {
                errorElement.classList.add('hidden');
            }
        });

        // Validasi No Telepon dan Kode Pos harus angka
        const noTelepon = document.getElementById('noTelepon').value;
        const kodePos = document.getElementById('kodePos').value;
        if (isNaN(noTelepon) || isNaN(kodePos)) {
            alert("No Telepon dan Kode Pos harus berupa angka.");
            isValid = false;
        }

        return isValid;
    }

    function isLetter(event) {
    const char = String.fromCharCode(event.which);
    const targetId = event.target.id;
    const errorElement = document.getElementById('inputError' + targetId.charAt(0).toUpperCase() + targetId.slice(1));

    if (!/^[a-zA-Z\s]*$/.test(char)) {
        errorElement.style.display = 'block';
        return false;
    } else {
        errorElement.style.display = 'none';
    }
    return true;
}

function isNumber(event) {
    const char = String.fromCharCode(event.which);
    const targetId = event.target.id;
    const errorElement = document.getElementById('inputError' + targetId.charAt(0).toUpperCase() + targetId.slice(1));

    if (!/^[0-9]*$/.test(char)) {
        errorElement.style.display = 'block';
        return false;
    } else {
        errorElement.style.display = 'none';
    }
    return true;


    }    

    function handleBuyNow() {
        console.log("handleBuyNow function triggered");

        // Cek apakah stok produk habis
        const stok = <?php echo $product['STOK']; ?>;
        if (stok === 0) {
            alert('Stok Habis');
            return;
        }

        // Cek apakah checkbox dicentang
        if (!document.getElementById('agreeCheckbox').checked) {
            console.log("Checkbox not checked");
            alert('Anda harus mencentang kotak persetujuan terlebih dahulu.');
            return;
        }

        // Ambil data dari form
        const nama = document.getElementById('nama').value;
        const jalan = document.getElementById('jalan').value;
        const provinsi = document.getElementById('provinsi').value;
        const kota = document.getElementById('kota').value;
        const kodePos = document.getElementById('kodePos').value;
        const noTelepon = document.getElementById('noTelepon').value;

        // Cek apakah semua kolom sudah diisi
        if (!nama || !jalan || !provinsi || !kota || !kodePos || !noTelepon) {
            alert('Semua field harus diisi!');
            return;
        }

        // Ubah teks tombol menjadi "Processing..."
        const buyNowButton = document.getElementById('buyNowButton');
        buyNowButton.innerText = "Processing...";
        buyNowButton.disabled = true; // Nonaktifkan tombol

        // Kirim permintaan AJAX untuk menyimpan data pembeli
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Checkout.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                // Kembalikan tombol ke keadaan semula
                buyNowButton.innerText = "Buy Now";
                buyNowButton.disabled = false;

                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        window.location.href = "../Payment/payment.php";
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert("Terjadi kesalahan saat menyimpan data pembeli. Silakan coba lagi.");
                }
            }
        };

        // Kirim data pembeli ke server
        xhr.send(`nama=${encodeURIComponent(nama)}&jalan=${encodeURIComponent(jalan)}&provinsi=${encodeURIComponent(provinsi)}&kota=${encodeURIComponent(kota)}&kodePos=${encodeURIComponent(kodePos)}&noTelepon=${encodeURIComponent(noTelepon)}`);
    }
    </script>
</body>
</html>

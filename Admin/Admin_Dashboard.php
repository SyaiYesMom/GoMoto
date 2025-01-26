<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script>
function showInput(fieldType, currentValue, productName) {
    // Format currentValue if it's a price (HARGA)
    let formattedValue = currentValue;
    if (fieldType === 'HARGA') {
        formattedValue = new Intl.NumberFormat('id-ID', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(currentValue);
    }

    const newValue = prompt(`Edit ${fieldType} for ${productName}:`, formattedValue);
    if (newValue !== null) {
        // Remove formatting (e.g., commas) before submitting
        const unformattedValue = newValue.replace(/[^0-9]/g, '');

        // Send the new value to the server via AJAX or form submission
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = window.location.href;

        const fieldTypeInput = document.createElement('input');
        fieldTypeInput.type = 'hidden';
        fieldTypeInput.name = 'fieldType';
        fieldTypeInput.value = fieldType;

        const newValueInput = document.createElement('input');
        newValueInput.type = 'hidden';
        newValueInput.name = 'newValue';
        newValueInput.value = unformattedValue;

        const productNameInput = document.createElement('input');
        productNameInput.type = 'hidden';
        productNameInput.name = 'productName';
        productNameInput.value = productName;

        form.appendChild(fieldTypeInput);
        form.appendChild(newValueInput);
        form.appendChild(productNameInput);
        document.body.appendChild(form);
        form.submit();
    }
}
    </script>
</head>
<body class="bg-gray-900 text-white">

<?php
include '..\config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fieldType = $_POST['fieldType'];
    $newValue = $_POST['newValue'];
    $productName = $_POST['productName'];

    // Validasi input
    if (empty($fieldType) || empty($newValue) || empty($productName)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE PRODUK SET $fieldType = ? WHERE NAMA_PRODUK = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $newValue, $productName);
            if ($stmt->execute()) {
                echo "<script>alert('Record updated successfully');</script>";
            } else {
                echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        }
    }
}
$conn->close();
?>

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
                    <a href="Penjualan.php">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Penjualan</button>
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                <!-- List of items -->
                <?php
                include '..\config.php'; // Include your database connection

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $fieldType = $_POST['fieldType'];
                    $newValue = $_POST['newValue'];
                    $productName = $_POST['productName'];

                    // Validasi input
                    if (empty($fieldType) || empty($newValue) || empty($productName)) {
                        echo "<script>alert('Semua field harus diisi.');</script>";
                    } else {
                        // Prepare the SQL statement
                        $stmt = $conn->prepare("UPDATE PRODUK SET $fieldType = ? WHERE NAMA_PRODUK = ?");
                        if ($stmt) {
                            $stmt->bind_param("ss", $newValue, $productName);
                            if ($stmt->execute()) {
                                echo "<script>alert('Record updated successfully');</script>";
                            } else {
                                echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
                            }
                            $stmt->close();
                        } else {
                            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
                        }
                    }
                }

                // Fetch and display products
                $products = [
                    "Honda Vario 125",
                    "Honda Scoopy",
                    "Honda Beat",
                    "Honda PCX160",
                    "Yamaha MT-15",
                    "Honda CB150R",
                    "Suzuki GSX-S150",
                    "Yamaha Vixion R",
                    "Viar New Cross X 150",
                    "Gazgas Raptor 100",
                    "Kawasaki KLX 230",
                    "Yamaha Trail WR 155",
                    "Yamaha Vega Force",
                    "Suzuki Smash FI",
                    "Honda Supra X",
                    "Yamaha Jupiter Z1"
                ];

                foreach ($products as $product) {
                    // Fetch current values from the database for each product
                    $stmt = $conn->prepare("SELECT * FROM PRODUK WHERE NAMA_PRODUK = ?");
                    $stmt->bind_param("s", $product);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $data = $result->fetch_assoc();

                    // Check if data is null
                    if ($data === null) {
                        echo "<div class='bg-gray-800 p-4 rounded-lg'>Product not found: $product</div>";
                        continue; // Skip to the next product
                    }

                    echo "<div class='bg-gray-800 p-4 rounded-lg flex justify-between items-center'>";
                    echo "<div class='flex flex-col'>";
                    echo "<span class='font-bold'>{$data['NAMA_PRODUK']}</span>";
                    echo "<span>Harga : " . number_format($data['HARGA'], 0, ',', '.') . "</span>";
                    echo "<span>Stok : {$data['STOK']}</span>";
                    echo "</div>";
                    echo "<div class='flex space-x-2'>"; // Membungkus tombol dalam div dengan flex dan space-x-2
                    echo "<button class='bg-yellow-500 text-white px-2 py-1 rounded' onclick=\"showInput('HARGA', '{$data['HARGA']}', '{$data['NAMA_PRODUK']}')\">Edit Harga</button>";
                    echo "<button class='bg-yellow-500 text-white px-2 py-1 rounded' onclick=\"showInput('STOK', '{$data['STOK']}', '{$data['NAMA_PRODUK']}')\">Edit Stok</button>";
                    echo "</div>"; // Menutup div
                    echo "</div>"; // Menutup div utama
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
  />
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-8">
    <div class="w-64 h-64">
      <img 
        src="..\Source\ICON\IMG.png" 
        alt="Illustration of a person standing next to a large mobile phone with a login form on the screen" 
        class="w-full h-full object-cover" 
        width="256" 
        height="256" 
      />
    </div>

    <div class="bg-gray-200 p-8 rounded-lg shadow-md w-80">
      <form class="space-y-6" method="POST" action="">
        <div class="flex items-center border-b border-gray-300 py-2">
          <i class="fas fa-user text-gray-500 mr-3"></i>
          <input 
            type="text" 
            name="username" 
            placeholder="Username" 
            class="w-full bg-transparent focus:outline-none" 
            required
          />
        </div>

        <div class="flex items-center border-b border-gray-300 py-2">
          <i class="fas fa-lock text-gray-500 mr-3"></i>
          <input 
            type="password" 
            name="password" 
            placeholder="Password" 
            class="w-full bg-transparent focus:outline-none" 
            required
          />
          <i class="fas fa-eye text-gray-500 ml-3"></i>
        </div>

        <button 
          type="submit" 
          class="w-full bg-gray-800 text-white py-2 rounded-full">
          Login
        </button>
      </form>

      <div class="text-center mt-4">
        <a href="Admin_Register.php" class="text-gray-600">
          Belum punya akun? Daftar
        </a>
      </div>

      <?php
      include '../config.php';
      session_start(); // Memulai sesi

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $username = htmlspecialchars(trim($_POST['username']));
          $password = trim($_POST['password']);

          if (!empty($username) && !empty($password)) {
              $sql = "SELECT PASSWORD FROM ADMINS WHERE USERNAME = ?";
              $stmt = $conn->prepare($sql);
              if ($stmt) {
                  $stmt->bind_param("s", $username);
                  $stmt->execute();
                  $stmt->bind_result($hashed_password);
                  $stmt->fetch();

                  if ($hashed_password && password_verify($password, $hashed_password)) {
                      // Login berhasil
                      $_SESSION['username'] = $username; // Menyimpan username di sesi
                      header("Location: Admin_Dashboard.php");
                      exit(); // Pastikan untuk keluar setelah redirect
                  } else {
                      // Login gagal
                      echo "<p style='color: red;'>Username atau Password salah!</p>";
                  }
                  $stmt->close();
              } else {
                  echo "<p style='color: red;'>Terjadi kesalahan dalam query database.</p>";
              }
          } else {
              echo "<p style='color: red;'>Semua field harus diisi!</p>";
          }
      }
      ?>
    </div>
  </div>
</body>
</html>

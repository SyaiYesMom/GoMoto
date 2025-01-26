<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Page</title>
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
        alt="Illustration of a person standing next to a large mobile phone with a registration form on the screen" 
        class="w-full h-full object-cover" 
        width="256" 
        height="256" 
      />
    </div>

    <div class="bg-gray-200 p-8 rounded-lg shadow-md w-80">
      <form class="space-y-6" method="POST" action="">
        <!-- Input Username -->
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

        <!-- Input Email -->
        <div class="flex items-center border-b border-gray-300 py-2">
          <i class="fas fa-envelope text-gray-500 mr-3"></i>
          <input 
            type="email" 
            name="email" 
            placeholder="Email" 
            class="w-full bg-transparent focus:outline-none" 
            required
          />
        </div>

        <!-- Input Password -->
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

        <!-- Input Re-Password -->
        <div class="flex items-center border-b border-gray-300 py-2">
          <i class="fas fa-lock text-gray-500 mr-3"></i>
          <input 
            type="password" 
            name="re_password" 
            placeholder="Re-Password" 
            class="w-full bg-transparent focus:outline-none" 
            required
          />
          <i class="fas fa-eye text-gray-500 ml-3"></i>
        </div>

        <!-- Tombol Register -->
        <button 
          type="submit" 
          class="w-full bg-gray-800 text-white py-2 rounded-full">
          Register
        </button>
      </form>

      <div class="text-center mt-4">
        <a href="Login.php" class="text-gray-600">
          Sudah punya akun? Login
        </a>
      </div>

      <?php
      include '../config.php';
      session_start(); // Memulai sesi

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $username = htmlspecialchars(trim($_POST['username'] ?? ''));
          $email = htmlspecialchars(trim($_POST['email'] ?? ''));
          $password = trim($_POST['password'] ?? '');
          $re_password = trim($_POST['re_password'] ?? '');

          if (!empty($username) && !empty($email) && !empty($password) && !empty($re_password)) {
              if ($password === $re_password) {
                  // Hash password
                  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                  // Cek apakah username atau email sudah ada
                  $sql = "SELECT USERNAME FROM USERS WHERE USERNAME = ? OR EMAIL = ?";
                  $stmt = $conn->prepare($sql);
                  if ($stmt) {
                      $stmt->bind_param("ss", $username, $email);
                      $stmt->execute();
                      $stmt->store_result();

                      if ($stmt->num_rows == 0) {
                          // Username dan email belum ada, lakukan pendaftaran
                          $sql_insert = "INSERT INTO USERS (USERNAME, PASSWORD, EMAIL) VALUES (?, ?, ?)";
                          $stmt_insert = $conn->prepare($sql_insert);
                          if ($stmt_insert) {
                              $stmt_insert->bind_param("sss", $username, $hashed_password, $email);
                              if ($stmt_insert->execute()) {
                                  echo "<p class='text-green-500'>Registration successful!</p>";
                              } else {
                                  echo "<p class='text-red-500'>Error during registration.</p>";
                              }
                              $stmt_insert->close();
                          }
                      } else {
                          echo "<p class='text-red-500'>Username or email already exists.</p>";
                      }
                      $stmt->close();
                  }
              } else {
                  echo "<p class='text-red-500'>Passwords do not match.</p>";
              }
          } else {
              echo "<p class='text-red-500'>Please fill in all fields.</p>";
          }
      }
      ?>
    </div>
  </div>
</body>
</html>

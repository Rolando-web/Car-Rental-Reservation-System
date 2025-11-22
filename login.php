
<?php
session_start();
require_once 'database.php';
require_once 'AuthController.php';
$registerError = '';
$loginError = '';
$auth = new AuthController($pdo);

// Add role support: default role is 'customer' for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['register'])) {
    $name = $_POST['name'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    if ($password !== $confirm_password) {
      $registerError = 'Passwords do not match!';
    } else {
      $result = $auth->register($name, $contact, $email, $password);
      if ($result['success']) {
        // Auto-login after registration
        $_SESSION['user'] = [
          'id' => $result['user_id'] ?? null,
          'full_name' => $name,
          'email' => $email,
          'contact_number' => $contact,
          'role' => 'customer'
        ];
        $_SESSION['user_id'] = $result['user_id'] ?? null;
        $_SESSION['is_admin'] = 0;
        echo "<script>alert('Registration successful!'); window.location.href='index.php';</script>";
        exit();
      } else {
        $registerError = $result['message'];
      }
    }
  } elseif (isset($_POST['login'])) {
    $email = $_POST['login_email'] ?? '';
    $password = $_POST['login_password'] ?? '';
    $result = $auth->login($email, $password);
    if ($result['success']) {
      $_SESSION['user'] = $result['user'];
      $_SESSION['user_id'] = $result['user']['id'];
      $_SESSION['is_admin'] = ($result['user']['role'] === 'admin') ? 1 : 0;
      if (isset($result['user']['role']) && $result['user']['role'] === 'admin') {
        header('Location: admin-dashboard.php');
        exit();
      } else {
        header('Location: index.php');
        exit();
      }
    } else {
      $loginError = $result['message'];
    }
  }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In - DriveEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/dark-theme.css">
     <link rel="icon" href="icon.png" type="icon.png">
  </head>
  <body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
      <div class="max-w-md w-full">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
          <div class="flex items-center justify-center space-x-3 mb-4">
            <div class="w-14 h-14 bg-red-700 rounded-2xl flex items-center justify-center">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
              </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">DriveEasy</h1>
          </div>
        </div>
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
          <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome</h2>
            <p class="text-gray-600">Sign in to your account or create a new one</p>
          </div>
          <!-- Tabs -->
          <div class="flex mb-6 bg-gray-100 rounded-lg p-1">
            <button id="signInTab" class="flex-1 py-2 px-4 rounded-md font-medium transition-colors bg-white text-gray-900 shadow-sm" onclick="switchTab('signin')">Sign In</button>
            <button id="signUpTab" class="flex-1 py-2 px-4 rounded-md font-medium transition-colors text-gray-600 hover:text-gray-900" onclick="switchTab('signup')">Sign Up</button>
          </div>
          <!-- Sign In Form -->
          <form id="signInForm" method="POST" action="">
            <div class="mb-2 text-center text-sm text-red-600"><?php echo htmlspecialchars($loginError); ?></div>
            <div class="space-y-4">
              <div>
                <label for="signInEmail" class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                <input type="email" id="signInEmail" name="login_email" required placeholder="you@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div>
                <label for="signInPassword" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                <input type="password" id="signInPassword" name="login_password" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition-all" />
              </div>
              <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                  <input type="checkbox" class="w-4 h-4 text-red-700 border-gray-300 rounded focus:ring-red-500" />
                  <span class="ml-2 text-gray-600">Remember me</span>
                </label>
                <a href="#" class="text-red-700 hover:text-red-800 font-medium">Forgot password?</a>
              </div>
              <button type="submit" name="login" class="w-full bg-red-700 hover:bg-red-800 text-white py-3 rounded-lg font-semibold transition-colors">Sign In</button>
            </div>
          </form>

      <?php include 'register.php'; ?>

          <!-- Divider -->
          <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-4 bg-white text-gray-500">Or continue with</span>
            </div>
          </div>
          <!-- Back to Home -->
          <div class="mt-6 text-center">
            <a href="index.html" class="text-sm text-gray-600 hover:text-blue-600 font-medium inline-flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              Back to Home
            </a>
          </div>
        </div>
      </div>
    </div>
    <script>
      function switchTab(tab) {
        const signInTab = document.getElementById("signInTab");
        const signUpTab = document.getElementById("signUpTab");
        const signInForm = document.getElementById("signInForm");
        const signUpForm = document.getElementById("signUpForm");
        if (tab === "signin") {
          signInTab.classList.add("bg-white", "text-gray-900", "shadow-sm");
          signInTab.classList.remove("text-gray-600", "hover:text-gray-900");
          signUpTab.classList.remove("bg-white", "text-gray-900", "shadow-sm");
          signUpTab.classList.add("text-gray-600", "hover:text-gray-900");
          signInForm.classList.remove("hidden");
          signUpForm.classList.add("hidden");
        } else {
          signUpTab.classList.add("bg-white", "text-gray-900", "shadow-sm");
          signUpTab.classList.remove("text-gray-600", "hover:text-gray-900");
          signInTab.classList.remove("bg-white", "text-gray-900", "shadow-sm");
          signInTab.classList.add("text-gray-600", "hover:text-gray-900");
          signUpForm.classList.remove("hidden");
          signInForm.classList.add("hidden");
        }
      }
    </script>
  </body>
</html>
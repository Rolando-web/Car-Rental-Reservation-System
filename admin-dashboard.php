<?php
require_once 'database.php';
require_once 'CarController.php';
$carController = new CAR($pdo);
$addCarMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_car'])) {
  $car_model = $_POST['car_model'] ?? '';
  $plate_number = $_POST['plate_number'] ?? '';
  $car_type = $_POST['car_type'] ?? '';
  $rental_rate = $_POST['rental_rate'] ?? '';
  $status = $_POST['status'] ?? '';
  $car_image = '';
  if (isset($_FILES['car_image']) && $_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
    $imgTmp = $_FILES['car_image']['tmp_name'];
    $imgName = basename($_FILES['car_image']['name']);
    $imgPath = 'uploads/cars/' . uniqid() . '_' . $imgName;
    if (!is_dir('uploads/cars')) { mkdir('uploads/cars', 0777, true); }
    if (move_uploaded_file($imgTmp, $imgPath)) {
      $car_image = $imgPath;
    }
  }
  $success = $carController->create($car_model, $plate_number, $car_type, $rental_rate, $status, $car_image);
  $addCarMsg = $success ? 'Car added successfully!' : 'Failed to add car.';
}
// Fetch all cars for display
$cars = $carController->getAll();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - DriveEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <a href="index.html" class="flex items-center space-x-2">
            <div
              class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center"
            >
              <svg
                class="w-6 h-6 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"
                ></path>
              </svg>
            </div>
            <span class="text-xl font-bold text-gray-900">DriveEasy</span>
          </a>
          <div class="flex items-center space-x-8">
            <a href="admin-dashboard.html" class="text-blue-600 font-medium"
              >Dashboard</a
            >
            <a
              href="bookings.html"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Bookings</a
            >
            <a
              href="index.html#cars"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Cars</a
            >
            <div class="relative">
              <button
                id="profileButton"
                class="text-gray-700 hover:text-blue-600"
                onclick="toggleProfileDropdown()"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  ></path>
                </svg>
              </button>
              <!-- Dropdown Menu -->
              <div
                id="profileDropdown"
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
              >
                <a
                  href="admin-dashboard.html"
                  class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors"
                >
                  <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    ></path>
                  </svg>
                  Dashboard
                </a>
                <button
                  onclick="signOut()"
                  class="w-full flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors text-left"
                >
                  <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                    ></path>
                  </svg>
                  Sign Out
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Add Car Button -->
      <div class="flex justify-end mb-6">
        <button onclick="openAddCarModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">Add Car</button>
      </div>
      <!-- Add Car Modal -->
      <?php if ($addCarMsg): ?>
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800"><?php echo htmlspecialchars($addCarMsg); ?></div>
      <?php endif; ?>
      <div id="addCarModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg relative">
          <button onclick="closeAddCarModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
          <h2 class="text-2xl font-bold mb-6">Add New Car</h2>
          <form id="addCarForm" method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-4">
                          <label class="block text-sm font-semibold mb-2">Car Image</label>
                          <input type="file" name="car_image" accept="image/*" required class="w-full px-4 py-2 border rounded-lg" />
                        </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Car Model</label>
              <input type="text" name="car_model" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Plate Number</label>
              <input type="text" name="plate_number" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Car Type</label>
              <input type="text" name="car_type" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Rental Rate</label>
              <input type="number" step="0.01" name="rental_rate" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-6">
              <label class="block text-sm font-semibold mb-2">Status</label>
              <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                <option value="Available">Available</option>
                <option value="Rented">Rented</option>
                <option value="Maintenance">Maintenance</option>
              </select>
            </div>
            <div class="flex justify-end">
              <button type="submit" name="add_car" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Add Car</button>
            </div>
          </form>
        </div>
      </div>
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-blue-100 text-blue-600 rounded-full p-4 mb-4">
            <svg
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 10h18M9 21h6M12 17v4m0-4V3m0 0L7 8m5-5l5 5"
              ></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Total Bookings</h2>
          <div id="totalBookings" class="text-3xl font-bold text-gray-900">
            0
          </div>
        </div>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-green-100 text-green-600 rounded-full p-4 mb-4">
            <svg
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              ></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Active Users</h2>
          <div id="activeUsers" class="text-3xl font-bold text-gray-900">0</div>
        </div>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-yellow-100 text-yellow-600 rounded-full p-4 mb-4">
            <svg
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3"
              ></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Pending Bookings</h2>
          <div id="pendingBookings" class="text-3xl font-bold text-gray-900">
            0
          </div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow p-8 mb-8">
        <h2 class="text-2xl font-bold mb-6">Cars</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plate Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody id="carsTableBody">
              <?php foreach ($cars as $car): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($car['car_id']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($car['car_model']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($car['plate_number']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($car['car_type']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">₱<?php echo htmlspecialchars($car['rental_rate']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($car['status']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php if ($car['car_image']): ?>
                    <img src="<?php echo htmlspecialchars($car['car_image']); ?>" alt="Car Image" class="h-12 w-20 object-cover rounded" />
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script>
      // Modal logic
      function openAddCarModal() {
        document.getElementById('addCarModal').classList.remove('hidden');
      }
      function closeAddCarModal() {
        document.getElementById('addCarModal').classList.add('hidden');
      }
      function toggleProfileDropdown() {
        const dropdown = document.getElementById("profileDropdown");
        dropdown.classList.toggle("hidden");
      }
      function signOut() {
        if (confirm("Are you sure you want to sign out?")) {
          localStorage.removeItem("currentUser");
          localStorage.removeItem("currentBooking");
          alert("You have been signed out successfully.");
          window.location.href = "login.php";
        }
      }
      document.addEventListener("click", function (event) {
        const dropdown = document.getElementById("profileDropdown");
        const button = document.getElementById("profileButton");
        if (
          !dropdown.contains(event.target) &&
          !button.contains(event.target)
        ) {
          dropdown.classList.add("hidden");
        }
      });
    </script>
  </body>
</html>

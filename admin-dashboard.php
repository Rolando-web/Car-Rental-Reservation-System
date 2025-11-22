<?php
require_once 'database.php';
require_once 'CarController.php';

// Check admin role
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  header('Location: login.php');
  exit();
}

$carController = new CAR($pdo);
$addCarMsg = '';

// Get dashboard statistics
$totalBookings = $pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
$pendingBookings = $pdo->query("SELECT COUNT(*) FROM reservations WHERE status = 'Pending' OR status = ''")->fetchColumn();
$activeUsers = $pdo->query("SELECT COUNT(*) FROM customers WHERE role = 'customer'")->fetchColumn();

// Handle add car
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
    if ($success) {
        header("Location: admin-dashboard.php?success=1");
        exit;
    }
}

// Handle edit car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_car'])) {
  $car_id = $_POST['car_id'] ?? '';
  $car_model = $_POST['car_model'] ?? '';
  $plate_number = $_POST['plate_number'] ?? '';
  $car_type = $_POST['car_type'] ?? '';
  $rental_rate = $_POST['rental_rate'] ?? '';
  $status = $_POST['status'] ?? '';
  
  // Get existing car image
  $existingCar = $carController->getById($car_id);
  $car_image = $existingCar['car_image'] ?? '';
  
  // Debug: Log what we received
  error_log("EDIT CAR DEBUG: car_id=$car_id, model=$car_model, FILES count=" . count($_FILES) . ", error=" . ($_FILES['car_image']['error'] ?? 'no file'));
  
  // If new image uploaded, use it (replace old one)
  if (isset($_FILES['car_image']) && $_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
    $imgTmp = $_FILES['car_image']['tmp_name'];
    $imgName = basename($_FILES['car_image']['name']);
    $imgPath = 'uploads/cars/' . uniqid() . '_' . $imgName;
    if (!is_dir('uploads/cars')) { mkdir('uploads/cars', 0777, true); }
    if (move_uploaded_file($imgTmp, $imgPath)) {
      $car_image = $imgPath;
      error_log("IMAGE UPLOADED: $imgPath");
    } else {
      error_log("MOVE UPLOAD FAILED for $imgTmp to $imgPath");
    }
  }
  
  $success = $carController->update($car_id, $car_model, $plate_number, $car_type, $rental_rate, $status, $car_image);
  $addCarMsg = $success ? 'Car updated successfully!' : 'Failed to update car.';
  error_log("UPDATE RESULT: success=$success, msg=$addCarMsg");
  if ($success) {
    header("Location: admin-dashboard.php?updated=1");
    exit;
  }
}

// Handle car deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_car']) && isset($_POST['delete_car_id'])) {
  $car_id = $_POST['delete_car_id'];
  $success = $carController->delete($car_id);
  $addCarMsg = $success ? 'Car deleted successfully!' : 'Failed to delete car.';
  header("Location: admin-dashboard.php?deleted=1");
  exit;
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
    <link rel="stylesheet" href="css/dark-theme.css">
  </head>
  <body class="min-h-screen bg-black">

  <?php include 'components/admin-nav.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Hidden form for car deletion -->
            <form id="deleteCarForm" method="POST" action="admin-dashboard.php" style="display:none;">
              <input type="hidden" name="delete_car_id" id="delete_car_id" />
              <input type="hidden" name="delete_car" value="1" />
            </form>
      <!-- Add Car Button -->
      <div class="flex justify-end mb-6">
        <button onclick="openAddCarModal()" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-semibold transition-colors">Add Car</button>
      </div>
      <!-- Add Car Modal -->
      <?php if ($addCarMsg): ?>
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800"><?php echo htmlspecialchars($addCarMsg); ?></div>
      <?php endif; ?>
      <div id="addCarModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg relative">
          <button onclick="closeAddCarModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
          <h2 id="carModalTitle" class="text-2xl font-bold mb-6">Add New Car</h2>
          <form id="addCarForm" method="POST" action="admin-dashboard.php" enctype="multipart/form-data">
            <input type="hidden" name="car_id" id="car_id" />
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Car Image</label>
              <input type="file" name="car_image" id="car_image" accept="image/*" class="w-full px-4 py-2 border rounded-lg" />
              <img id="carImagePreview" src="#" alt="Preview" class="h-12 w-20 object-cover rounded mt-2 hidden" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Car Model</label>
              <input type="text" name="car_model" id="car_model" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Plate Number</label>
              <input type="text" name="plate_number" id="plate_number" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Car Type</label>
              <input type="text" name="car_type" id="car_type" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-2">Rental Rate</label>
              <input type="number" step="0.01" name="rental_rate" id="rental_rate" required class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div class="mb-6">
              <label class="block text-sm font-semibold mb-2">Status</label>
              <select name="status" id="status" required class="w-full px-4 py-2 border rounded-lg">
                <option value="Available">Available</option>
                <option value="Rented">Rented</option>
                <option value="Maintenance">Maintenance</option>
              </select>
            </div>
            <div class="flex justify-end">
              <button type="submit" id="carModalSubmit" name="add_car" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-semibold">Add Car</button>
            </div>
          </form>
        </div>
      </div>
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-red-100 text-red-700 rounded-full p-4 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Total Bookings</h2>
          <div id="totalBookings" class="text-3xl font-bold text-gray-900">
            <?php echo $totalBookings; ?>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-green-100 text-green-600 rounded-full p-4 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Active Users</h2>
          <div id="activeUsers" class="text-3xl font-bold text-gray-900"><?php echo $activeUsers; ?></div>
        </div>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-yellow-100 text-yellow-600 rounded-full p-4 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Pending Bookings</h2>
          <div id="pendingBookings" class="text-3xl font-bold text-gray-900">
            <?php echo $pendingBookings; ?>
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
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody id="carsTableBody">
              <?php foreach ($cars as $car): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap"> <?php echo htmlspecialchars($car['car_id']); ?> </td>
                <td class="px-6 py-4 whitespace-nowrap"> <?php echo htmlspecialchars($car['car_model']); ?> </td>
                <td class="px-6 py-4 whitespace-nowrap"> <?php echo htmlspecialchars($car['plate_number']); ?> </td>
                <td class="px-6 py-4 whitespace-nowrap"> <?php echo htmlspecialchars($car['car_type']); ?> </td>
                <td class="px-6 py-4 whitespace-nowrap">₱<?php echo htmlspecialchars($car['rental_rate']); ?> </td>
                <td class="px-6 py-4 whitespace-nowrap"> <?php echo htmlspecialchars($car['status']); ?> </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <?php if ($car['car_image']): ?>
                    <img src="<?php echo htmlspecialchars($car['car_image']); ?>" alt="Car Image" class="h-12 w-20 object-cover rounded mx-auto" />
                  <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                  <span class="inline-block cursor-pointer mr-3" title="Edit" onclick="editCar(<?php echo $car['car_id']; ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 hover:text-yellow-600 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h2v2h-2v-2z" />
                    </svg>
                  </span>
                  <span class="inline-block cursor-pointer" title="Delete" onclick="deleteCar(<?php echo $car['car_id']; ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 hover:text-red-700 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script>

      function openAddCarModal() {
        resetCarModal();
        document.getElementById('carModalTitle').textContent = 'Add New Car';
        document.getElementById('carModalSubmit').textContent = 'Add Car';
        document.getElementById('carModalSubmit').name = 'add_car';
        document.getElementById('addCarForm').action = '';
        document.getElementById('addCarModal').classList.remove('hidden');
      }

      function openEditCarModal(car) {
        resetCarModal();
        document.getElementById('carModalTitle').textContent = 'Edit Car';
        document.getElementById('carModalSubmit').textContent = 'Update Car';
        document.getElementById('carModalSubmit').name = 'edit_car';
        document.getElementById('car_id').value = car.car_id;
        document.getElementById('car_model').value = car.car_model;
        document.getElementById('plate_number').value = car.plate_number;
        document.getElementById('car_type').value = car.car_type;
        document.getElementById('rental_rate').value = car.rental_rate;
        document.getElementById('status').value = car.status;
        console.log('Edit mode for car:', car.car_id, 'Button name:', document.getElementById('carModalSubmit').name);
        if (car.car_image) {
          var img = document.getElementById('carImagePreview');
          img.src = car.car_image;
          img.classList.remove('hidden');
        }
        document.getElementById('addCarModal').classList.remove('hidden');
      }

      function closeAddCarModal() {
        document.getElementById('addCarModal').classList.add('hidden');
      }

      document.getElementById('addCarModal').addEventListener('mousedown', function(e) {
        if (e.target === this) {
          closeAddCarModal();
        }
      });

      function resetCarModal() {
        document.getElementById('addCarForm').reset();
        document.getElementById('car_id').value = '';
        const fileInput = document.getElementById('car_image');
        fileInput.value = '';
        const preview = document.getElementById('carImagePreview');
        if (preview.src && preview.src.startsWith('blob:')) {
          URL.revokeObjectURL(preview.src);
        }
        preview.classList.add('hidden');
        preview.src = '';
      }

  
      function editCar(carId) {
        var cars = window.carsData || [];
        var car = cars.find(function(c) { return c.car_id == carId; });
        if (car) {
          openEditCarModal(car);
        }
      }

      function deleteCar(carId) {
        if (confirm('Are you sure you want to delete this car?')) {
          document.getElementById('delete_car_id').value = carId;
          document.getElementById('deleteCarForm').submit();
        }
      }

      document.getElementById('addCarForm').addEventListener('submit', function(e) {
        const button = document.getElementById('carModalSubmit');
        console.log('FORM SUBMITTING with button name:', button.name, 'car_id:', document.getElementById('car_id').value);
        console.log('File input:', document.getElementById('car_image').files.length, 'files');
        if (document.getElementById('car_image').files.length > 0) {
          console.log('File:', document.getElementById('car_image').files[0].name, 'Size:', document.getElementById('car_image').files[0].size);
        }
      });

      document.getElementById('car_image').addEventListener('change', function(e) {
        const [file] = this.files;
        console.log('Image change event:', file ? file.name : 'no file');
        if (file) {
          const preview = document.getElementById('carImagePreview');
          preview.src = URL.createObjectURL(file);
          preview.classList.remove('hidden');
        }
      });

      // Dynamic data refresh
      function refreshDashboard() {
        location.reload();
      }

      window.carsData = <?php echo json_encode($cars); ?>;

      function toggleProfileDropdown() {
        const dropdown = document.getElementById("profileDropdown");
        dropdown.classList.toggle("hidden");
      }
      function signOut() {
        if (confirm("Are you sure you want to sign out?")) {
          window.location.href = "logout.php";
        }
      }
      document.addEventListener("click", function (event) {
        const dropdown = document.getElementById("profileDropdown");
        const button = document.getElementById("profileButton");
        if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
          dropdown.classList.add("hidden");
        }
      });
    </script>
  </body>
</html>

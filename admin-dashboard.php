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
    if ($success) {
        header("Location: admin-dashboard.php?success=1");
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
  </head>
  <body class="bg-gray-50">

  <?php include 'components/admin-nav.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Hidden form for car deletion -->
            <form id="deleteCarForm" method="POST" action="" style="display:none;">
              <input type="hidden" name="delete_car_id" id="delete_car_id" />
              <input type="hidden" name="delete_car" value="1" />
            </form>
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
          <h2 id="carModalTitle" class="text-2xl font-bold mb-6">Add New Car</h2>
          <form id="addCarForm" method="POST" action="" enctype="multipart/form-data">
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
              <button type="submit" id="carModalSubmit" name="add_car" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Add Car</button>
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
      // Modal logic
      function openAddCarModal() {
        resetCarModal();
        document.getElementById('carModalTitle').textContent = 'Add New Car';
        document.getElementById('carModalSubmit').textContent = 'Add Car';
        document.getElementById('carModalSubmit').name = 'add_car';
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
        document.getElementById('carImagePreview').classList.add('hidden');
      }

      // Edit icon click handler
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

      document.getElementById('car_image').addEventListener('change', function(e) {
        const [file] = this.files;
        if (file) {
          const preview = document.getElementById('carImagePreview');
          preview.src = URL.createObjectURL(file);
          preview.classList.remove('hidden');
        }
      });


      window.carsData = <?php echo json_encode($cars); ?>;

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

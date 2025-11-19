            <?php
            require_once 'database.php';
            session_start();
            // Fetch car details for summary
            $car = null;
            if (isset($_GET['car_id'])) {
              $car_id = intval($_GET['car_id']);
              $stmt = $pdo->prepare('SELECT * FROM cars WHERE car_id = ?');
              $stmt->execute([$car_id]);
              $car = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $customer_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null; // Use correct session key
              $car_id = isset($_POST['car_id']) ? intval($_POST['car_id']) : null;
              $rental_date = trim($_POST['rental_date'] ?? '');
              $return_date = trim($_POST['return_date'] ?? '');
              $total_amount = $_POST['total_amount'] ?? 0;
              $status = 'Pending';
              $error = '';
              if (!$customer_id) {
                $error = 'You must be logged in to make a reservation.';
              } elseif (!$car_id) {
                $error = 'Invalid car selection.';
              } elseif (empty($rental_date) || empty($return_date)) {
                $error = 'Please select both rental and return dates.';
              }
              if ($error) {
                echo '<div class="bg-red-100 text-red-800 p-4 rounded mb-4">' . htmlspecialchars($error) . '</div>';
              } else {
                $stmt = $pdo->prepare("INSERT INTO reservations (id, car_id, rental_date, return_date, total_amount, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$customer_id, $car_id, $rental_date, $return_date, $total_amount, $status]);
                header('Location: bookings.php');
                exit();
              }
            }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complete Your Booking - DriveEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-50">
   <?php include 'components/navigator.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">
        Complete Your Booking
      </h1>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking Details Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
              Booking Details
            </h2>
            <form id="bookingForm" method="POST" action="">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label class="flex items-center text-gray-700 font-medium mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Rental Date
                  </label>
                  <input type="date" id="rental_date" name="rental_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                </div>
                <div>
                  <label class="flex items-center text-gray-700 font-medium mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Return Date
                  </label>
                  <input type="date" id="return_date" name="return_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                </div>
              </div>
              <input type="hidden" id="car_id" name="car_id" value="<?php echo isset($_GET['car_id']) ? intval($_GET['car_id']) : ''; ?>">
              <input type="hidden" id="total_amount" name="total_amount" value="">
              <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-lg font-semibold text-lg transition-colors">Confirm Booking</button>
            </form>
            <script>
            // Calculate total days and amount
            const rentalInput = document.getElementById('rental_date');
            const returnInput = document.getElementById('return_date');
            const totalDaysSpan = document.getElementById('totalDays');
            const totalPriceSpan = document.getElementById('totalPrice');
            const totalAmountInput = document.getElementById('total_amount');
            const dailyRate = <?php echo isset($car['rental_rate']) ? (float)$car['rental_rate'] : 0; ?>;

            function updateTotal() {
              const rentalDate = rentalInput.value;
              const returnDate = returnInput.value;
              if (rentalDate && returnDate) {
                const start = new Date(rentalDate);
                const end = new Date(returnDate);
                let days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                if (days < 1) days = 1;
                totalDaysSpan.textContent = days;
                const total = days * dailyRate;
                totalPriceSpan.textContent = total.toFixed(2);
                totalAmountInput.value = total.toFixed(2);
              } else {
                totalDaysSpan.textContent = '0';
                totalPriceSpan.textContent = '0.00';
                totalAmountInput.value = '';
              }
            }
            rentalInput.addEventListener('change', updateTotal);
            returnInput.addEventListener('change', updateTotal);
            // Set total_amount hidden field on form submit
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
              updateTotal();
            });
            </script>
          </div>
        </div>
        <!-- Booking Summary -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-8 sticky top-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking Summary</h2>
            <?php if ($car): ?>
              <div class="mb-6 flex flex-col items-center">
                <img src="<?php echo htmlspecialchars($car['car_image']); ?>" alt="Car" class="w-full h-48 object-cover rounded-lg mb-4" />
                <h3 class="text-xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($car['car_model']); ?></h3>
                <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($car['car_type']); ?></p>
                <p class="text-gray-500 text-sm mb-2"><?php echo isset($car['description']) ? htmlspecialchars($car['description']) : ''; ?></p>
                <div class="flex gap-4 text-sm text-gray-600 mb-2">
                  <span>Seats: <?php echo htmlspecialchars($car['seats'] ?? '5'); ?></span>
                  <span>Transmission: <?php echo htmlspecialchars($car['transmission'] ?? 'Automatic'); ?></span>
                  <span>Fuel: <?php echo htmlspecialchars($car['fuel'] ?? 'Petrol'); ?></span>
                </div>
              </div>
              <div class="border-t pt-6">
                <div class="flex items-baseline justify-between mb-2">
                  <span class="text-gray-700 font-medium">Daily Rate</span>
                  <span class="text-3xl font-bold text-gray-900">₱<?php echo htmlspecialchars($car['rental_rate']); ?><span class="text-sm text-gray-600 font-normal">/day</span></span>
                </div>
                <div id="totalSection" class="mt-4 pt-4 border-t">
                  <div class="flex items-center justify-between text-lg">
                    <span class="text-gray-700 font-medium">Total (<span id="totalDays">0</span> days)</span>
                    <span class="text-2xl font-bold text-blue-600">₱<span id="totalPrice">0.00</span></span>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="text-red-500">Car not found.</div>
            <?php endif; ?>
          </div>
        </div>



    <script>
    // Set total_amount hidden field on form submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
      var total = document.getElementById('totalPrice') ? document.getElementById('totalPrice').textContent : '';
      document.getElementById('total_amount').value = total;
    });
    </script>
  </body>
</html>

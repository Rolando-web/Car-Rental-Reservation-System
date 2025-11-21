<?php
require_once 'database.php';
session_start();

// Check admin role
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  header('Location: login.php');
  exit();
}

// Get all active bookings (Confirmed status)
$stmt = $pdo->prepare('
  SELECT 
    r.reservation_id,
    r.id as customer_id,
    r.car_id,
    r.rental_date,
    r.return_date,
    r.total_amount,
    r.status,
    c.full_name,
    c.email,
    c.contact_number,
    car.car_model,
    car.car_type,
    car.plate_number,
    car.rental_rate,
    car.car_image
  FROM reservations r
  JOIN customers c ON r.id = c.id
  JOIN cars car ON r.car_id = car.car_id
  WHERE r.status = "Confirmed"
  ORDER BY r.rental_date ASC
');
$stmt->execute();
$activeBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$totalActive = count($activeBookings);
$stmt = $pdo->prepare('
  SELECT COUNT(*) as total FROM reservations WHERE status = "Confirmed"
');
$stmt->execute();
$totalActiveBookings = $stmt->fetch()['total'];

$stmt = $pdo->prepare('
  SELECT SUM(total_amount) as revenue FROM reservations WHERE status = "Confirmed"
');
$stmt->execute();
$activeRevenue = $stmt->fetch()['revenue'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Active Bookings - DriveEasy Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-50">

  <?php include 'components/admin-nav.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Active Bookings</h1>

      <!-- PDF Report Button -->
      <div class="mb-8 flex gap-4">
        <a href="generate-daily-report.php" target="_blank" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
          Download Daily Report (PDF)
        </a>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-blue-100 text-blue-600 rounded-full p-4 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Total Active</h2>
          <div class="text-3xl font-bold text-gray-900"><?php echo $totalActiveBookings; ?></div>
        </div>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-green-100 text-green-600 rounded-full p-4 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Revenue</h2>
          <div class="text-3xl font-bold text-gray-900">₱<?php echo number_format($activeRevenue, 2); ?></div>
        </div>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
          <div class="bg-purple-100 text-purple-600 rounded-full p-4 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.656V9" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-2">Active Users</h2>
          <div class="text-3xl font-bold text-gray-900">
            <?php 
              $uniqueCustomers = array_unique(array_column($activeBookings, 'customer_id'));
              echo count($uniqueCustomers);
            ?>
          </div>
        </div>
      </div>

      <!-- Active Bookings Table -->
      <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
              <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Customer</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Contact</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Car</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Plate</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Rental Date</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Return Date</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Amount</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php if (empty($activeBookings)): ?>
                <tr>
                  <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                      <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                      </svg>
                      <p class="text-lg font-semibold">No Active Bookings</p>
                      <p class="text-sm text-gray-400 mt-1">All confirmed bookings will appear here</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($activeBookings as $booking): ?>
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                      <div>
                        <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($booking['full_name']); ?></p>
                        <p class="text-sm text-gray-600">#<?php echo $booking['customer_id']; ?></p>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm">
                        <p class="text-gray-900"><?php echo htmlspecialchars($booking['email']); ?></p>
                        <p class="text-gray-600"><?php echo htmlspecialchars($booking['contact_number']); ?></p>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div>
                        <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($booking['car_model']); ?></p>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($booking['car_type']); ?></p>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <p class="font-mono font-semibold text-blue-600"><?php echo htmlspecialchars($booking['plate_number']); ?></p>
                    </td>
                    <td class="px-6 py-4">
                      <p class="text-gray-900"><?php echo htmlspecialchars($booking['rental_date']); ?></p>
                    </td>
                    <td class="px-6 py-4">
                      <p class="text-gray-900"><?php echo htmlspecialchars($booking['return_date']); ?></p>
                    </td>
                    <td class="px-6 py-4">
                      <p class="font-semibold text-green-600">₱<?php echo number_format($booking['total_amount'], 2); ?></p>
                    </td>
                    <td class="px-6 py-4">
                      <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Confirmed</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php include 'components/footer.php'; ?>
  </body>
</html>

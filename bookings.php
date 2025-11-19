
<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['user']['id'])) {
  header('Location: login.php');
  exit();
}
$user_id = $_SESSION['user']['id'];

// Handle cancel booking action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
  $cancel_id = intval($_POST['cancel_id']);
  // Only cancel the booking with this id and belonging to this user
  $stmt = $pdo->prepare("UPDATE reservations SET status = 'Cancelled' WHERE id = ? AND car_id = ? AND status = 'Pending'");
  $stmt->execute([$cancel_id, $user_id]);
}

// Fetch all bookings for this user
$stmt = $pdo->prepare('SELECT r.id, r.car_id, r.rental_date, r.return_date, r.total_amount, r.status, c.car_model, c.car_image, c.car_type, c.rental_rate FROM reservations r JOIN cars c ON r.car_id = c.car_id WHERE r.id = ? ORDER BY r.rental_date DESC');
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Bookings - DriveEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-50">
<?php include 'components/navigator.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-12">My Bookings</h1>

      <?php if (empty($bookings)): ?>
        <div class="text-center py-16">
          <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-700 mb-2">No bookings yet</h3>
          <p class="text-gray-500 mb-6">Start exploring our amazing cars and make your first booking!</p>
          <a href="index.php#cars" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">Browse Cars</a>
        </div>
      <?php else: ?>
        <div class="space-y-6">
          <?php foreach ($bookings as $booking): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="flex flex-col lg:flex-row gap-6 p-6">
                <div class="flex-shrink-0">
                  <img src="<?php echo htmlspecialchars($booking['car_image']); ?>" alt="<?php echo htmlspecialchars($booking['car_model']); ?>" class="w-full lg:w-64 h-48 object-cover rounded-lg" />
                </div>
                <div class="flex-1">
                  <div class="flex items-start justify-between mb-4 flex-wrap gap-4">
                    <div>
                      <h2 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($booking['car_model']); ?></h2>
                      <p class="text-gray-600"><?php echo htmlspecialchars($booking['car_type']); ?></p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-medium <?php
                      switch (strtolower($booking['status'])) {
                        case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                        case 'confirmed': echo 'bg-green-100 text-green-800'; break;
                        case 'cancelled': echo 'bg-red-100 text-red-800'; break;
                        case 'completed': echo 'bg-blue-100 text-blue-800'; break;
                        default: echo 'bg-gray-100 text-gray-800';
                      }
                    ?>"><?php echo htmlspecialchars($booking['status']); ?></span>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                      <div class="flex items-center space-x-2 text-blue-600 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold text-gray-900">Rental Date</span>
                      </div>
                      <p class="text-blue-600 font-semibold mb-1"><?php echo htmlspecialchars($booking['rental_date']); ?></p>
                    </div>
                    <div>
                      <div class="flex items-center space-x-2 text-blue-600 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold text-gray-900">Return Date</span>
                      </div>
                      <p class="text-blue-600 font-semibold mb-1"><?php echo htmlspecialchars($booking['return_date']); ?></p>
                    </div>
                  </div>
                  <div>
                    <p class="text-gray-600 text-sm mb-1">Total Amount</p>
                    <?php
                      $days = 1;
                      if (!empty($booking['rental_date']) && !empty($booking['return_date'])) {
                        $start = new DateTime($booking['rental_date']);
                        $end = new DateTime($booking['return_date']);
                        $interval = $start->diff($end);
                        $days = (int)$interval->format('%a');
                        if ($days < 1) $days = 1;
                      }
                      $rate = isset($booking['rental_rate']) ? floatval($booking['rental_rate']) : 0;
                      $live_total = $days * $rate;
                    ?>
                    <p class="text-3xl font-bold text-gray-900">₱<?php echo number_format($live_total, 2); ?></p>
                    <span class="text-gray-500 text-sm">(<?php echo $days; ?> day<?php echo $days > 1 ? 's' : ''; ?> × ₱<?php echo number_format($rate, 2); ?>)</span>
                  </div>
                  <?php if (strtolower($booking['status']) === 'pending'): ?>
                    <form method="POST" class="mt-4">
                      <input type="hidden" name="cancel_id" value="<?php echo $booking['id']; ?>">
                      <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap">Cancel Booking</button>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

   <?php include 'components/footer.php'; ?>
        <script src="js/signout.js"></script>
  </body>
</html>

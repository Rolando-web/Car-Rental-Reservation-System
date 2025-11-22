
<?php
require_once 'database.php';

// Handle Approve/Reject actions
$actionMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
  $reservation_id = $_POST['reservation_id'];
  if (isset($_POST['approve'])) {
    // Approve booking
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'Confirmed' WHERE reservation_id = ?");
    $stmt->execute([$reservation_id]);
    
    // Get customer id and car details for notification
    $stmt = $pdo->prepare("SELECT r.id, c.car_model FROM reservations r JOIN cars c ON r.car_id = c.car_id WHERE r.reservation_id = ?");
    $stmt->execute([$reservation_id]);
    $row = $stmt->fetch();
    if ($row && !empty($row['id'])) {
      $user_id = $row['id'];
      $car_model = $row['car_model'];
      $msg = 'Your reservation #' . htmlspecialchars($reservation_id) . ' for ' . htmlspecialchars($car_model) . ' has been confirmed! You can now return the car and complete payment.';
      $pdo->prepare("INSERT INTO notifications (customer_id, message, is_read, created_at) VALUES (?, ?, 0, NOW())")
        ->execute([$user_id, $msg]);
    }
    $actionMsg = 'Reservation confirmed successfully.';
  } elseif (isset($_POST['reject'])) {
    // Reject booking
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'Rejected' WHERE reservation_id = ?");
    $stmt->execute([$reservation_id]);
    
    // Get customer id and car details for notification
    $stmt = $pdo->prepare("SELECT r.id, c.car_model FROM reservations r JOIN cars c ON r.car_id = c.car_id WHERE r.reservation_id = ?");
    $stmt->execute([$reservation_id]);
    $row = $stmt->fetch();
    if ($row && !empty($row['id'])) {
      $user_id = $row['id'];
      $car_model = $row['car_model'];
      $msg = 'Your reservation #' . htmlspecialchars($reservation_id) . ' for ' . htmlspecialchars($car_model) . ' has been rejected.';
      $pdo->prepare("INSERT INTO notifications (customer_id, message, is_read, created_at) VALUES (?, ?, 0, NOW())")
        ->execute([$user_id, $msg]);
    }
    $actionMsg = 'Reservation rejected successfully.';
  }
  // Refresh to avoid resubmission
  header('Location: Booking-pending.php?msg=' . urlencode($actionMsg));
  exit;
}

// Fetch all pending reservations with car and customer details
$sql = "SELECT r.reservation_id, r.status, r.rental_date, r.return_date, r.total_amount, c.car_model, c.car_type, c.car_image, cu.full_name, cu.email, c.rental_rate FROM reservations r JOIN cars c ON r.car_id = c.car_id JOIN customers cu ON r.id = cu.id WHERE r.status = 'Pending' OR r.status = ''";
$stmt = $pdo->query($sql);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pending Bookings - DriveEasy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/dark-theme.css">
</head>
<body class="bg-gray-50">
  <?php include 'components/admin-nav.php'; ?>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-12">Pending Reservations</h1>
    <?php if (isset($_GET['msg'])): ?>
      <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow text-center font-semibold"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>
    <?php if (empty($reservations)): ?>
      <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No pending reservations</h3>
        <p class="text-gray-500 mb-6">All requests have been processed.</p>
      </div>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($reservations as $res): ?>
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="flex flex-col lg:flex-row gap-6 p-6">
              <div class="flex-shrink-0">
                <img src="<?php echo htmlspecialchars($res['car_image']); ?>" alt="<?php echo htmlspecialchars($res['car_model']); ?>" class="w-full lg:w-64 h-48 object-cover rounded-lg" />
              </div>
              <div class="flex-1">
                <div class="flex items-start justify-between mb-4 flex-wrap gap-4">
                  <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($res['car_model']); ?></h2>
                    <p class="text-gray-600"><?php echo htmlspecialchars($res['car_type']); ?></p>
                    <p class="text-xs text-gray-500 mt-2">Reservation ID: <span class="font-semibold">#<?php echo htmlspecialchars($res['reservation_id']); ?></span></p>
                    <p class="text-xs text-gray-500">Requested by: <span class="font-semibold text-gray-900"><?php echo htmlspecialchars($res['full_name']); ?></span></p>
                    <p class="text-xs text-gray-500">Email: <span class="font-semibold text-gray-900"><?php echo htmlspecialchars($res['email']); ?></span></p>
                  </div>
                  <span class="px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pending</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                  <div>
                    <div class="flex items-center space-x-2 text-blue-600 mb-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <span class="font-semibold text-gray-900">Rental Date</span>
                    </div>
                    <p class="text-blue-600 font-semibold mb-1"><?php echo htmlspecialchars($res['rental_date']); ?></p>
                  </div>
                  <div>
                    <div class="flex items-center space-x-2 text-blue-600 mb-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <span class="font-semibold text-gray-900">Return Date</span>
                    </div>
                    <p class="text-blue-600 font-semibold mb-1"><?php echo htmlspecialchars($res['return_date']); ?></p>
                  </div>
                </div>
                <div>
                  <p class="text-gray-600 text-sm mb-1">Total Amount</p>
                  <?php
                    $days = 1;
                    if (!empty($res['rental_date']) && !empty($res['return_date'])) {
                      $start = new DateTime($res['rental_date']);
                      $end = new DateTime($res['return_date']);
                      $interval = $start->diff($end);
                      $days = (int)$interval->format('%a');
                      if ($days < 1) $days = 1;
                    }
                    $rate = isset($res['rental_rate']) ? floatval($res['rental_rate']) : 0;
                    $live_total = $days * $rate;
                  ?>
                  <p class="text-3xl font-bold text-gray-900">₱<?php echo number_format($live_total, 2); ?></p>
                  <span class="text-gray-500 text-sm">(<?php echo $days; ?> day<?php echo $days > 1 ? 's' : ''; ?> × ₱<?php echo number_format($rate, 2); ?>)</span>
                </div>
                <form method="POST" class="mt-6 flex gap-3">
                  <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($res['reservation_id']); ?>">
                  <button type="submit" name="approve" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap flex-1">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Approve
                  </button>
                  <button type="submit" name="reject" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap flex-1">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reject
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
      <script src="js/signout.js">  </script>
</body>
</html>

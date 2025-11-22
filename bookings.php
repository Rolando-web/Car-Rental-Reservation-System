
<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['user']['id'])) {
  header('Location: login.php');
  exit();
}
$user_id = $_SESSION['user']['id'];

// Handle payment processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_reservation_id'])) {
  $reservation_id = intval($_POST['pay_reservation_id']);
  $payment_amount = floatval($_POST['pay_amount']);
  $payment_method = $_POST['payment_method'] ?? 'Online';
  
  try {
    // Insert payment record with payment method
    $stmt = $pdo->prepare("INSERT INTO payments (reservation_id, amount, payment_method, status) VALUES (?, ?, ?, 'Completed')");
    $stmt->execute([$reservation_id, $payment_amount, $payment_method]);
    
    // Payment recorded - reservation stays as Confirmed
    // You can add a payments table status check if needed in future
    
    // Set success message
    $_SESSION['payment_success'] = true;
    $_SESSION['paid_reservation_id'] = $reservation_id;
    header('Location: bookings.php?payment=success&reservation=' . $reservation_id);
    exit();
  } catch (Exception $e) {
    $_SESSION['payment_error'] = 'Payment processing failed. Please try again.';
    header('Location: bookings.php?payment=error');
    exit();
  }
}

// Handle cancel booking action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
  $cancel_id = intval($_POST['cancel_id']);
  $stmt = $pdo->prepare("UPDATE reservations SET status = 'Cancelled' WHERE reservation_id = ? AND id = ? AND (status = 'Pending' OR status = '')");
  $stmt->execute([$cancel_id, $user_id]);
}

$stmt = $pdo->prepare('SELECT r.reservation_id, r.id, r.car_id, r.rental_date, r.return_date, r.total_amount, r.status, c.car_model, c.car_image, c.car_type, c.rental_rate FROM reservations r JOIN cars c ON r.car_id = c.car_id WHERE r.id = ? ORDER BY r.rental_date DESC');
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('
  SELECT DISTINCT reservation_id FROM payments WHERE reservation_id IN 
  (SELECT reservation_id FROM reservations WHERE id = ?)
');
$stmt->execute([$user_id]);
$paidReservations = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'reservation_id');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Bookings - DriveEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/dark-theme.css">
  </head>
  <body class="bg-gray-50">
<?php include 'components/navigator.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-12">My Bookings</h1>

      <?php if (isset($_GET['payment']) && $_GET['payment'] === 'success'): ?>
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow text-center font-semibold">
          Payment successful! Your booking has been completed.
        </div>
      <?php elseif (isset($_GET['payment']) && $_GET['payment'] === 'error'): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded shadow text-center font-semibold">
          Payment processing failed. Please try again.
        </div>
      <?php endif; ?>

      <?php if (empty($bookings)): ?>
        <div class="text-center py-16">
          <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-700 mb-2">No bookings yet</h3>
          <p class="text-gray-500 mb-6">Start exploring our amazing cars and make your first booking!</p>
          <a href="index.php#cars" class="inline-block bg-red-700 hover:bg-red-800 text-white px-8 py-3 rounded-lg font-medium transition-colors">Browse Cars</a>
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
                    
                    $status = strtolower($booking['status']);
                    $badge = '';
                    if ($status === 'confirmed') {
                      $badge = '<span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold mt-1">Confirmed</span>';
                    } elseif ($status === 'pending' || $status === '') {
                      $badge = '<span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold mt-1">Pending</span>';
                    } elseif ($status === 'cancelled') {
                      $badge = '<span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold mt-1">Cancelled</span>';
                    }
                  ?>
                  <div class="flex items-start justify-between mb-4 flex-wrap gap-4">
                    <div>
                      <h2 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($booking['car_model']); ?></h2>
                      <p class="text-gray-600 mb-1"><?php echo htmlspecialchars($booking['car_type']); ?></p>
                      <div><?php echo $badge; ?></div>
                      <?php 
                        $isPaid = in_array($booking['reservation_id'], $paidReservations);
                        if ($status === 'confirmed'): 
                      ?>
                        <div class="flex gap-3 flex-wrap mt-4">
                          <?php if ($isPaid): ?>
                            <button type="button" disabled class="bg-gray-500 text-white px-8 py-3 rounded-lg font-medium cursor-not-allowed whitespace-nowrap">PAID</button>
                            <a href="download-receipt.php?reservation_id=<?php echo $booking['reservation_id']; ?>" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap inline-flex items-center gap-2">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                              Download Receipt
                            </a>
                          <?php else: ?>
                            <button type="button" id="returnBtn_<?php echo $booking['reservation_id']; ?>" class="bg-red-700 hover:bg-red-800 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap" onclick="openReturnModal(<?php echo $booking['reservation_id']; ?>, <?php echo $live_total; ?>)">Return Car</button>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                    </div>
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
   <!-- Return Modal -->
   <div id="returnModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
     <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
       <button onclick="closeReturnModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
       <h2 class="text-2xl font-bold mb-6 text-gray-900">Car Return & Payment</h2>
       <div class="mb-6 p-4 bg-red-50 rounded-lg">
         <p class="text-sm text-gray-600 mb-2">Total Amount Due</p>
         <div class="text-3xl font-bold text-red-700 mb-4">₱<span id="modalTotalAmount">0.00</span></div>
       </div>
       
       <div id="paymentOptions" class="space-y-3 mb-6">
         <button type="button" onclick="selectPaymentMethod('Online')" class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-700 hover:bg-red-50 transition-colors text-left payment-option" data-method="Online">
           <p class="font-semibold text-gray-900">💳 Online Payment</p>
           <p class="text-xs text-gray-600 mt-1">Pay instantly via card or e-wallet</p>
         </button>
         <button type="button" onclick="selectPaymentMethod('Cash')" class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-600 hover:bg-green-50 transition-colors text-left payment-option" data-method="Cash">
           <p class="font-semibold text-gray-900">💵 Cash Payment</p>
           <p class="text-xs text-gray-600 mt-1">Pay in cash upon return</p>
         </button>
       </div>
       
       <form id="payForm" method="POST" style="display:none;">
         <input type="hidden" name="pay_reservation_id" id="payReservationId" value="">
         <input type="hidden" name="pay_amount" id="payAmount" value="">
         <input type="hidden" name="payment_method" id="paymentMethod" value="">
       </form>
       
       <button id="payNowBtn" type="button" onclick="submitPayment()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold text-lg transition-colors mb-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Pay Now</button>
       <button type="button" onclick="closeReturnModal()" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 rounded-lg font-semibold transition-colors">Cancel</button>
     </div>
   </div>
   <!-- Toast Message -->
   <div id="toast" class="fixed bottom-8 right-8 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden">Payment Successful</div>

   <script src="js/signout.js"></script>
   <script src="js/payment.js"></script>
  </body>
</html>

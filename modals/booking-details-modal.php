<?php
require_once '../database.php';
// Example: $booking_id = $_GET['booking_id'] ?? 1;
$booking_id = $_GET['booking_id'] ?? null;
if ($booking_id) {
  $stmt = $pdo->prepare("SELECT r.*, c.car_model, c.car_type, c.car_image FROM reservations r JOIN cars c ON r.car_id = c.car_id WHERE r.reservation_id = ?");
  $stmt->execute([$booking_id]);
  $booking = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<?php if (!empty($booking)): ?>
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
    <div class="sticky top-0 bg-white border-b border-gray-200 px-8 py-6 flex items-center justify-between">
      <h2 class="text-3xl font-bold text-gray-900">Booking Details</h2>
      <button onclick="closeDetailsModal()" class="text-gray-400 hover:text-gray-600">
        <!-- ...close icon... -->
      </button>
    </div>
    <div class="p-8">
      <div class="flex items-center justify-between mb-6 pb-6 border-b">
        <div>
          <p class="text-sm text-gray-600 mb-1">Booking ID</p>
          <p class="text-xl font-bold text-gray-900">#<?php echo htmlspecialchars($booking['reservation_id']); ?></p>
        </div>
        <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
          <?php echo htmlspecialchars($booking['status']); ?>
        </span>
      </div>
      <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Vehicle Information</h3>
        <div class="flex flex-col md:flex-row gap-6">
          <img src="<?php echo htmlspecialchars($booking['car_image']); ?>" alt="" class="w-full md:w-64 h-48 object-cover rounded-lg" />
          <div class="flex-1">
            <h4 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($booking['car_model']); ?></h4>
            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($booking['car_type']); ?></p>
            <!-- Add more car details here if needed -->
          </div>
        </div>
      </div>
      <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Rental Period</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-blue-50 rounded-lg p-4">
            <span class="font-semibold">Pick-up</span>
            <p class="text-lg font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($booking['pickup_date']); ?></p>
            <span><?php echo htmlspecialchars($booking['pickup_location']); ?></span>
          </div>
          <div class="bg-blue-50 rounded-lg p-4">
            <span class="font-semibold">Drop-off</span>
            <p class="text-lg font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($booking['dropoff_date']); ?></p>
            <span><?php echo htmlspecialchars($booking['dropoff_location']); ?></span>
          </div>
        </div>
      </div>
      <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Summary</h3>
        <div class="bg-gray-50 rounded-lg p-6">
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-700">Daily Rate</span>
              <span class="font-semibold text-gray-900">₱<?php echo htmlspecialchars($booking['daily_rate'] ?? '0.00'); ?></span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-700">Number of Days</span>
              <span class="font-semibold text-gray-900"><?php echo htmlspecialchars($booking['days'] ?? '1'); ?></span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-700">Subtotal</span>
              <span class="font-semibold text-gray-900">₱<?php echo htmlspecialchars($booking['subtotal'] ?? '0.00'); ?></span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-700">Tax (10%)</span>
              <span class="font-semibold text-gray-900">₱<?php echo htmlspecialchars($booking['tax'] ?? '0.00'); ?></span>
            </div>
            <div class="border-t pt-3 flex justify-between">
              <span class="text-lg font-bold text-gray-900">Total Amount</span>
              <span class="text-2xl font-bold text-blue-600">₱<?php echo htmlspecialchars($booking['total_amount']); ?></span>
            </div>
          </div>
        </div>
      </div>
      <!-- Add more sections as needed -->
    </div>
  </div>
</div>
<?php endif; ?>
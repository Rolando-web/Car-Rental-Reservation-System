<?php
// admin-bookings.php
session_start();
// TODO: Add authentication check for admin role
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
  $booking_id = $_POST['booking_id'];
  if (isset($_POST['approve'])) {
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'Approved' WHERE id = ?");
    $stmt->execute([$booking_id]);
  } elseif (isset($_POST['reject'])) {
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'Rejected' WHERE id = ?");
    $stmt->execute([$booking_id]);
  }
  header('Location: admin-bookings.php');
  exit;
}


$stmt = $pdo->query('SELECT r.id, c.full_name, car.car_model, r.status, r.created_at FROM reservations r JOIN customers c ON r.customer_id = c.id JOIN cars car ON r.car_id = car.car_id ORDER BY r.created_at DESC');
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Bookings - DriveEasy</title>
  <script src="https://cdn.tailwindcss.com"></script>
   <link rel="icon" href="icon.png" type="icon.png">
</head>
<body class="bg-gray-50">
  <?php include 'components/admin-nav.php'; ?>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Reservation Requests</h1>
    <div class="bg-white rounded-xl shadow p-8">  
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bookings as $booking): ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($booking['id']); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($booking['full_name']); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($booking['car_model']); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($booking['status']); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($booking['created_at']); ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <form method="POST" action="admin-bookings.php" style="display:inline;">
                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                <button type="submit" name="approve" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded mr-2">Approve</button>
                <button type="submit" name="reject" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reject</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
      <script src="js/signout.js">  </script>
</body>
</html>

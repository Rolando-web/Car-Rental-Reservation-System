
<?php
require_once 'database.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : false;
$notifications = [];
$unread_count = 0;
if ($user_id) {
  $sql = $is_admin
    ? "SELECT * FROM notifications WHERE is_admin = 1 ORDER BY created_at DESC LIMIT 10"
    : "SELECT * FROM notifications WHERE customer_id = ? ORDER BY created_at DESC LIMIT 10";
  $stmt = $pdo->prepare($sql);
  if ($is_admin) {
    $stmt->execute();
  } else {
    $stmt->execute([$user_id]);
  }
  $notifications = $stmt->fetchAll();
  $unread_sql = $is_admin
    ? "SELECT COUNT(*) FROM notifications WHERE is_admin = 1 AND is_read = 0"
    : "SELECT COUNT(*) FROM notifications WHERE customer_id = ? AND is_read = 0";
  $unread_stmt = $pdo->prepare($unread_sql);
  if ($is_admin) {
    $unread_stmt->execute();
  } else {
    $unread_stmt->execute([$user_id]);
  }
  $unread_count = $unread_stmt->fetchColumn();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DriveEasy - Premium Car Rentals</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="css/dark-theme.css">
     <link rel="icon" href="icon.png" type="icon.png">
    <meta
      property="og:image"
      content="https://bolt.new/static/og_default.png"
    />
    <meta name="twitter:card" content="summary_large_image" />
    <meta
      name="twitter:image"
      content="https://bolt.new/static/og_default.png"
    />
  </head>
  <body class="bg-gray-50">
<?php include 'components/navigator.php'; ?>

<div class="flex justify-end items-center max-w-7xl mx-auto mt-4 px-4">

      <?php if ($user_id): ?>
        <div class="relative mr-4">

          <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border border-gray-200">
            <div class="p-4 border-b font-bold text-gray-700">Notifications</div>
            <?php if (empty($notifications)): ?>
              <div class="p-4 text-gray-500 text-center">No notifications</div>
            <?php else: ?>
              <ul class="max-h-80 overflow-y-auto divide-y">
                <?php foreach ($notifications as $notif): ?>
                  <li class="p-4 <?php echo $notif['is_read'] ? 'bg-white' : 'bg-blue-50'; ?> text-gray-800 text-sm">
                    <?php echo htmlspecialchars($notif['message']); ?>
                    <div class="text-xs text-gray-400 mt-1"><?php echo date('M d, Y H:i', strtotime($notif['created_at'])); ?></div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <section
      class="bg-gradient-to-br from-red-700 to-red-800 text-white py-24 px-4"
    >
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
          Premium Car Rentals<br />
          Made Simple
        </h1>
        <p class="text-xl md:text-2xl text-red-100 max-w-3xl mx-auto">
          Choose from our fleet of luxury and economy vehicles. Book online in
          minutes and hit the road with confidence.
        </p>
      </div>
    </section>

<?php
$cars = $pdo->query("SELECT * FROM cars WHERE status = 'Available'")->fetchAll(PDO::FETCH_ASSOC);
?>
    <section id="cars" class="py-16 px-4 bg-gray-50">
      <div class="max-w-7xl mx-auto">
        <div class="mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-2">Available Vehicles</h2>
          <p class="text-gray-600 text-lg">Browse our selection of quality rental cars</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($cars as $car): ?>
          <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card">
            <div class="relative">
              <?php if ($car['car_image']): ?>
                <img src="<?php echo htmlspecialchars($car['car_image']); ?>" alt="<?php echo htmlspecialchars($car['car_model']); ?>" class="w-full h-56 object-cover" />
              <?php endif; ?>
              <span class="absolute top-4 right-4 bg-red-700 text-white px-3 py-1 rounded-full text-sm font-medium">
                <?php echo htmlspecialchars($car['status']); ?>
              </span>
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($car['car_model']); ?></h3>
              <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($car['car_type']); ?></p>
              <div class="flex items-center space-x-4 text-sm text-gray-600 mb-6">
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                  <span>Petrol</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">₱<?php echo htmlspecialchars($car['rental_rate']); ?></span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <a href="Reservation.php?car_id=<?php echo $car['car_id']; ?>">
                  <button class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition-colors">Book Now</button>
                </a>

              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

<?php include 'modals/car-details-modal.php'; ?>
<?php include 'components/footer.php'; ?>

    <script src="js/modal-loader.js"></script>
    <script>loadModal("modals/car-details-modal.html");</script>
    <script src="js/index.js"></script>
    <script src="js/signout.js"></script>
    <script>
function openCarModal(car) {
  // ...existing code...
}
function closeCarModal() {
  // ...existing code...
}

// Notification bell dropdown logic
document.addEventListener('DOMContentLoaded', function() {
  var bell = document.getElementById('notifBell');
  var dropdown = document.getElementById('notifDropdown');
  if (bell && dropdown) {
    bell.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
      if (!dropdown.contains(e.target) && !bell.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  }
});

// ...existing code for profile dropdown...
    </script>
  </body>
</html>

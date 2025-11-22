    <?php
    // Notification bell logic for navigation bar
    if (!function_exists('renderNotificationBell')) {
      require_once __DIR__ . '/../database.php';
      if (session_status() === PHP_SESSION_NONE) session_start();
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
      function renderNotificationBell() {
        global $user_id, $unread_count, $notifications;
        if (!$user_id) return;
        ?>
        <div class="relative mr-2">
          <button id="notifBell" class="relative focus:outline-none">
            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <?php if ($unread_count > 0): ?>
              <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 font-bold animate-pulse"><?php echo $unread_count; ?></span>
            <?php endif; ?>
          </button>
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
        <?php
      }
    }?>

<?php
// Notification bell logic for navigation bar
if (!function_exists('renderNotificationBell')) {
  require_once __DIR__ . '/../database.php';
  if (session_status() === PHP_SESSION_NONE) session_start();
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
  function renderNotificationBell() {
    global $user_id, $unread_count, $notifications;
    if (!$user_id) return;
    ?>
    <div class="relative mr-2">
      <button id="notifBell" class="relative focus:outline-none">
        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <?php if ($unread_count > 0): ?>
          <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 font-bold animate-pulse"><?php echo $unread_count; ?></span>
        <?php endif; ?>
      </button>
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
    <?php
  }
}
?>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <div class="flex items-center space-x-2">
        <div class="w-10 h-10 bg-red-700 rounded-full flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
          </svg>
        </div>
        <span class="text-xl font-bold text-gray-900">DriveEasy</span>
      </div>
      <div class="flex items-center space-x-8">
        <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'text-red-700' : 'text-gray-700 hover:text-red-700'; ?> font-medium">Home</a>
        <a href="index.php#cars" class="<?php echo $current_page == 'index.php' ? 'text-red-700' : 'text-gray-700 hover:text-red-700'; ?> font-medium">Cars</a>
        <a href="bookings.php" class="<?php echo $current_page == 'bookings.php' ? 'text-red-700' : 'text-gray-700 hover:text-red-700'; ?> font-medium">My Bookings</a>
        <div class="flex items-center space-x-4">
          <?php if (function_exists('renderNotificationBell')) renderNotificationBell(); ?>
          <div class="relative">
            <button id="profileButton" class="text-gray-700 hover:text-blue-600" onclick="toggleProfileDropdown()">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </button>
            <!-- Dropdown Menu -->
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
              <a href="bookings.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Bookings
              </a>
              <button onclick="signOut()" class="w-full flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors text-left">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign Out
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
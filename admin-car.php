<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Cars - DriveEasy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/dark-theme.css">
</head>
<body class="bg-gray-50">
  <?php include 'components/admin-nav.php'; ?>
  <?php
require_once 'database.php';
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
    <script src="js/signout.js">  </script>
</body>
</html>
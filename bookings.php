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
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <a href="index.html" class="flex items-center space-x-2">
            <div
              class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center"
            >
              <svg
                class="w-6 h-6 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"
                ></path>
              </svg>
            </div>
            <span class="text-xl font-bold text-gray-900">DriveEasy</span>
          </a>
          <div class="flex items-center space-x-8">
            <a
              href="index.php"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Home</a
            >
            <a
              href="index.php#cars"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Cars</a
            >
            <a href="reservation.php" class="text-blue-600 font-medium"
              >My Bookings</a
            >
            <div class="relative">
              <button
                id="profileButton"
                class="text-gray-700 hover:text-blue-600"
                onclick="toggleProfileDropdown()"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  ></path>
                </svg>
              </button>
              <!-- Dropdown Menu -->
              <div
                id="profileDropdown"
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
              >
                <a
                  href="bookings.html"
                  class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors"
                >
                  <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    ></path>
                  </svg>
                  My Bookings
                </a>
                <button
                  onclick="signOut()"
                  class="w-full flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors text-left"
                >
                  <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                    ></path>
                  </svg>
                  Sign Out
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-12">My Bookings</h1>

      <div id="bookingsContainer" class="space-y-6">
        <!-- Bookings will be dynamically inserted here -->
      </div>

      <!-- Empty State -->
      <div id="emptyState" class="hidden text-center py-16">
        <svg
          class="w-24 h-24 mx-auto text-gray-300 mb-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
          ></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">
          No bookings yet
        </h3>
        <p class="text-gray-500 mb-6">
          Start exploring our amazing cars and make your first booking!
        </p>
        <a
          href="index.html#cars"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors"
        >
          Browse Cars
        </a>
      </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-12 px-4 mt-16">
      <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <h3 class="font-bold text-gray-900 text-lg mb-4">
              Premium Car Rentals
            </h3>
            <p class="text-gray-600">
              Your trusted partner for quality vehicle rentals. Drive with
              confidence.
            </p>
          </div>

          <div>
            <h4 class="font-semibold text-gray-900 mb-4">Quick Links</h4>
            <ul class="space-y-2">
              <li>
                <a
                  href="index.html#cars"
                  class="text-gray-600 hover:text-blue-600"
                  >Browse Cars</a
                >
              </li>
              <li>
                <a
                  href="bookings.html"
                  class="text-gray-600 hover:text-blue-600"
                  >My Bookings</a
                >
              </li>
              <li>
                <a href="#" class="text-gray-600 hover:text-blue-600"
                  >Sign In</a
                >
              </li>
            </ul>
          </div>

          <div>
            <h4 class="font-semibold text-gray-900 mb-4">Support</h4>
            <ul class="space-y-2">
              <li>
                <a href="#" class="text-gray-600 hover:text-blue-600"
                  >Help Center</a
                >
              </li>
              <li>
                <a href="#" class="text-gray-600 hover:text-blue-600"
                  >Terms of Service</a
                >
              </li>
              <li>
                <a href="#" class="text-gray-600 hover:text-blue-600"
                  >Privacy Policy</a
                >
              </li>
            </ul>
          </div>

          <div>
            <h4 class="font-semibold text-gray-900 mb-4">Contact</h4>
            <ul class="space-y-2">
              <li>
                <a
                  href="mailto:support@carrental.com"
                  class="text-gray-600 hover:text-blue-600"
                  >support@carrental.com</a
                >
              </li>
              <li>
                <a
                  href="tel:1-800-RENT-CAR"
                  class="text-gray-600 hover:text-blue-600"
                  >1-800-RENT-CAR</a
                >
              </li>
              <li><span class="text-gray-600">24/7 Customer Service</span></li>
            </ul>
          </div>
        </div>

        <div
          class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600"
        >
          <p>&copy; 2025 Premium Car Rentals. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Modals will be loaded here dynamically -->
    <div id="modal-container"></div>

    <script src="js/modal-loader.js"></script>
    <script>
      loadModal("modals/booking-details-modal.html");
    </script>
    <script src="js/bookings.js"></script>
    <script>
      function toggleProfileDropdown() {
        const dropdown = document.getElementById("profileDropdown");
        dropdown.classList.toggle("hidden");
      }

      function signOut() {
        if (confirm("Are you sure you want to sign out?")) {
          localStorage.removeItem("currentUser");
          localStorage.removeItem("currentBooking");
          alert("You have been signed out successfully.");
          window.location.href = "login.html";
        }
      }

      // Check if user is logged in
      function checkAuthStatus() {
        const currentUser = localStorage.getItem("currentUser");
        if (!currentUser) {
          alert("Please sign in to view your bookings.");
          window.location.href = "login.html";
        }
      }

      // Close dropdown when clicking outside
      document.addEventListener("click", function (event) {
        const dropdown = document.getElementById("profileDropdown");
        const button = document.getElementById("profileButton");
        if (
          !dropdown.contains(event.target) &&
          !button.contains(event.target)
        ) {
          dropdown.classList.add("hidden");
        }
      });

      // Initialize auth check
      checkAuthStatus();
    </script>
  </body>
</html>

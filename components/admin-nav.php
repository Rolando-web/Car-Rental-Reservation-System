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
            <a href="admin-dashboard.php" class="text-blue-600 font-medium"
              >Dashboard</a
            >
            <a
              href="admin-active-bookings.php"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Active Bookings</a
            >
            <a
              href="Booking-pending.php"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Pending</a
            >
            <a
              href="admin-car.php"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Cars</a
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
                  href="admin-dashboard.html"
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
                  Dashboard
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
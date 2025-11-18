<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complete Your Booking - DriveEasy</title>
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
            <a
              href="bookings.php"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >My Bookings</a
            >
            <button class="text-gray-700 hover:text-blue-600">
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
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">
        Complete Your Booking
      </h1>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking Details Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
              Booking Details
            </h2>

            <form id="bookingForm">
              <!-- Date Inputs -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label
                    class="flex items-center text-gray-700 font-medium mb-2"
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
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                      ></path>
                    </svg>
                    Pick-up Date
                  </label>
                  <input
                    type="date"
                    id="pickupDate"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                  />
                </div>
                <div>
                  <label
                    class="flex items-center text-gray-700 font-medium mb-2"
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
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                      ></path>
                    </svg>
                    Drop-off Date
                  </label>
                  <input
                    type="date"
                    id="dropoffDate"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                  />
                </div>
              </div>

              <!-- Location Inputs -->
              <div class="mb-6">
                <label class="flex items-center text-gray-700 font-medium mb-2">
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
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    ></path>
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    ></path>
                  </svg>
                  Pick-up Location
                </label>
                <input
                  type="text"
                  id="pickupLocation"
                  placeholder="Enter pick-up address"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  required
                />
              </div>

              <div class="mb-6">
                <label class="flex items-center text-gray-700 font-medium mb-2">
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
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    ></path>
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    ></path>
                  </svg>
                  Drop-off Location
                </label>
                <input
                  type="text"
                  id="dropoffLocation"
                  placeholder="Enter drop-off address"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  required
                />
              </div>

              <!-- Additional Notes -->
              <div class="mb-6">
                <label class="text-gray-700 font-medium mb-2 block">
                  Additional Notes (Optional)
                </label>
                <textarea
                  id="additionalNotes"
                  rows="4"
                  placeholder="Any special requests or requirements?"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                ></textarea>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-lg font-semibold text-lg transition-colors"
              >
                Confirm Booking
              </button>
            </form>
          </div>
        </div>

        <!-- Booking Summary -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-8 sticky top-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
              Booking Summary
            </h2>

            <!-- Car Image -->
            <div class="mb-6">
              <img
                id="summaryCarImage"
                src=""
                alt="Car"
                class="w-full h-48 object-cover rounded-lg"
              />
            </div>

            <!-- Car Details -->
            <div class="mb-6">
              <h3
                id="summaryCarTitle"
                class="text-xl font-bold text-gray-900 mb-1"
              >
                Mercedes C-Class
              </h3>
              <p id="summaryCarSubtitle" class="text-gray-600">
                Mercedes-Benz C-Class
              </p>
            </div>

            <!-- Price -->
            <div class="border-t pt-6">
              <div class="flex items-baseline justify-between mb-2">
                <span class="text-gray-700 font-medium">Daily Rate</span>
                <span class="text-3xl font-bold text-gray-900"
                  >$<span id="summaryCarPrice">89.99</span
                  ><span class="text-sm text-gray-600 font-normal"
                    >/day</span
                  ></span
                >
              </div>
              <div id="totalSection" class="hidden mt-4 pt-4 border-t">
                <div class="flex items-center justify-between text-lg">
                  <span class="text-gray-700 font-medium"
                    >Total (<span id="totalDays">0</span> days)</span
                  >
                  <span class="text-2xl font-bold text-blue-600"
                    >$<span id="totalPrice">0.00</span></span
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
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
                <a href="#" class="text-gray-600 hover:text-blue-600"
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

    <script src="js/reservation.js"></script>
  </body>
</html>

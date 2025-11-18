<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DriveEasy - Premium Car Rentals</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center space-x-2">
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
          </div>
          <div class="flex items-center space-x-8">
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium"
              >Home</a
            >
            <a
              href="#cars"
              class="text-gray-700 hover:text-blue-600 font-medium"
              >Cars</a
            >
            <a
              href="bookings.php"
              class="text-gray-700 hover:text-blue-600 font-medium"
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

    <section
      class="bg-gradient-to-br from-blue-600 to-blue-700 text-white py-24 px-4"
    >
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
          Premium Car Rentals<br />
          Made Simple
        </h1>
        <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
          Choose from our fleet of luxury and economy vehicles. Book online in
          minutes and hit the road with confidence.
        </p>
      </div>
    </section>

    <section id="cars" class="py-16 px-4 bg-gray-50">
      <div class="max-w-7xl mx-auto">
        <div class="mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-2">
            Available Vehicles
          </h2>
          <p class="text-gray-600 text-lg">
            Browse our selection of quality rental cars
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card"
            onclick="openCarModal('Mercedes C-Class', 'Mercedes-Benz C-Class', 'https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg?auto=compress&cs=tinysrgb&w=800', '5', 'Automatic', 'Petrol', '89.99', 'Luxury sedan with premium features and comfort', ['Leather Seats', 'Bluetooth', 'Climate Control'], ['GPS Navigation', 'Backup Camera'])"
          >
            <div class="relative">
              <img
                src="https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="Mercedes C-Class"
                class="w-full h-56 object-cover"
              />
              <span
                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium"
                >available</span
              >
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1">
                Mercedes C-Class
              </h3>
              <p class="text-gray-600 mb-4">Mercedes-Benz</p>
              <div
                class="flex items-center space-x-4 text-sm text-gray-600 mb-6"
              >
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span>Petrol</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">$89.99</span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                >
                  Book Now
                </button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card"
            onclick="openCarModal('BMW 3 Series', 'BMW', 'https://images.pexels.com/photos/244206/pexels-photo-244206.jpeg?auto=compress&cs=tinysrgb&w=800', '5', 'Automatic', 'Diesel', '95.99', 'Premium sports sedan with dynamic performance', ['Leather Seats', 'Sunroof', 'Sport Seats'], ['GPS Navigation', 'Parking Sensors', 'Cruise Control'])"
          >
            <div class="relative">
              <img
                src="https://images.pexels.com/photos/244206/pexels-photo-244206.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="BMW 3 Series"
                class="w-full h-56 object-cover"
              />
              <span
                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium"
                >available</span
              >
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1">
                BMW 3 Series
              </h3>
              <p class="text-gray-600 mb-4">BMW</p>
              <div
                class="flex items-center space-x-4 text-sm text-gray-600 mb-6"
              >
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span>Diesel</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">$95.99</span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                >
                  Book Now
                </button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card"
            onclick="openCarModal('Toyota Camry', 'Toyota', 'https://images.pexels.com/photos/3764984/pexels-photo-3764984.jpeg?auto=compress&cs=tinysrgb&w=800', '5', 'Automatic', 'Hybrid', '65.99', 'Reliable and fuel-efficient family sedan', ['Bluetooth', 'Backup Camera', 'Lane Assist'], ['Adaptive Cruise Control', 'Blind Spot Monitor'])"
          >
            <div class="relative">
              <img
                src="https://images.pexels.com/photos/3764984/pexels-photo-3764984.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="Toyota Camry"
                class="w-full h-56 object-cover"
              />
              <span
                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium"
                >available</span
              >
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1">
                Toyota Camry
              </h3>
              <p class="text-gray-600 mb-4">Toyota</p>
              <div
                class="flex items-center space-x-4 text-sm text-gray-600 mb-6"
              >
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span>Hybrid</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">$65.99</span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                >
                  Book Now
                </button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card"
            onclick="openCarModal('Tesla Model 3', 'Tesla', 'https://images.pexels.com/photos/4173251/pexels-photo-4173251.jpeg?auto=compress&cs=tinysrgb&w=800', '5', 'Automatic', 'Electric', '99.99', 'Cutting-edge electric vehicle with autopilot', ['Autopilot', 'Premium Audio', 'Glass Roof'], ['Supercharger Access', 'Mobile App Control', '360° Camera'])"
          >
            <div class="relative">
              <img
                src="https://images.pexels.com/photos/4173251/pexels-photo-4173251.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="Tesla Model 3"
                class="w-full h-56 object-cover"
              />
              <span
                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium"
                >available</span
              >
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1">
                Tesla Model 3
              </h3>
              <p class="text-gray-600 mb-4">Tesla</p>
              <div
                class="flex items-center space-x-4 text-sm text-gray-600 mb-6"
              >
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span>Electric</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">$99.99</span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                >
                  Book Now
                </button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card"
            onclick="openCarModal('Honda Civic', 'Honda', 'https://images.pexels.com/photos/2127733/pexels-photo-2127733.jpeg?auto=compress&cs=tinysrgb&w=800', '5', 'Automatic', 'Petrol', '55.99', 'Compact and efficient daily driver', ['Bluetooth', 'USB Ports', 'Climate Control'], ['Backup Camera', 'Apple CarPlay', 'Android Auto'])"
          >
            <div class="relative">
              <img
                src="https://images.pexels.com/photos/2127733/pexels-photo-2127733.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="Honda Civic"
                class="w-full h-56 object-cover"
              />
              <span
                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium"
                >available</span
              >
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1">Honda Civic</h3>
              <p class="text-gray-600 mb-4">Honda</p>
              <div
                class="flex items-center space-x-4 text-sm text-gray-600 mb-6"
              >
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span>Petrol</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">$55.99</span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                >
                  Book Now
                </button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow cursor-pointer car-card"
            onclick="openCarModal('Audi A4', 'Audi', 'https://images.pexels.com/photos/909907/pexels-photo-909907.jpeg?auto=compress&cs=tinysrgb&w=800', '5', 'Automatic', 'Petrol', '85.99', 'Sophisticated luxury sedan with advanced technology', ['Leather Interior', 'Virtual Cockpit', 'LED Headlights'], ['GPS Navigation', 'Parking Assist', 'Heated Seats'])"
          >
            <div class="relative">
              <img
                src="https://images.pexels.com/photos/909907/pexels-photo-909907.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="Audi A4"
                class="w-full h-56 object-cover"
              />
              <span
                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium"
                >available</span
              >
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-1">Audi A4</h3>
              <p class="text-gray-600 mb-4">Audi</p>
              <div
                class="flex items-center space-x-4 text-sm text-gray-600 mb-6"
              >
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                  <span>5</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    ></path>
                  </svg>
                  <span>Automatic</span>
                </div>
                <div class="flex items-center space-x-1">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span>Petrol</span>
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-3xl font-bold text-gray-900">$85.99</span>
                  <span class="text-gray-600 text-sm"> per day</span>
                </div>
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                >
                  Book Now
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-white border-t border-gray-200 py-12 px-4">
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
                <a href="#" class="text-gray-600 hover:text-blue-600"
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

    <div id="modal-container"></div>
    <script src="js/modal-loader.js"></script>
    <script>
      loadModal("modals/car-details-modal.html");
    </script>
    <script src="js/index.js"></script>
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
          window.location.href = "login.php";
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
    </script>
  </body>
</html>

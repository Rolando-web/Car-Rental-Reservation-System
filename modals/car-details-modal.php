<!-- Car Details Modal -->
<div
  id="carModal"
  class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
>
  <div
    class="bg-white rounded-2xl max-w-6xl w-full max-h-[90vh] overflow-y-auto"
  >
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
      <!-- Left side - Car Image -->
      <div class="bg-gray-100 p-8 flex items-center justify-center">
        <img
          id="modalCarImage"
          src=""
          alt=""
          class="w-full h-auto object-contain rounded-lg"
        />
      </div>

      <!-- Right side - Car Details -->
      <div class="p-8 lg:p-12 relative">
        <!-- Close button -->
        <button
          onclick="closeCarModal()"
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
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
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </button>

        <!-- Car Title -->
        <div class="mb-6">
          <h2 id="modalCarTitle" class="text-4xl font-bold text-gray-900 mb-2">
            Mercedes C-Class
          </h2>
          <p id="modalCarSubtitle" class="text-xl text-gray-600">
            Mercedes-Benz C-Class
          </p>
        </div>

        <!-- Description -->
        <p id="modalCarDescription" class="text-gray-600 mb-6">
          Luxury sedan with premium features and comfort
        </p>

        <!-- Specs Grid -->
        <div class="grid grid-cols-3 gap-4 mb-8 bg-gray-50 rounded-xl p-6">
          <div class="text-center">
            <svg
              class="w-8 h-8 mx-auto mb-2 text-blue-600"
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
            <div class="text-sm text-gray-600 mb-1">Seats</div>
            <div id="modalCarSeats" class="text-lg font-bold text-gray-900">
              5
            </div>
          </div>
          <div class="text-center">
            <svg
              class="w-8 h-8 mx-auto mb-2 text-blue-600"
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
            <div class="text-sm text-gray-600 mb-1">Transmission</div>
            <div
              id="modalCarTransmission"
              class="text-lg font-bold text-gray-900"
            >
              Automatic
            </div>
          </div>
          <div class="text-center">
            <svg
              class="w-8 h-8 mx-auto mb-2 text-blue-600"
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
            <div class="text-sm text-gray-600 mb-1">Fuel</div>
            <div id="modalCarFuel" class="text-lg font-bold text-gray-900">
              Petrol
            </div>
          </div>
        </div>

        <!-- Features -->
        <div class="mb-8">
          <h3 class="text-xl font-bold text-gray-900 mb-4">Features</h3>
          <div
            class="grid grid-cols-1 md:grid-cols-2 gap-3"
            id="modalFeaturesList"
          >
            <!-- Features will be inserted here -->
          </div>
        </div>

        <!-- Price and Book Button -->
        <div class="border-t pt-6">
          <div class="mb-4">
            <div class="text-sm text-gray-600 mb-1">Daily Rate</div>
            <div class="text-4xl font-bold text-gray-900">
              $<span id="modalCarPrice">89.99</span>
            </div>
          </div>
          <button
            onclick="proceedToBooking()"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-lg font-semibold text-lg transition-colors"
          >
            Proceed to Booking
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

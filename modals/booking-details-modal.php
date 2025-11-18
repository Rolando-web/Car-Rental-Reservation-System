<!-- Booking Details Modal -->
<div
  id="detailsModal"
  class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
>
  <div
    class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
  >
    <div
      class="sticky top-0 bg-white border-b border-gray-200 px-8 py-6 flex items-center justify-between"
    >
      <h2 class="text-3xl font-bold text-gray-900">Booking Details</h2>
      <button
        onclick="closeDetailsModal()"
        class="text-gray-400 hover:text-gray-600"
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
    </div>

    <div class="p-8">
      <!-- Booking ID and Status -->
      <div class="flex items-center justify-between mb-6 pb-6 border-b">
        <div>
          <p class="text-sm text-gray-600 mb-1">Booking ID</p>
          <p id="modalBookingId" class="text-xl font-bold text-gray-900">
            #000000
          </p>
        </div>
        <span
          id="modalStatus"
          class="px-4 py-2 rounded-full text-sm font-medium"
          >Status</span
        >
      </div>

      <!-- Car Details -->
      <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
          Vehicle Information
        </h3>
        <div class="flex flex-col md:flex-row gap-6">
          <img
            id="modalCarImage"
            src=""
            alt=""
            class="w-full md:w-64 h-48 object-cover rounded-lg"
          />
          <div class="flex-1">
            <h4
              id="modalCarTitle"
              class="text-2xl font-bold text-gray-900 mb-2"
            >
              Car Name
            </h4>
            <p id="modalCarSubtitle" class="text-gray-600 mb-4">Car Subtitle</p>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-600">Vehicle Type</p>
                <p class="font-semibold text-gray-900">Luxury Sedan</p>
              </div>
              <div>
                <p class="text-sm text-gray-600">Transmission</p>
                <p class="font-semibold text-gray-900">Automatic</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Rental Period -->
      <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Rental Period</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center space-x-2 text-blue-600 mb-2">
              <svg
                class="w-5 h-5"
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
              <span class="font-semibold">Pick-up</span>
            </div>
            <p
              id="modalPickupDate"
              class="text-lg font-bold text-gray-900 mb-2"
            >
              11/28/2025
            </p>
            <div class="flex items-start space-x-2 text-gray-700">
              <svg
                class="w-5 h-5 mt-0.5"
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
              <span id="modalPickupLocation">Location</span>
            </div>
          </div>

          <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center space-x-2 text-blue-600 mb-2">
              <svg
                class="w-5 h-5"
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
              <span class="font-semibold">Drop-off</span>
            </div>
            <p
              id="modalDropoffDate"
              class="text-lg font-bold text-gray-900 mb-2"
            >
              11/30/2025
            </p>
            <div class="flex items-start space-x-2 text-gray-700">
              <svg
                class="w-5 h-5 mt-0.5"
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
              <span id="modalDropoffLocation">Location</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Summary -->
      <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Summary</h3>
        <div class="bg-gray-50 rounded-lg p-6">
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-700">Daily Rate</span>
              <span class="font-semibold text-gray-900" id="modalDailyRate"
                >$0.00</span
              >
            </div>
            <div class="flex justify-between">
              <span class="text-gray-700">Number of Days</span>
              <span class="font-semibold text-gray-900" id="modalDays">0</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-700">Subtotal</span>
              <span class="font-semibold text-gray-900" id="modalSubtotal"
                >$0.00</span
              >
            </div>
            <div class="flex justify-between">
              <span class="text-gray-700">Tax (10%)</span>
              <span class="font-semibold text-gray-900" id="modalTax"
                >$0.00</span
              >
            </div>
            <div class="border-t pt-3 flex justify-between">
              <span class="text-lg font-bold text-gray-900">Total Amount</span>
              <span class="text-2xl font-bold text-blue-600" id="modalTotal"
                >$0.00</span
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Information -->
      <div id="modalNotesSection" class="mb-6 hidden">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Additional Notes</h3>
        <div class="bg-gray-50 rounded-lg p-4">
          <p id="modalNotes" class="text-gray-700"></p>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-col sm:flex-row gap-3">
        <button
          onclick="printBooking()"
          class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-900 py-3 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2"
        >
          <svg
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
            ></path>
          </svg>
          <span>Print</span>
        </button>
        <button
          onclick="downloadReceipt()"
          class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2"
        >
          <svg
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            ></path>
          </svg>
          <span>Download Receipt</span>
        </button>
      </div>
    </div>
  </div>
</div>

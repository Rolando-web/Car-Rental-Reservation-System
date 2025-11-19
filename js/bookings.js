// Sample booking data - In production, this would come from a database
const sampleBookings = [
  {
    id: 1,
    car: {
      title: "BMW 3 Series",
      subtitle: "BMW 3 Series",
      image:
        "https://images.pexels.com/photos/244206/pexels-photo-244206.jpeg?auto=compress&cs=tinysrgb&w=400",
    },
    dates: {
      pickup: "2025-11-28",
      dropoff: "2025-11-26",
    },
    locations: {
      pickup: "Matina Crossing",
      dropoff: "CCD",
    },
    total: "0",
    status: "pending",
  },
  {
    id: 2,
    car: {
      title: "Toyota Camry",
      subtitle: "Toyota Camry",
      image:
        "https://images.pexels.com/photos/3764984/pexels-photo-3764984.jpeg?auto=compress&cs=tinysrgb&w=400",
    },
    dates: {
      pickup: "2025-12-01",
      dropoff: "2025-12-05",
    },
    locations: {
      pickup: "Downtown Office",
      dropoff: "Airport Terminal",
    },
    total: "263.96",
    status: "confirmed",
  },
];

function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    month: "2-digit",
    day: "2-digit",
    year: "numeric",
  });
}

function getStatusBadge(status) {
  const badges = {
    pending: "bg-yellow-100 text-yellow-800",
    confirmed: "bg-green-100 text-green-800",
    completed: "bg-blue-100 text-blue-800",
    cancelled: "bg-red-100 text-red-800",
  };
  return badges[status] || badges.pending;
}

function createBookingCard(booking) {
  return `
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="flex flex-col lg:flex-row gap-6 p-6">
        <!-- Car Image -->
        <div class="flex-shrink-0">
          <img
            src="${booking.car.image}"
            alt="${booking.car.title}"
            class="w-full lg:w-64 h-48 object-cover rounded-lg"
          />
        </div>

        <!-- Booking Details -->
        <div class="flex-1">
          <div class="flex items-start justify-between mb-4 flex-wrap gap-4">
            <div>
              <h2 class="text-2xl font-bold text-gray-900 mb-1">
                ${booking.car.title}
              </h2>
              <p class="text-gray-600">${booking.car.subtitle}</p>
            </div>
            <span class="${getStatusBadge(
              booking.status
            )} px-4 py-2 rounded-full text-sm font-medium">
              ${booking.status}
            </span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Pick-up -->
            <div>
              <div class="flex items-center space-x-2 text-blue-600 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-semibold text-gray-900">Pick-up</span>
              </div>
              <p class="text-blue-600 font-semibold mb-1">${formatDate(
                booking.dates.pickup
              )}</p>
              <div class="flex items-center space-x-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>${booking.locations.pickup}</span>
              </div>
            </div>

            <!-- Drop-off -->
            <div>
              <div class="flex items-center space-x-2 text-blue-600 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-semibold text-gray-900">Drop-off</span>
              </div>
              <p class="text-blue-600 font-semibold mb-1">${formatDate(
                booking.dates.dropoff
              )}</p>
              <div class="flex items-center space-x-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>${booking.locations.dropoff}</span>
              </div>
            </div>
          </div>

          <!-- Total Amount -->
          <div>
            <p class="text-gray-600 text-sm mb-1">Total Amount</p>
            <p class="text-3xl font-bold text-gray-900">$${booking.total}</p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-3 justify-center lg:justify-end">
          <button
            onclick="viewDetails(${booking.id})"
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap"
          >
            View Details
          </button>
          <button
            onclick="cancelBooking(${booking.id})"
            class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-colors whitespace-nowrap"
          >
            Cancel Booking
          </button>
        </div>
      </div>
    </div>
  `;
}

function loadBookings() {
  // Try to load bookings from localStorage
  const storedBooking = localStorage.getItem("currentBooking");
  let bookings = [...sampleBookings];

  if (storedBooking) {
    const booking = JSON.parse(storedBooking);
    // Add the stored booking with a new ID
    bookings.unshift({
      id: Date.now(),
      car: booking.car,
      dates: booking.dates,
      locations: booking.locations,
      total: booking.total,
      days: booking.days,
      notes: booking.notes,
      status: "confirmed",
    });
  }

  const container = document.getElementById("bookingsContainer");
  const emptyState = document.getElementById("emptyState");

  if (bookings.length === 0) {
    container.classList.add("hidden");
    emptyState.classList.remove("hidden");
  } else {
    container.classList.remove("hidden");
    emptyState.classList.add("hidden");
    container.innerHTML = bookings
      .map((booking) => createBookingCard(booking))
      .join("");
  }
}

function viewDetails(bookingId) {
  // Find the booking
  const storedBooking = localStorage.getItem("currentBooking");
  let allBookings = [...sampleBookings];

  if (storedBooking) {
    const booking = JSON.parse(storedBooking);
    allBookings.unshift({
      id: Date.now(),
      car: booking.car,
      dates: booking.dates,
      locations: booking.locations,
      total: booking.total,
      days: booking.days,
      notes: booking.notes,
      status: "confirmed",
    });
  }

  const booking = allBookings.find((b) => b.id === bookingId);
  if (!booking) return;

  // Populate modal
  document.getElementById("modalBookingId").textContent = `#${bookingId}`;
  document.getElementById("modalStatus").textContent = booking.status;
  document.getElementById(
    "modalStatus"
  ).className = `px-4 py-2 rounded-full text-sm font-medium ${getStatusBadge(
    booking.status
  )}`;

  document.getElementById("modalCarImage").src = booking.car.image;
  document.getElementById("modalCarImage").alt = booking.car.title;
  document.getElementById("modalCarTitle").textContent = booking.car.title;
  document.getElementById("modalCarSubtitle").textContent =
    booking.car.subtitle;

  document.getElementById("modalPickupDate").textContent = formatDate(
    booking.dates.pickup
  );
  document.getElementById("modalPickupLocation").textContent =
    booking.locations.pickup;
  document.getElementById("modalDropoffDate").textContent = formatDate(
    booking.dates.dropoff
  );
  document.getElementById("modalDropoffLocation").textContent =
    booking.locations.dropoff;

  // Calculate days and pricing
  const pickup = new Date(booking.dates.pickup);
  const dropoff = new Date(booking.dates.dropoff);
  const days =
    Math.ceil(Math.abs(dropoff - pickup) / (1000 * 60 * 60 * 24)) ||
    booking.days ||
    1;
  const total = parseFloat(booking.total) || 0;
  const dailyRate = days > 0 ? (total / days).toFixed(2) : "0.00";
  const subtotal = total.toFixed(2);
  const tax = (total * 0.1).toFixed(2);
  const totalWithTax = (total * 1.1).toFixed(2);

  document.getElementById("modalDailyRate").textContent = `$${dailyRate}`;
  document.getElementById("modalDays").textContent = days;
  document.getElementById("modalSubtotal").textContent = `$${subtotal}`;
  document.getElementById("modalTax").textContent = `$${tax}`;
  document.getElementById("modalTotal").textContent = `$${totalWithTax}`;

  // Show notes if available
  if (booking.notes) {
    document.getElementById("modalNotes").textContent = booking.notes;
    document.getElementById("modalNotesSection").classList.remove("hidden");
  } else {
    document.getElementById("modalNotesSection").classList.add("hidden");
  }

  // Store current booking ID for print/download
  window.currentBookingId = bookingId;

  // Show modal
  document.getElementById("detailsModal").classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

function closeDetailsModal() {
  document.getElementById("detailsModal").classList.add("hidden");
  document.body.style.overflow = "auto";
}

function printBooking() {
  alert(
    "Opening print dialog...\n\nIn production, this would generate a printable booking confirmation with all details."
  );
}

function downloadReceipt() {
  alert(
    "Downloading receipt...\n\nIn production, this would download a PDF receipt with booking details and payment information."
  );
}

function cancelBooking(bookingId) {
  if (
    confirm(
      "Are you sure you want to cancel this booking?\n\nThis action cannot be undone and cancellation fees may apply."
    )
  ) {
    alert(
      `Booking #${bookingId} has been cancelled successfully.\n\nA confirmation email has been sent to your registered email address.`
    );

    setTimeout(() => {
      window.location.reload();
    }, 1500);
  }
}


document.addEventListener("DOMContentLoaded", function () {
  loadBookings();

  if (detailsModal) {
    detailsModal.addEventListener("click", function (e) {
      if (e.target === this) {
        closeDetailsModal();
      }
    });
  }

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeDetailsModal();
    }
  });
});

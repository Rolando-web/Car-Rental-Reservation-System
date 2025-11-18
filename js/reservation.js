// Get car details from URL parameters
const urlParams = new URLSearchParams(window.location.search);
const carTitle = urlParams.get("title") || "Mercedes C-Class";
const carSubtitle = urlParams.get("subtitle") || "Mercedes-Benz C-Class";
const carImage =
  urlParams.get("image") ||
  "https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg?auto=compress&cs=tinysrgb&w=800";
const carPrice = urlParams.get("price") || "89.99";

// Populate summary section
document.getElementById("summaryCarTitle").textContent = carTitle;
document.getElementById("summaryCarSubtitle").textContent = carSubtitle;
document.getElementById("summaryCarImage").src = carImage;
document.getElementById("summaryCarImage").alt = carTitle;
document.getElementById("summaryCarPrice").textContent = carPrice;

// Set minimum date to today
const today = new Date().toISOString().split("T")[0];
document.getElementById("pickupDate").min = today;
document.getElementById("dropoffDate").min = today;

// Calculate total price based on dates
function calculateTotal() {
  const pickupDate = document.getElementById("pickupDate").value;
  const dropoffDate = document.getElementById("dropoffDate").value;

  if (pickupDate && dropoffDate) {
    const pickup = new Date(pickupDate);
    const dropoff = new Date(dropoffDate);
    const diffTime = Math.abs(dropoff - pickup);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays > 0 && dropoff > pickup) {
      const total = (parseFloat(carPrice) * diffDays).toFixed(2);
      document.getElementById("totalDays").textContent = diffDays;
      document.getElementById("totalPrice").textContent = total;
      document.getElementById("totalSection").classList.remove("hidden");
    } else {
      document.getElementById("totalSection").classList.add("hidden");
    }
  }
}

// Update dropoff min date when pickup date changes
document.getElementById("pickupDate").addEventListener("change", function () {
  const pickupDate = this.value;
  document.getElementById("dropoffDate").min = pickupDate;
  calculateTotal();
});

document
  .getElementById("dropoffDate")
  .addEventListener("change", calculateTotal);

// Handle form submission
document.getElementById("bookingForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const pickupDate = document.getElementById("pickupDate").value;
  const dropoffDate = document.getElementById("dropoffDate").value;
  const pickupLocation = document.getElementById("pickupLocation").value;
  const dropoffLocation = document.getElementById("dropoffLocation").value;
  const additionalNotes = document.getElementById("additionalNotes").value;

  // Validate dates
  const pickup = new Date(pickupDate);
  const dropoff = new Date(dropoffDate);

  if (dropoff <= pickup) {
    alert("Drop-off date must be after pick-up date.");
    return;
  }

  // Create booking object
  const booking = {
    car: {
      title: carTitle,
      subtitle: carSubtitle,
      image: carImage,
      price: carPrice,
    },
    dates: {
      pickup: pickupDate,
      dropoff: dropoffDate,
    },
    locations: {
      pickup: pickupLocation,
      dropoff: dropoffLocation,
    },
    notes: additionalNotes,
    total: document.getElementById("totalPrice").textContent,
    days: document.getElementById("totalDays").textContent,
  };

  // Save to localStorage (in real app, send to server)
  localStorage.setItem("currentBooking", JSON.stringify(booking));

  // Show confirmation
  alert(
    `Booking Confirmed!\n\nCar: ${carTitle}\nTotal: $${booking.total} for ${booking.days} days\n\nThank you for choosing DriveEasy!`
  );

  // Redirect to home page
  window.location.href = "index.html";
});

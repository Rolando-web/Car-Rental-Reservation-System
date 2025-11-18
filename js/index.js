// Car Modal Functions
function openCarModal(
  title,
  subtitle,
  image,
  seats,
  transmission,
  fuel,
  price,
  description,
  features1,
  features2
) {
  document.getElementById("modalCarTitle").textContent = title;
  document.getElementById("modalCarSubtitle").textContent = subtitle;
  document.getElementById("modalCarImage").src = image;
  document.getElementById("modalCarImage").alt = title;
  document.getElementById("modalCarSeats").textContent = seats;
  document.getElementById("modalCarTransmission").textContent = transmission;
  document.getElementById("modalCarFuel").textContent = fuel;
  document.getElementById("modalCarPrice").textContent = price;
  document.getElementById("modalCarDescription").textContent = description;

  // Populate features
  const featuresList = document.getElementById("modalFeaturesList");
  featuresList.innerHTML = "";

  const allFeatures = [...features1, ...features2];
  allFeatures.forEach((feature) => {
    const featureDiv = document.createElement("div");
    featureDiv.className = "flex items-center space-x-2";
    featureDiv.innerHTML = `
      <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <span class="text-gray-700">${feature}</span>
    `;
    featuresList.appendChild(featureDiv);
  });

  document.getElementById("carModal").classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

function closeCarModal() {
  document.getElementById("carModal").classList.add("hidden");
  document.body.style.overflow = "auto";
}

function proceedToBooking() {
  const title = document.getElementById("modalCarTitle").textContent;
  const subtitle = document.getElementById("modalCarSubtitle").textContent;
  const image = document.getElementById("modalCarImage").src;
  const price = document.getElementById("modalCarPrice").textContent;

  // Pass car data via URL parameters
  const params = new URLSearchParams({
    title: title,
    subtitle: subtitle,
    image: image,
    price: price,
  });

  window.location.href = `Reservation.html?${params.toString()}`;
}

// Event Listeners
document.addEventListener("DOMContentLoaded", function () {
  // Close modal when clicking outside
  const carModal = document.getElementById("carModal");
  if (carModal) {
    carModal.addEventListener("click", function (e) {
      if (e.target === this) {
        closeCarModal();
      }
    });
  }

  // Close modal with Escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeCarModal();
    }
  });
});

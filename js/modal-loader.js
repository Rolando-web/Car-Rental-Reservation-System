// Modal Loader Utility
// This script loads modal HTML files into the page

async function loadModal(modalPath, containerId = "modal-container") {
  try {
    const response = await fetch(modalPath);
    if (!response.ok) {
      throw new Error(`Failed to load modal: ${response.statusText}`);
    }
    const html = await response.text();

    // Create container if it doesn't exist
    let container = document.getElementById(containerId);
    if (!container) {
      container = document.createElement("div");
      container.id = containerId;
      document.body.appendChild(container);
    }

    // Insert modal HTML
    container.insertAdjacentHTML("beforeend", html);
  } catch (error) {
    console.error("Error loading modal:", error);
  }
}

// Load multiple modals
async function loadModals(modals) {
  const promises = modals.map((modal) =>
    loadModal(modal.path, modal.containerId)
  );
  await Promise.all(promises);
}

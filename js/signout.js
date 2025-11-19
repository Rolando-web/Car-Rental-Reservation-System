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
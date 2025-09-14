//submenu functionality for navbar
document.querySelectorAll(".dropdown-submenu").forEach(function (el) {
  el.addEventListener("mouseleave", function () {
    const submenu = el.querySelector(".dropdown-menu");
    if (submenu) {
      setTimeout(() => (submenu.style.display = "none"), 150); // small delay before hiding
    }
  });

  el.addEventListener("mouseenter", function () {
    const submenu = el.querySelector(".dropdown-menu");
    if (submenu) {
      submenu.style.display = "block";
    }
  });
});


// form slider functionality
document.addEventListener("DOMContentLoaded", () => {
  const slider = document.querySelector(".form-slider");
  const showSignup = document.getElementById("showSignup");
  const showLogin = document.getElementById("showLogin");
  const accountDropdownMenu = document.getElementById("accountDropdownMenu");

  // Prevent dropdown from closing on inside clicks
  if (accountDropdownMenu) {
    accountDropdownMenu.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  }

  if (showSignup) {
    showSignup.addEventListener("click", (e) => {
      e.preventDefault();
      slider.style.transform = "translateX(-50%)"; // slide left to show signup
    });
  }

  if (showLogin) {
    showLogin.addEventListener("click", (e) => {
      e.preventDefault();
      slider.style.transform = "translateX(0%)"; // slide back to login
    });
  }
});


document.addEventListener("DOMContentLoaded", () => {
  const searchToggle = document.getElementById("searchToggle");
  const searchInput = document.getElementById("navbarSearchInput");

  if (searchToggle && searchInput) {
    searchToggle.addEventListener("click", () => {
      searchInput.classList.toggle("show");
      if (searchInput.classList.contains("show")) {
        searchInput.focus();
      }
    });
  }
});

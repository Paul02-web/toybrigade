// This file contains the JavaScript code for handling the sidebar toggle, theme switching, and dynamic content loading.

const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");
const links = document.querySelectorAll(".sidebar a");
const sections = document.querySelectorAll(".content-section");

menuToggle.addEventListener("click", () => {
  sidebar.classList.toggle("active");
});

links.forEach(link => {
  link.addEventListener("click", () => {
    links.forEach(l => l.classList.remove("active"));
    link.classList.add("active");
    sections.forEach(sec => sec.classList.remove("active"));
    document.querySelector(link.getAttribute("href")).classList.add("active");
    if (window.innerWidth <= 992) sidebar.classList.remove("active");
  });
});

const themeSwitch = document.getElementById("themeSwitch");

// Check saved theme in localStorage
if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-mode");
  themeSwitch.checked = true;
} else {
  document.body.classList.add("light-mode");
}

// Toggle theme on switch
themeSwitch.addEventListener("change", () => {
  if (themeSwitch.checked) {
    document.body.classList.remove("light-mode");
    document.body.classList.add("dark-mode");
    localStorage.setItem("theme", "dark");
  } else {
    document.body.classList.remove("dark-mode");
    document.body.classList.add("light-mode");
    localStorage.setItem("theme", "light");
  }
});
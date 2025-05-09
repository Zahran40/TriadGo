import './bootstrap';

document.getElementById("darkModeToggle").addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");

    // Ubah teks tombol
    const isDark = document.body.classList.contains("dark-mode");
    this.textContent = isDark ? "Light Mode" : "Dark Mode";
  });


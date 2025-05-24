// portofolio/js/script.js

// --- Jam Digital WIB ---
function updateClock() {
    const now = new Date();

    // Opsi 1: Menggunakan Intl.DateTimeFormat (lebih modern dan direkomendasikan)
    // Akan otomatis menangani zona waktu jika browser support.
    // Jika tidak bekerja sesuai ekspektasi (misal, zona waktu browser bukan WIB),
    // Anda bisa coba Opsi 2.
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false, // Format 24 jam
        timeZone: 'Asia/Jakarta' // Zona waktu WIB
    };
    const formatter = new Intl.DateTimeFormat('en-US', options);
    const wibTime = formatter.format(now);
    
    // Opsi 2: Perhitungan manual offset WIB (Jika Opsi 1 tidak bekerja konsisten)
    // const utc = now.getTime() + (now.getTimezoneOffset() * 60000); // UTC time
    // const wibOffset = 7 * 3600000; // WIB is UTC+7 hours
    // const wibDate = new Date(utc + wibOffset);

    // const hours = String(wibDate.getHours()).padStart(2, '0');
    // const minutes = String(wibDate.getMinutes()).padStart(2, '0');
    // const seconds = String(wibDate.getSeconds()).padStart(2, '0');
    // const wibTime = `${hours}:${minutes}:${seconds}`;

    const clockElement = document.getElementById('digital-clock');
    if (clockElement) {
        clockElement.textContent = wibTime;
    }
}

// Perbarui jam setiap detik
setInterval(updateClock, 1000);
// Panggil sekali saat load untuk menampilkan jam langsung
updateClock();

// --- General Functions (Optional, bisa ditambahkan nanti) ---
// Contoh: smooth scrolling untuk navigasi
document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - document.querySelector('header').offsetHeight, // Kurangi tinggi header
                behavior: 'smooth'
            });
        }
    });
});
// admin.portofolio_anda.com/js/admin_script.js

// Contoh JavaScript untuk konfirmasi hapus
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete-confirm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const confirmDelete = confirm('Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.');
            if (!confirmDelete) {
                e.preventDefault(); // Batalkan aksi jika pengguna membatalkan
            }
        });
    });
});
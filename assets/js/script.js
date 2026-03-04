function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

// Simple client-side validation example
function confirmDelete() {
    return confirm("Apakah Anda yakin ingin menghapus data ini?");
}

document.addEventListener('DOMContentLoaded', () => {
    // Auto-hide alerts after 3 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});

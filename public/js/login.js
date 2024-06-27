function showToast(message) {
    var toastContainer = document.getElementById('toastContainer');
    var toast = document.createElement('div');
    
    toast.classList.add('toast');
    toast.textContent = message;
    toastContainer.appendChild(toast);
    toast.style.display = 'block';

    setTimeout(function() {
        toast.style.display = 'none';
        toastContainer.removeChild(toast);
    }, 4000);
}

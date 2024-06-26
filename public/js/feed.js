document.addEventListener('DOMContentLoaded', function() {
    const plusButton = document.querySelector('.plus-button');
    const dropdownContent = document.querySelector('.dropdown-content-add');

    plusButton.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdownContent.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!dropdownContent.contains(event.target) && !plusButton.contains(event.target)) {
            dropdownContent.classList.remove('show');
        }
    });
});

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
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-list li a');

    tabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();

            const targetId = this.getAttribute('href');
            const targetTab = document.querySelector(targetId);
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });

            if (targetTab) {
                targetTab.style.display = 'block';
            }
        });
    });
});

function showToast(message, type = 'success') {
    var toastContainer = document.getElementById('toastContainer');
    var toast = document.createElement('div');
    toast.classList.add('toast');
    toast.classList.add(type);
    toast.textContent = message;
    toastContainer.appendChild(toast);
    toast.style.display = 'block';

    setTimeout(function() {
        toast.style.display = 'none';
        toastContainer.removeChild(toast);
    }, 4000);
}

const changePasswordCheckbox = document.getElementById('changePasswordCheckbox');
        const passwordField = document.getElementById('passwordField');

        changePasswordCheckbox.addEventListener('change', function() {
            passwordField.disabled = !this.checked;
            if (!this.checked) {
                passwordField.value = '';
            }
        });
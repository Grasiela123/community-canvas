document.addEventListener('DOMContentLoaded', function() {
    let optionCounter = 3;

    function addOption() {
        let optionsContainer = document.getElementById('options-container');
        let newOptionGroup = document.createElement('div');
        newOptionGroup.classList.add('form-group');

        let newLabel = document.createElement('label');
        newLabel.setAttribute('for', 'option' + optionCounter);
        newLabel.textContent = 'Opsi ' + optionCounter + ': ';

        let newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('id', 'option' + optionCounter);
        newInput.setAttribute('name', 'options[]');
        newInput.classList.add('form-control');

        newOptionGroup.appendChild(newLabel);
        newOptionGroup.appendChild(newInput);

        let lineBreak = document.createElement('br');
        optionsContainer.appendChild(lineBreak.cloneNode());
        optionsContainer.appendChild(newOptionGroup);

        optionCounter++;
    }

    let addButton = document.getElementById('add-option');
    if (addButton) {
        addButton.addEventListener('click', function() {
            addOption();
        });
    }
});

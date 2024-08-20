document.getElementById('createAccount').addEventListener('change', function () {
    var accountDetails = document.getElementById('accountDetails');
    accountDetails.style.display = this.checked ? 'block' : 'none';
});

function validateForm() {
    let plaatsSelect = document.getElementById('plaats_id');
    let selectedOption = plaatsSelect.options[plaatsSelect.selectedIndex];
    let leveringMogelijk = selectedOption.getAttribute('data-levering-mogelijk');

    if (leveringMogelijk === '0') {
        alert('Levering is niet mogelijk naar de geselecteerde woonplaats.');
        return false;
    }

    return true;
}

function validateForm() {
    let plaatsSelect = document.getElementById('plaats_id');
    let selectedOption = plaatsSelect.options[plaatsSelect.selectedIndex];
    let leveringMogelijk = selectedOption.getAttribute('data-levering-mogelijk');

    if (leveringMogelijk === '0') {
        alert('Levering is niet mogelijk naar de geselecteerde woonplaats.');
        return false;
    }

    return true;
}
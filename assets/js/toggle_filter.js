const toggleBtn = document.getElementById('toggle-btn');
const formContainer = document.getElementById('form-container');
const arrow = document.getElementById('arrow');

toggleBtn.addEventListener('click', () => {
if (formContainer.classList.contains('hidden')) {
    formContainer.classList.remove('hidden');
    formContainer.classList.add('shown');
    arrow.textContent = '▲';
} else {
    formContainer.classList.remove('shown');
    formContainer.classList.add('hidden');
    arrow.textContent = '▼';
}
});
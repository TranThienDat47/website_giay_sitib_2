const modalStocker = document.querySelector('#add-stocker-modal')
const modalContent = document.querySelector('.modal-content')
const modalClose = document.querySelector('.modal-close')
const addStocketButton = document.querySelector('.fixed-icon')
const submitStocketButton = document.querySelector('.submit')
const inputsModal = document.querySelectorAll('#add-stocker-modal input');

function openModal() {
    modalStocker.classList.add('open')
    for (const input of inputsModal) {
        input.required = true;
    }
}

function closeModal() {
    modalStocker.classList.remove('open')
    for (const input of inputsModal) {
        input.removeAttribute('required');
    }
}

addStocketButton.addEventListener('click', openModal)

modalClose.addEventListener('click', closeModal)

modalStocker.addEventListener('click', closeModal)

modalContent.addEventListener('click', function (event) {
    event.stopPropagation()
})

// submitStocketButton.addEventListener('click', function() {
//     modalStocker.classList.remove('open')
//     for (const input of inputsModal) {
//         input.removeAttribute('required');
//     }
// })



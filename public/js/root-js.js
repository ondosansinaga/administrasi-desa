console.log('root-js-loaded');

function resetInputMessage(inputId, removeId) {
    console.log(`input-message in-id: ${inputId}, 'remove-id: ${removeId}`);

    let element = document.getElementById(removeId);
    console.log(element);

    document.getElementById(inputId).addEventListener('keypress', function () {
        console.log('tes');
        if (element) {
            console.log('remove');
            element.remove();
            element = null;
        }
    });
}

function showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        text: message,
        confirmButtonColor: '#E50014',
    })
}

function showErrorMessage(message) {
    Swal.fire({
        icon: 'error',
        text: message,
        confirmButtonColor: '#E50014',
    })
}

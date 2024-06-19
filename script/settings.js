function openModal() {
    document.getElementById('notificationModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('notificationModal').style.display = 'none';
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('notificationModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
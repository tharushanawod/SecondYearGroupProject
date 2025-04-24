const URLROOT = "<?php echo URLROOT; ?>";

let deleteUserId = null; // Store user ID for deletion

function openModal(userId) {
    deleteUserId = userId; // Set the user ID
    document.getElementById('confirmationModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('confirmationModal').style.display = 'none';
    deleteUserId = null; // Clear the user ID when closing
}

function confirm() {
    if (deleteUserId) {
        // Redirect to the delete URL with the user ID
        window.location.href = `${URLROOT}/AdminController/deleteUser/${deleteUserId}`;
    }
    closeModal();
}

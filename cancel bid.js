// Function to open the cancellation modal
function openModal() {
    document.getElementById('cancelModal').style.display = 'block';
}

// Function to close the cancellation modal
function closeModal() {
    document.getElementById('cancelModal').style.display = 'none';
}

// Function to submit the cancellation reason and comments
function submitCancellation() {
    const reason = document.getElementById('reason').value;
    const comment = document.getElementById('comment').value;

    // Process the cancellation (e.g., send data to the server)
    console.log('Cancellation Reason:', reason);
    console.log('Additional Comments:', comment);

    // Close the modal after submission
    closeModal();

    // Optionally, provide feedback to the user
    alert('Your bid cancellation request has been submitted.');
}

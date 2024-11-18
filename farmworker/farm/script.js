// Redirect function for Quick Actions
function navigate(page) {
    window.location.href = page;
}

// Accept Job Request
function acceptRequest(button) {
    button.parentElement.parentElement.querySelector('td:nth-child(3)').textContent = 'Accepted';
    button.nextElementSibling.disabled = true;
    button.disabled = true;
}

// Reject Job Request
function rejectRequest(button) {
    button.parentElement.parentElement.querySelector('td:nth-child(3)').textContent = 'Rejected';
    button.previousElementSibling.disabled = true;
    button.disabled = true;
}

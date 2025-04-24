function openHireModal(name, phone) {
    document.getElementById('workerName').textContent = name;
    document.getElementById('workerPhone').textContent = phone || 'Phone not available';
    document.getElementById('hireModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
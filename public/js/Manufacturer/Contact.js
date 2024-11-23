// Open Hire Modal
function openHireModal(workerName) {
    document.getElementById("hireModal").style.display = "flex";
    document.getElementById("workerName").textContent = `${workerName}`;
}


// Close Modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}



function cancelHire() {
    closeModal('hireModal');
}



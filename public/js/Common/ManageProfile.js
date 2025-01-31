document.querySelector('form.upload-form input[name="profile_picture"]').onchange = function(event) {
   var file = event.target.files[0];
   var reader = new FileReader();

   reader.onload = function(e) {
       document.getElementById('preview-image').src = e.target.result;
   }

   if (file) {
       reader.readAsDataURL(file);
   }
};

document.getElementById("profileForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  // Show popup
  const popup = document.getElementById("popup");
  popup.style.display = "flex";

  // Simulate delay before actual submission
  setTimeout(() => {
    e.target.submit(); // Submit the form after 2 seconds
  }, 3000);
});

// Close Popup
function closePopup() {
  document.getElementById("popup").style.display = "none";
}

// Open Modal
function openModal() {
  document.getElementById("uploadModal").style.display = "block";
}

// Close Modal
function closeModal() {
  document.getElementById("uploadModal").style.display = "none";
}

// Close Modal on Outside Click
window.onclick = function (event) {
  if (event.target == document.getElementById("uploadModal")) {
    closeModal();
  }
};


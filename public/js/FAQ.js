var elements = document.getElementsByClassName("question");

for (var i = 0; i < elements.length; i++) {
  elements[i].addEventListener("click", function () {
    // Close all other open panels
    for (var j = 0; j < elements.length; j++) {
      var panel = elements[j].nextElementSibling;
      var icon = elements[j].querySelector(".fa-chevron-down");

      if (elements[j] !== this) {
        // If it's not the current clicked question
        panel.style.display = "none"; // Close other panels
        icon.classList.remove("rotate"); // Reset the icon
      }
    }

    // Toggle the clicked panel and icon
    var panel = this.nextElementSibling;
    var icon = this.querySelector(".fa-chevron-down");

    if (panel.style.display === "block") {
      panel.style.display = "none";
      icon.classList.remove("rotate");
    } else {
      panel.style.display = "block";
      icon.classList.add("rotate");
    }
  });
}

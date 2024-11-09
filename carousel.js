let currentIndex = 0;
const carousel = document.querySelector(".carousel");
const totalCards = document.querySelectorAll(".card").length;

document.querySelector(".next").addEventListener("click", () => {
  currentIndex = (currentIndex + 1) % totalCards;
  if (currentIndex > 2) {
    currentIndex = 0;
  }
  carousel.style.transform = `translateX(-${
    (currentIndex * 100) / totalCards
  }%)`;
});

document.querySelector(".prev").addEventListener("click", () => {
  currentIndex = (currentIndex - 1 + totalCards) % totalCards;
  if (currentIndex < 5) {
    currentIndex = 0;
  }
  carousel.style.transform = `translateX(-${
    (currentIndex * 100) / totalCards
  }%)`;
});

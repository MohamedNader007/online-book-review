document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".slide");
  const nextBtn = document.querySelector(".next");
  const prevBtn = document.querySelector(".prev");
  let currentSlide = 0;

  // Function to show specific slide
  function showSlide(n) {
    slides.forEach((slide) => {
      slide.classList.remove("active");
      slide.style.opacity = "0";
      slide.style.zIndex = "1";
    });

    slides[n].classList.add("active");
    slides[n].style.opacity = "1";
    slides[n].style.zIndex = "2";
  }

  // Next slide
  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  // Previous slide
  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  }

  // Event listeners
  if (nextBtn) {
    nextBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      nextSlide();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      prevSlide();
    });
  }

  // Auto advance slides every 5 seconds
  setInterval(nextSlide, 5000);

  // Show first slide initially
  showSlide(currentSlide);
});

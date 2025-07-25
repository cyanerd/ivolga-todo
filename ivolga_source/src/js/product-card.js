document.addEventListener('DOMContentLoaded', () => {
  const productCards = document.querySelectorAll('.product-card');

  productCards.forEach(card => {
    const sliderTrack = card.querySelector('.product-card__slider-track');
    const slides = card.querySelectorAll('.product-card__slide');
    const dots = card.querySelectorAll('.product-card__pagination-dot');

    const updateActiveSlide = (index) => {
      slides.forEach((slide, i) => {
        slide.style.opacity = i === index ? '1' : '0';
        slide.style.pointerEvents = i === index ? 'auto' : 'none';
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });
    };

    sliderTrack.addEventListener('mousemove', (e) => {
      const rect = sliderTrack.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const width = rect.width;
      const third = width / 3;

      if (x < third) {
        updateActiveSlide(0);
      } else if (x < third * 2) {
        updateActiveSlide(1);
      } else {
        updateActiveSlide(2);
      }
    });

    sliderTrack.addEventListener('mouseleave', () => {
      updateActiveSlide(0);
    });
  });
}); 
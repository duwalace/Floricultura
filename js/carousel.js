// carousel.js
export function initCarousel() {
  const carousel = document.querySelector('.carousel');
  if (!carousel) return;

  const items = document.querySelectorAll('.carousel-item');
  const indicators = document.querySelectorAll('.carousel-indicator');
  const prevBtn = document.querySelector('.carousel-control.prev');
  const nextBtn = document.querySelector('.carousel-control.next');
  
  let currentIndex = 0;
  let intervalId;

  function showSlide(index) {
    items.forEach(item => item.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));
    
    items[index].classList.add('active');
    indicators[index].classList.add('active');
    currentIndex = index;
  }

  function nextSlide() {
    const newIndex = (currentIndex + 1) % items.length;
    showSlide(newIndex);
  }

  function prevSlide() {
    const newIndex = (currentIndex - 1 + items.length) % items.length;
    showSlide(newIndex);
  }

  function startAutoSlide() {
    stopAutoSlide();
    intervalId = setInterval(nextSlide, 5000);
  }

  function stopAutoSlide() {
    if (intervalId) {
      clearInterval(intervalId);
    }
  }

  // Event listeners
  nextBtn.addEventListener('click', () => {
    nextSlide();
    startAutoSlide();
  });

  prevBtn.addEventListener('click', () => {
    prevSlide();
    startAutoSlide();
  });

  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
      showSlide(index);
      startAutoSlide();
    });
  });

  carousel.addEventListener('mouseenter', stopAutoSlide);
  carousel.addEventListener('mouseleave', startAutoSlide);

  // Inicialização
  showSlide(0);
  startAutoSlide();
}

// Adicione esta linha para inicialização automática quando o módulo for carregado
document.addEventListener('DOMContentLoaded', initCarousel);
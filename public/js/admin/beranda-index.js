document.addEventListener('DOMContentLoaded', () => {
  const boxes = document.querySelectorAll('.stat-box');

  boxes.forEach(box => {
    box.addEventListener('mouseover', () => {
      box.style.transform = 'scale(1.05)';
      box.style.boxShadow = '0 8px 20px rgba(0,0,0,0.25)';
    });

    box.addEventListener('mouseout', () => {
      box.style.transform = 'scale(1)';
      box.style.boxShadow = '0 6px 18px rgba(0,0,0,0.2)';
    });
  });
});
(function initDecorationRotator(): void {
    const INTERVAL_MS = 4000;
    const HIDDEN_CLASS = 'visually-hidden';
  
    const container = document.querySelector<HTMLElement>('.decoration');
    if (!container) return;
  
    const slides = Array.from(container.querySelectorAll<HTMLElement>(':scope > picture'));
    if (slides.length < 2) return; // nothing to rotate
  
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  
    let currentIndex = slides.findIndex(
      (slide) => !slide.classList.contains(HIDDEN_CLASS)
    );
    if (currentIndex === -1) currentIndex = 0;
  
    let timerId: number | undefined;
  
    function showSlide(index: number): void {
      slides.forEach((slide, i) => {
        if (i === index) {
          slide.classList.remove(HIDDEN_CLASS);
        } else {
          slide.classList.add(HIDDEN_CLASS);
        }
      });
    }
  
    function advance(): void {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    }
  
    function start(): void {
      if (timerId !== undefined) return;
      timerId = window.setInterval(advance, INTERVAL_MS);
    }
  
    function stop(): void {
      if (timerId === undefined) return;
      window.clearInterval(timerId);
      timerId = undefined;
    }
  
    function syncWithMotionPreference(): void {
      if (reducedMotionQuery.matches) {
        stop();
      } else {
        start();
      }
    }
  
    // React to the user toggling the OS/browser setting live.
    reducedMotionQuery.addEventListener('change', syncWithMotionPreference);
  
    syncWithMotionPreference();
  })();
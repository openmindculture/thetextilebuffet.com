(function initDecorationRotator() {
    var INTERVAL_MS = 4000;
    var HIDDEN_CLASS = 'visually-hidden';
    var container = document.querySelector('.decoration');
    if (!container)
        return;
    var slides = Array.from(container.querySelectorAll(':scope > picture'));
    if (slides.length < 2)
        return; // nothing to rotate
    var reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    var currentIndex = slides.findIndex(function (slide) { return !slide.classList.contains(HIDDEN_CLASS); });
    if (currentIndex === -1)
        currentIndex = 0;
    var timerId;
    function showSlide(index) {
        slides.forEach(function (slide, i) {
            if (i === index) {
                slide.classList.remove(HIDDEN_CLASS);
            }
            else {
                slide.classList.add(HIDDEN_CLASS);
            }
        });
    }
    function advance() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }
    function start() {
        if (timerId !== undefined)
            return;
        timerId = window.setInterval(advance, INTERVAL_MS);
    }
    function stop() {
        if (timerId === undefined)
            return;
        window.clearInterval(timerId);
        timerId = undefined;
    }
    function syncWithMotionPreference() {
        if (reducedMotionQuery.matches) {
            stop();
        }
        else {
            start();
        }
    }
    // React to the user toggling the OS/browser setting live.
    reducedMotionQuery.addEventListener('change', syncWithMotionPreference);
    syncWithMotionPreference();
})();

document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('#hero-slider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    const dots = slider.querySelectorAll('.hero-dot');
    const prevBtn = slider.querySelector('#hero-prev');
    const nextBtn = slider.querySelector('#hero-next');

    if (!slides.length) return;

    let current = 0;
    let autoplayInterval = null;

    const goTo = (index) => {
        // Remove active from current
        slides[current].classList.remove('hero-slide--active');
        if (dots[current]) dots[current].classList.remove('hero-dot--active');

        // Set new index (wrap around)
        current = (index + slides.length) % slides.length;

        // Activate new
        slides[current].classList.add('hero-slide--active');
        if (dots[current]) dots[current].classList.add('hero-dot--active');
    };

    const next = () => goTo(current + 1);
    const prev = () => goTo(current - 1);

    const startAutoplay = () => {
        stopAutoplay();
        autoplayInterval = setInterval(next, 5000);
    };

    const stopAutoplay = () => {
        if (autoplayInterval) clearInterval(autoplayInterval);
    };

    // Button events
    if (nextBtn) nextBtn.addEventListener('click', () => { next(); startAutoplay(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { prev(); startAutoplay(); });

    // Dot events
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => { goTo(i); startAutoplay(); });
    });

    // Keyboard navigation
    window.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') { next(); startAutoplay(); }
        if (e.key === 'ArrowLeft') { prev(); startAutoplay(); }
    });

    // Pause on hover
    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);

    // Touch / Swipe Navigation
    let touchStartX = 0;
    let touchEndX = 0;

    const handleSwipe = () => {
        const swipeThreshold = 50; // Minimum pixel distance to trigger swipe
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swiped left -> show next slide
                next();
            } else {
                // Swiped right -> show prev slide
                prev();
            }
            startAutoplay();
        }
    };

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    // Animate hero content on slide change
    const animateContent = () => {
        const content = slider.querySelector('.hero-content');
        if (!content) return;
        content.classList.remove('hero-content--animated');
        void content.offsetWidth; // reflow trigger
        content.classList.add('hero-content--animated');
    };

    // Observe slide changes to trigger content animation
    const observer = new MutationObserver(() => animateContent());
    slides.forEach(slide => {
        observer.observe(slide, { attributes: true, attributeFilter: ['class'] });
    });

    // Init
    goTo(0);
    animateContent();
    startAutoplay();
});

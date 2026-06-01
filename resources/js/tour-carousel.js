document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('#tour-carousel');
    if (!section) return;

    const scrollContainer = section.querySelector('.tour-scroll-container');
    const prevBtn = section.querySelector('#tour-carousel-prev');
    const nextBtn = section.querySelector('#tour-carousel-next');

    if (!scrollContainer) return;

    const updateButtons = () => {
        const { scrollLeft, scrollWidth, clientWidth } = scrollContainer;
        const atStart = scrollLeft < 10;
        const atEnd = scrollLeft + clientWidth >= scrollWidth - 10;

        if (prevBtn) {
            prevBtn.classList.toggle('opacity-0', atStart);
            prevBtn.classList.toggle('pointer-events-none', atStart);
            prevBtn.classList.toggle('opacity-100', !atStart);
        }
        if (nextBtn) {
            nextBtn.classList.toggle('opacity-0', atEnd);
            nextBtn.classList.toggle('pointer-events-none', atEnd);
            nextBtn.classList.toggle('opacity-100', !atEnd);
        }
    };

    const scroll = (direction) => {
        const scrollAmount = scrollContainer.clientWidth * 0.8;
        const newScrollLeft = direction === 'left'
            ? scrollContainer.scrollLeft - scrollAmount
            : scrollContainer.scrollLeft + scrollAmount;

        scrollContainer.scrollTo({ left: newScrollLeft, behavior: 'smooth' });
    };

    // Events
    scrollContainer.addEventListener('scroll', updateButtons, { passive: true });
    window.addEventListener('resize', updateButtons);

    if (prevBtn) prevBtn.addEventListener('click', () => scroll('left'));
    if (nextBtn) nextBtn.addEventListener('click', () => scroll('right'));

    // Initial state
    updateButtons();

    // Animate cards on scroll into view
    const cards = section.querySelectorAll('.tour-card');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('tour-card--visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        cards.forEach((card) => observer.observe(card));
    } else {
        // Fallback: show all immediately
        cards.forEach((card) => card.classList.add('tour-card--visible'));
    }
});

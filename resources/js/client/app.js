import '../bootstrap';
import { initAddressSelectors } from '../shared/address-selector';

document.addEventListener('DOMContentLoaded', () => {
    initAddressSelectors();

    const wrapper = document.querySelector('[data-catalog-wrapper]');
    const toggle = document.querySelector('[data-catalog-toggle]');

    if (!wrapper || !toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        if (window.innerWidth > 900) {
            return;
        }

        wrapper.classList.toggle('is-open');
    });

    document.querySelectorAll('[data-slider]').forEach((slider) => {
        const track = slider.querySelector('[data-slider-track]');
        const slides = Array.from(slider.querySelectorAll('[data-slide]'));
        const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));
        const prevButton = slider.querySelector('[data-slider-prev]');
        const nextButton = slider.querySelector('[data-slider-next]');

        if (!track || slides.length === 0) {
            return;
        }

        let activeIndex = 0;
        let timerId = null;

        const render = (index) => {
            activeIndex = (index + slides.length) % slides.length;
            track.style.transform = `translateX(-${activeIndex * 100}%)`;

            dots.forEach((dot, dotIndex) => {
                dot.classList.toggle('is-active', dotIndex === activeIndex);
            });
        };

        const stopAutoplay = () => {
            if (timerId) {
                window.clearInterval(timerId);
                timerId = null;
            }
        };

        const startAutoplay = () => {
            if (slides.length < 2) {
                return;
            }

            stopAutoplay();
            timerId = window.setInterval(() => {
                render(activeIndex + 1);
            }, 5000);
        };

        prevButton?.addEventListener('click', () => {
            render(activeIndex - 1);
            startAutoplay();
        });

        nextButton?.addEventListener('click', () => {
            render(activeIndex + 1);
            startAutoplay();
        });

        dots.forEach((dot, dotIndex) => {
            dot.addEventListener('click', () => {
                render(dotIndex);
                startAutoplay();
            });
        });

        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        render(0);
        startAutoplay();
    });

    document.querySelectorAll('[data-product-gallery]').forEach((gallery) => {
        const mainImage = gallery.querySelector('[data-gallery-main]');
        const thumbnails = Array.from(gallery.querySelectorAll('[data-gallery-thumb]'));

        if (!mainImage || thumbnails.length === 0) {
            return;
        }

        thumbnails.forEach((thumbnail) => {
            thumbnail.addEventListener('click', () => {
                const nextImage = thumbnail.dataset.image;
                const nextAlt = thumbnail.dataset.alt || mainImage.alt;

                if (nextImage) {
                    mainImage.src = nextImage;
                }

                mainImage.alt = nextAlt;

                thumbnails.forEach((item) => {
                    item.classList.toggle('is-active', item === thumbnail);
                });
            });
        });
    });

    document.querySelectorAll('[data-description]').forEach((description) => {
        const body = description.querySelector('[data-description-body]');
        const toggleButton = description.querySelector('[data-description-toggle]');

        if (!body || !toggleButton) {
            return;
        }

        let expanded = false;

        const updateState = () => {
            description.classList.toggle('is-expanded', expanded);
            toggleButton.textContent = expanded ? 'Thu gọn mô tả' : 'Xem thêm mô tả';
        };

        const checkOverflow = () => {
            const isOverflowing = body.scrollHeight - body.clientHeight > 12;
            toggleButton.hidden = !isOverflowing && !expanded;
        };

        toggleButton.addEventListener('click', () => {
            expanded = !expanded;
            updateState();

            requestAnimationFrame(checkOverflow);
        });

        updateState();
        requestAnimationFrame(checkOverflow);
        window.addEventListener('resize', checkOverflow);
    });
});

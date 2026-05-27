import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.data('navbar', () => ({
    scrolled: false,
    mobileOpen: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 50;
        });
    }
}));

Alpine.data('counter', () => ({
    count: 0,
    target: 0,
    started: false,
    init() {
        this.target = parseInt(this.$el.dataset.target) || 0;
    },
    start() {
        if (this.started) return;
        this.started = true;
        const duration = 2000;
        const step = this.target / (duration / 16);
        const interval = setInterval(() => {
            this.count += step;
            if (this.count >= this.target) {
                this.count = this.target;
                clearInterval(interval);
            }
        }, 16);
    }
}));

Alpine.data('heroSlider', () => ({
    current: 0,
    slides: [],
    interval: null,
    duration: 5500,
    init() {
        try {
            this.slides = JSON.parse(this.$el.dataset.slides || '[]');
        } catch {
            this.slides = [];
        }
        if (this.slides.length <= 1) return;
        this.interval = setInterval(() => this.next(), this.duration);
    },
    next() {
        this.current = (this.current + 1) % this.slides.length;
    },
    goTo(index) {
        this.current = index;
        this.resetAutoplay();
    },
    resetAutoplay() {
        clearInterval(this.interval);
        if (this.slides.length > 1) {
            this.interval = setInterval(() => this.next(), this.duration);
        }
    },
    destroy() {
        clearInterval(this.interval);
    },
}));

Alpine.data('gallery', () => ({
    lightboxOpen: false,
    currentImage: '',
    openLightbox(src) {
        this.currentImage = src;
        this.lightboxOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
        this.lightboxOpen = false;
        document.body.style.overflow = '';
    }
}));

Alpine.start();

/* ============================================================
   MiFire CMS - Main JavaScript
   Alpine.js + Utilities
   ============================================================ */

// ── Imports ──────────────────────────────────────────────────
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import { initMasks } from './masks';

// ── Alpine.js Setup ──────────────────────────────────────────
window.Alpine = Alpine;

// Global SweetAlert2 instance
window.Swal = Swal;

// Toast preset
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});

// ── Alpine Components ────────────────────────────────────────

// Mobile Menu
Alpine.data('mobileMenu', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
        document.body.style.overflow = this.open ? 'hidden' : '';
    },
    close() {
        this.open = false;
        document.body.style.overflow = '';
    },
}));

// Back to Top Button
Alpine.data('backToTop', () => ({
    show: false,
    init() {
        window.addEventListener('scroll', () => {
            this.show = window.scrollY > 400;
        }, { passive: true });
    },
    scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
}));

// Counter Animation (for stat numbers)
Alpine.data('counter', (target = 0, duration = 2000) => ({
    current: 0,
    target: target,
    started: false,
    init() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !this.started) {
                    this.started = true;
                    this.animate();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(this.$el);
    },
    animate() {
        const start = performance.now();
        const step = (timestamp) => {
            const progress = Math.min((timestamp - start) / duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            this.current = Math.floor(eased * this.target);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                this.current = this.target;
            }
        };
        requestAnimationFrame(step);
    },
}));

// Form Validation Helper
Alpine.data('formValidation', () => ({
    errors: {},
    validate(field, value, rules) {
        this.errors[field] = [];

        if (rules.includes('required') && (!value || value.trim() === '')) {
            this.errors[field].push('Este campo é obrigatório.');
        }

        if (rules.includes('email') && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.errors[field].push('Informe um e-mail válido.');
            }
        }

        if (rules.includes('phone') && value) {
            const cleaned = value.replace(/\D/g, '');
            if (cleaned.length < 10 || cleaned.length > 11) {
                this.errors[field].push('Informe um telefone válido.');
            }
        }

        return this.errors[field].length === 0;
    },
    hasError(field) {
        return this.errors[field] && this.errors[field].length > 0;
    },
    getError(field) {
        return this.errors[field] ? this.errors[field][0] : '';
    },
    clearError(field) {
        delete this.errors[field];
    },
}));

// Start Alpine
Alpine.start();

// ── Initialize Masks ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    initMasks();
});

// Re-init masks when Alpine/Livewire updates DOM
document.addEventListener('alpine:initialized', () => {
    initMasks();
});

// ── PWA Service Worker Registration ──────────────────────────
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/sw.js')
            .then((registration) => {
                console.log('SW registered:', registration.scope);
            })
            .catch((error) => {
                console.log('SW registration failed:', error);
            });
    });
}

// ── PWA Install Prompt ───────────────────────────────────────
let deferredPrompt = null;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    // Show install banner if not dismissed before
    if (!localStorage.getItem('pwa-install-dismissed')) {
        const banner = document.querySelector('.pwa-install-banner');
        if (banner) {
            setTimeout(() => banner.classList.add('show'), 2000);
        }
    }
});

window.installPWA = async () => {
    if (!deferredPrompt) return;

    deferredPrompt.prompt();
    const { outcome } = await deferredPrompt.userChoice;

    if (outcome === 'accepted') {
        console.log('PWA installed');
    }

    deferredPrompt = null;
    const banner = document.querySelector('.pwa-install-banner');
    if (banner) banner.classList.remove('show');
};

window.dismissPWABanner = () => {
    localStorage.setItem('pwa-install-dismissed', 'true');
    const banner = document.querySelector('.pwa-install-banner');
    if (banner) banner.classList.remove('show');
};

// ── Scroll Animations (Intersection Observer) ────────────────
const observeFadeElements = () => {
    const elements = document.querySelectorAll('.fade-in-up');
    if (!elements.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px',
        }
    );

    elements.forEach((el) => observer.observe(el));
};

document.addEventListener('DOMContentLoaded', observeFadeElements);

// ── Smooth Scroll for Anchor Links ───────────────────────────
document.addEventListener('click', (e) => {
    const anchor = e.target.closest('a[href^="#"]');
    if (!anchor) return;

    const targetId = anchor.getAttribute('href');
    if (targetId === '#') return;

    const target = document.querySelector(targetId);
    if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Update URL without jump
        history.pushState(null, '', targetId);
    }
});

// ── Lazy Image Loading ───────────────────────────────────────
const lazyLoadImages = () => {
    const images = document.querySelectorAll('img[data-src]');
    if (!images.length) return;

    const imageObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    if (img.dataset.srcset) {
                        img.srcset = img.dataset.srcset;
                    }
                    img.removeAttribute('data-src');
                    img.removeAttribute('data-srcset');
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        },
        {
            rootMargin: '200px 0px',
        }
    );

    images.forEach((img) => imageObserver.observe(img));
};

document.addEventListener('DOMContentLoaded', lazyLoadImages);

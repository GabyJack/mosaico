/**
 * Template Narrow - JavaScript principal
 * Funcionalidades del template para Joomla 6
 * 
 * @package     Tpl_Narrow
 * @copyright   Copyright (C) 2026. Todos los derechos reservados.
 * @license     GNU General Public License versión 2 o posterior
 */

(function() {
    'use strict';

    /**
     * Inicialización del menú móvil
     */
    function initMobileMenu() {
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (!menuToggle || !mobileMenu) {
            return;
        }

        menuToggle.addEventListener('click', function() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            
            if (mobileMenu.style.display === 'none' || !mobileMenu.style.display) {
                mobileMenu.style.display = 'block';
                mobileMenu.setAttribute('aria-hidden', 'false');
            } else {
                mobileMenu.style.display = 'none';
                mobileMenu.setAttribute('aria-hidden', 'true');
            }
        });

        // Cerrar menú al hacer clic en enlaces
        const navLinks = mobileMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.style.display = 'none';
                mobileMenu.setAttribute('aria-hidden', 'true');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target)) {
                mobileMenu.style.display = 'none';
                mobileMenu.setAttribute('aria-hidden', 'true');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /**
     * Inicialización del slider carrusel
     * Pausa el slider cuando el usuario pasa el cursor sobre él
     */
    function initSlider() {
        const sliderEl = document.getElementById('featuredSlider');
        
        if (!sliderEl || typeof bootstrap === 'undefined') {
            return;
        }

        // Esperar a que Bootstrap esté disponible
        setTimeout(function() {
            const carouselInstance = new bootstrap.Carousel(sliderEl, {
                interval: sliderEl.dataset.bsInterval || 4000,
                wrap: true,
                touch: true,
                pause: 'hover'
            });

            // Accesibilidad: anunciar cambios de slide
            const carouselItems = sliderEl.querySelectorAll('.carousel-item');
            carouselItems.forEach((item, index) => {
                item.addEventListener('slide.bs.carousel', function() {
                    const announcement = document.createElement('div');
                    announcement.setAttribute('role', 'status');
                    announcement.setAttribute('aria-live', 'polite');
                    announcement.className = 'sr-only';
                    announcement.textContent = `Diapositiva ${index + 1} de ${carouselItems.length}`;
                    sliderEl.appendChild(announcement);
                    
                    setTimeout(() => announcement.remove(), 1000);
                });
            });
        }, 100);
    }

    /**
     * Mejoras de accesibilidad para botones de artículo
     */
    function initArticleButtons() {
        const articleButtons = document.querySelectorAll('.article-button');
        
        articleButtons.forEach(button => {
            // Añadir feedback táctil en móviles
            button.addEventListener('touchstart', function() {
                this.style.transform = 'translateX(2px)';
            });

            button.addEventListener('touchend', function() {
                this.style.transform = '';
            });
        });
    }

    /**
     * Lazy loading para imágenes
     */
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // El navegador soporta lazy loading nativo
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src || img.src;
            });
        } else {
            // Fallback para navegadores antiguos
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            script.async = true;
            document.body.appendChild(script);
        }
    }

    /**
     * Smooth scroll para enlaces internos
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                
                if (targetId === '#') {
                    return;
                }

                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Manejo de errores de carga de imágenes
     */
    function initImageErrorHandling() {
        const images = document.querySelectorAll('img');
        
        images.forEach(img => {
            img.addEventListener('error', function() {
                // Imagen placeholder como fallback
                this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"%3E%3Crect fill="%231a1d27" width="100" height="100"/%3E%3Ctext fill="%239ca0ab" font-family="sans-serif" font-size="12" x="50" y="50" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                this.alt = 'Imagen no disponible';
            });
        });
    }

    /**
     * Inicialización de todas las funcionalidades
     */
    function init() {
        // Esperar a que el DOM esté completamente cargado
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initMobileMenu();
                initSlider();
                initArticleButtons();
                initLazyLoading();
                initSmoothScroll();
                initImageErrorHandling();
            });
        } else {
            initMobileMenu();
            initSlider();
            initArticleButtons();
            initLazyLoading();
            initSmoothScroll();
            initImageErrorHandling();
        }
    }

    // Iniciar el template
    init();

})();

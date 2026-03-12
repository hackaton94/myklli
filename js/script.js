// Données de langue
const translations = {
    en: {
        // Navigation
        "Home": "Home",
        "About": "About",
        "Services": "Services",
        "Contact": "Contact",
        
        // Hero Section
        "Excellence in Business Solutions": "Excellence in Business Solutions",
        "MYKLI Multi-services provides comprehensive business solutions including materials trading, IT engineering, artificial intelligence, and financial services.": "MYKLI Multi-services provides comprehensive business solutions including materials trading, IT engineering, artificial intelligence, and financial services.",
        "Our Services": "Our Services",
        "Get in Touch": "Get in Touch",
        
        // About Section
        "About MYKLI Multi-services": "About MYKLI Multi-services",
        "Leading the way in innovative business solutions": "Leading the way in innovative business solutions",
        "Our Vision": "Our Vision",
        "At MYKLI Multi-services, we believe in transforming businesses through innovative solutions and exceptional service delivery. Our diverse portfolio spans across multiple industries, ensuring comprehensive support for all your business needs.": "At MYKLI Multi-services, we believe in transforming businesses through innovative solutions and exceptional service delivery. Our diverse portfolio spans across multiple industries, ensuring comprehensive support for all your business needs.",
        "Chief Executive Officer": "Chief Executive Officer",
        "Leading MYKLI Multi-services with vision and expertise, driving innovation across all our business verticals.": "Leading MYKLI Multi-services with vision and expertise, driving innovation across all our business verticals.",
        
        // Services Section
        "Comprehensive solutions for your business success": "Comprehensive solutions for your business success",
        "Materials Trading": "Materials Trading",
        "Comprehensive buying and selling of materials and various goods with reliable supply chain management.": "Comprehensive buying and selling of materials and various goods with reliable supply chain management.",
        "Quality Assurance": "Quality Assurance",
        "Global Network": "Global Network",
        "Competitive Pricing": "Competitive Pricing",
        
        "Service Provision": "Service Provision",
        "Professional service delivery across multiple domains with focus on client satisfaction and excellence.": "Professional service delivery across multiple domains with focus on client satisfaction and excellence.",
        "Expert Consultation": "Expert Consultation",
        "Custom Solutions": "Custom Solutions",
        "24/7 Support": "24/7 Support",
        
        "IT Engineering": "IT Engineering",
        "Cutting-edge web and mobile application development, artificial intelligence solutions, and digital transformation.": "Cutting-edge web and mobile application development, artificial intelligence solutions, and digital transformation.",
        "Web Development": "Web Development",
        "Mobile Apps": "Mobile Apps",
        "AI Solutions": "AI Solutions",
        
        "Finance": "Finance",
        "Comprehensive financial services including consulting, planning, and strategic financial management solutions.": "Comprehensive financial services including consulting, planning, and strategic financial management solutions.",
        "Financial Planning": "Financial Planning",
        "Investment Advisory": "Investment Advisory",
        "Risk Management": "Risk Management",
        
        // Contact Section
        "Ready to transform your business? Let's discuss your needs.": "Ready to transform your business? Let's discuss your needs.",
        "Email Us": "Email Us",
        "Call Us": "Call Us",
        "Visit Us": "Visit Us",
        "Business District, Professional Center": "Business District, Professional Center",
        "Your Name": "Your Name",
        "Your Email": "Your Email",
        "Subject": "Subject",
        "Your Message": "Your Message",
        "Send Message": "Send Message",
        
        // Footer
        "All rights reserved.": "All rights reserved.",
        "Contact Info": "Contact Info"
    },
    fr: {
        // Navigation
        "Home": "Accueil",
        "About": "À Propos",
        "Services": "Services",
        "Contact": "Contact",
        
        // Hero Section
        "Excellence in Business Solutions": "Excellence en Solutions d'Affaires",
        "MYKLI Multi-services provides comprehensive business solutions including materials trading, IT engineering, artificial intelligence, and financial services.": "MYKLI Multi-services offre des solutions d'affaires complètes incluant le commerce de matériaux, l'ingénierie informatique, l'intelligence artificielle et les services financiers.",
        "Our Services": "Nos Services",
        "Get in Touch": "Nous Contacter",
        
        // About Section
        "About MYKLI Multi-services": "À Propos de MYKLI Multi-services",
        "Leading the way in innovative business solutions": "Pionnier en solutions d'affaires innovantes",
        "Our Vision": "Notre Vision",
        "At MYKLI Multi-services, we believe in transforming businesses through innovative solutions and exceptional service delivery. Our diverse portfolio spans across multiple industries, ensuring comprehensive support for all your business needs.": "Chez MYKLI Multi-services, nous croyons en la transformation des entreprises grâce à des solutions innovantes et un service exceptionnel. Notre portefeuille diversifié s'étend sur plusieurs industries, assurant un soutien complet pour tous vos besoins d'affaires.",
        "Chief Executive Officer": "Directeur Général",
        "Leading MYKLI Multi-services with vision and expertise, driving innovation across all our business verticals.": "Dirigeant MYKLI Multi-services avec vision et expertise, stimulant l'innovation dans tous nos secteurs d'activité.",
        
        // Services Section
        "Comprehensive solutions for your business success": "Solutions complètes pour votre succès commercial",
        "Materials Trading": "Commerce de Matériaux",
        "Comprehensive buying and selling of materials and various goods with reliable supply chain management.": "Achat et vente complets de matériaux et divers biens avec gestion fiable de la chaîne d'approvisionnement.",
        "Quality Assurance": "Assurance Qualité",
        "Global Network": "Réseau Mondial",
        "Competitive Pricing": "Prix Compétitifs",
        
        "Service Provision": "Prestation de Services",
        "Professional service delivery across multiple domains with focus on client satisfaction and excellence.": "Prestation de services professionnels dans plusieurs domaines avec un focus sur la satisfaction client et l'excellence.",
        "Expert Consultation": "Consultation Expert",
        "Custom Solutions": "Solutions Personnalisées",
        "24/7 Support": "Support 24/7",
        
        "IT Engineering": "Ingénierie Informatique",
        "Cutting-edge web and mobile application development, artificial intelligence solutions, and digital transformation.": "Développement d'applications web et mobiles de pointe, solutions d'intelligence artificielle et transformation numérique.",
        "Web Development": "Développement Web",
        "Mobile Apps": "Applications Mobiles",
        "AI Solutions": "Solutions IA",
        
        "Finance": "Finance",
        "Comprehensive financial services including consulting, planning, and strategic financial management solutions.": "Services financiers complets incluant conseil, planification et solutions de gestion financière stratégique.",
        "Financial Planning": "Planification Financière",
        "Investment Advisory": "Conseil en Investissement",
        "Risk Management": "Gestion des Risques",
        
        // Contact Section
        "Ready to transform your business? Let's discuss your needs.": "Prêt à transformer votre entreprise ? Discutons de vos besoins.",
        "Email Us": "Nous Écrire",
        "Call Us": "Nous Appeler",
        "Visit Us": "Nous Rendre Visite",
        "Business District, Professional Center": "Quartier d'Affaires, Centre Professionnel",
        "Your Name": "Votre Nom",
        "Your Email": "Votre Email",
        "Subject": "Sujet",
        "Your Message": "Votre Message",
        "Send Message": "Envoyer le Message",
        
        // Footer
        "All rights reserved.": "Tous droits réservés.",
        "Contact Info": "Informations de Contact"
    }
};

// Variables globales
let currentLanguage = 'fr';

// Contenu DOM Chargé
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser toutes les fonctionnalités
    initializeNavigation();
    initializeLanguageSwitcher();
    initializeScrollAnimations();
    initializeContactForm();
    initializeLoadingScreen();
    initializeWhatsAppButton();
    initializeMobileOptimizations();
    initializeHeroAnimations();
    initializeCounterAnimation();
    initializeTypewriterEffect();
    
    // Définir la langue initiale (français)
    switchLanguage('fr');
});

// Fonctionnalité de navigation
function initializeNavigation() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');
    const navbar = document.getElementById('navbar');

    // Basculer le menu hamburger
    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    // Fermer le menu en cliquant sur un lien
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });

    // Effet de défilement de la barre de navigation
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Défilement fluide pour les liens d'ancrage
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 70; // Tenir compte de la barre de navigation fixe
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Fonctionnalité de changement de langue
function initializeLanguageSwitcher() {
    const langButtons = document.querySelectorAll('.lang-btn');
    
    langButtons.forEach(button => {
        button.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            switchLanguage(lang);
            
            // Mettre à jour le bouton actif
            langButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Fonction de changement de langue
function switchLanguage(lang) {
    currentLanguage = lang;
    document.documentElement.lang = lang;
    
    // Mettre à jour tous les éléments avec des attributs de données
    const elements = document.querySelectorAll('[data-en], [data-fr]');
    elements.forEach(element => {
        const text = element.getAttribute(`data-${lang}`);
        if (text) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.placeholder = text;
            } else {
                element.textContent = text;
            }
        }
    });
    
    // Mettre à jour les étiquettes de formulaire
    updateFormLabels();
}

// Update form labels
function updateFormLabels() {
    const labels = document.querySelectorAll('.form-group label');
    labels.forEach(label => {
        const text = label.getAttribute(`data-${currentLanguage}`);
        if (text) {
            label.textContent = text;
        }
    });
}

// Animations de défilement
function initializeScrollAnimations() {
    // Ajouter la classe fade-in aux éléments qui doivent s'animer
    const animateElements = document.querySelectorAll('.service-card, .ceo-card, .contact-item');
    animateElements.forEach(element => {
        element.classList.add('fade-in-on-scroll');
    });
    
    // Intersection Observer pour les animations de défilement
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Add staggered animation for hero stats
                if (entry.target.classList.contains('hero-stats')) {
                    const statItems = entry.target.querySelectorAll('.stat-item');
                    statItems.forEach((item, index) => {
                        setTimeout(() => {
                            item.style.animation = `fadeInUp 0.6s ease forwards`;
                        }, index * 200);
                    });
                }
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observer tous les éléments avec la classe fade-in-on-scroll
    const fadeElements = document.querySelectorAll('.fade-in-on-scroll');
    fadeElements.forEach(element => {
        observer.observe(element);
    });
    
    // Observer hero stats for counter animation
    const heroStats = document.querySelector('.hero-stats');
    if (heroStats) {
        observer.observe(heroStats);
    }
}

// Fonctionnalité du formulaire de contact
function initializeContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, textarea, select');
    const submitBtn = form.querySelector('.btn-submit');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    // Ajouter l'effet d'étiquette flottante
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (this.value === '' && this.tagName !== 'SELECT') {
                this.parentElement.classList.remove('focused');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value !== '' || this.tagName === 'SELECT') {
                this.parentElement.classList.add('focused');
            } else {
                this.parentElement.classList.remove('focused');
            }
            
            // Validation en temps réel
            validateField(this);
        });
        
        // Vérifier si l'entrée a une valeur au chargement
        if (input.value !== '' || input.tagName === 'SELECT') {
            input.parentElement.classList.add('focused');
        }
    });
    
    // Validation des champs
    function validateField(field) {
        const formGroup = field.parentElement;
        const errorMsg = formGroup.querySelector('.error-message');
        
        // Supprimer le message d'erreur existant
        if (errorMsg) {
            errorMsg.remove();
        }
        
        formGroup.classList.remove('error');
        
        let isValid = true;
        let errorMessage = '';
        
        // Validation selon le type de champ
        if (field.hasAttribute('required') && !field.value.trim()) {
            isValid = false;
            errorMessage = currentLanguage === 'en' ? 'This field is required' : 'Ce champ est obligatoire';
        } else if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                isValid = false;
                errorMessage = currentLanguage === 'en' ? 'Please enter a valid email' : 'Veuillez saisir un email valide';
            }
        } else if (field.type === 'tel' && field.value) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{8,}$/;
            if (!phoneRegex.test(field.value)) {
                isValid = false;
                errorMessage = currentLanguage === 'en' ? 'Please enter a valid phone number' : 'Veuillez saisir un numéro valide';
            }
        }
        
        if (!isValid) {
            formGroup.classList.add('error');
            const errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            errorElement.textContent = errorMessage;
            errorElement.style.cssText = `
                color: #ef4444;
                font-size: 0.85rem;
                margin-top: 0.25rem;
                display: block;
            `;
            formGroup.appendChild(errorElement);
        }
        
        return isValid;
    }
    
    // Soumission du formulaire
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Valider tous les champs
        let isFormValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isFormValid = false;
            }
        });
        
        if (!isFormValid) {
            showNotification(
                currentLanguage === 'en' 
                    ? 'Please correct the errors in the form' 
                    : 'Veuillez corriger les erreurs dans le formulaire',
                'error'
            );
            return;
        }
        
        // Afficher l'état de chargement
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        
        try {
            // Obtenir les données du formulaire
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            // Simuler l'envoi (remplacer par votre logique d'envoi réelle)
            await simulateFormSubmission(data);
            
            // Afficher le message de succès
            showNotification(
                currentLanguage === 'en' 
                    ? 'Message sent successfully! We will get back to you soon.' 
                    : 'Message envoyé avec succès ! Nous vous répondrons bientôt.',
                'success'
            );
            
            // Réinitialiser le formulaire
            form.reset();
            inputs.forEach(input => {
                input.parentElement.classList.remove('focused');
                input.parentElement.classList.remove('error');
                const errorMsg = input.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            });
            
            console.log('Form submitted:', data);
            
        } catch (error) {
            showNotification(
                currentLanguage === 'en' 
                    ? 'Error sending message. Please try again.' 
                    : 'Erreur lors de l\'envoi. Veuillez réessayer.',
                'error'
            );
        } finally {
            // Restaurer l'état du bouton
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        }
    });
    
    // Simuler l'envoi du formulaire
    async function simulateFormSubmission(data) {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(data);
            }, 2000);
        });
    }
}

// Écran de chargement
function initializeLoadingScreen() {
    // Créer l'écran de chargement
    const loadingScreen = document.createElement('div');
    loadingScreen.className = 'loading';
    loadingScreen.innerHTML = '<div class="spinner"></div>';
    document.body.appendChild(loadingScreen);
    
    // Masquer l'écran de chargement après le chargement de la page
    window.addEventListener('load', function() {
        setTimeout(() => {
            loadingScreen.classList.add('fade-out');
            setTimeout(() => {
                loadingScreen.remove();
            }, 500);
        }, 1000);
    });
}

// Système de notification
function showNotification(message, type = 'info') {
    // Supprimer les notifications existantes
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Créer une notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    let iconClass = 'fa-info-circle';
    let bgColor = '#3b82f6';
    
    switch(type) {
        case 'success':
            iconClass = 'fa-check-circle';
            bgColor = '#10b981';
            break;
        case 'error':
            iconClass = 'fa-exclamation-circle';
            bgColor = '#ef4444';
            break;
        case 'warning':
            iconClass = 'fa-exclamation-triangle';
            bgColor = '#f59e0b';
            break;
    }
    
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${iconClass}"></i>
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Ajouter des styles
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        transform: translateX(100%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 400px;
        backdrop-filter: blur(10px);
    `;
    
    notification.querySelector('.notification-content').style.cssText = `
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    `;
    
    notification.querySelector('.notification-close').style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Afficher la notification
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Fonctionnalité de fermeture
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('mouseenter', () => {
        closeBtn.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
    });
    closeBtn.addEventListener('mouseleave', () => {
        closeBtn.style.backgroundColor = 'transparent';
    });
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Masquer automatiquement après 5 secondes
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Fonctions utilitaires
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Fonction de défilement fluide vers le haut
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Ajouter le bouton de défilement vers le haut
document.addEventListener('DOMContentLoaded', function() {
    // Créer le bouton de défilement vers le haut
    const scrollTopBtn = document.createElement('button');
    scrollTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    scrollTopBtn.className = 'scroll-top-btn';
    scrollTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        z-index: 1000;
        opacity: 0;
        transform: translateY(100px);
        transition: all 0.3s ease;
    `;
    
    scrollTopBtn.addEventListener('click', scrollToTop);
    document.body.appendChild(scrollTopBtn);
    
    // Afficher/masquer le bouton de défilement vers le haut
    window.addEventListener('scroll', debounce(() => {
        if (window.scrollY > 500) {
            scrollTopBtn.style.opacity = '1';
            scrollTopBtn.style.transform = 'translateY(0)';
        } else {
            scrollTopBtn.style.opacity = '0';
            scrollTopBtn.style.transform = 'translateY(100px)';
        }
    }, 100));
});

// Ajouter des effets de survol aux cartes de service
document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Effet parallaxe pour la section héro
document.addEventListener('DOMContentLoaded', function() {
    const hero = document.querySelector('.hero');
    const floatingCards = document.querySelectorAll('.floating-card');
    
    window.addEventListener('scroll', debounce(() => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (hero) {
            hero.style.transform = `translateY(${rate}px)`;
        }
        
        floatingCards.forEach((card, index) => {
            const cardRate = scrolled * (-0.3 - index * 0.1);
            card.style.transform = `translateY(${cardRate}px) rotate(${scrolled * 0.02}deg)`;
        });
    }, 10));
});

// Initialiser le bouton WhatsApp flottant
function initializeWhatsAppButton() {
    // Créer le bouton WhatsApp flottant
    const whatsappBtn = document.createElement('a');
    whatsappBtn.href = 'https://wa.me/message/6FVEUJ23UNWBH1';
    whatsappBtn.target = '_blank';
    whatsappBtn.className = 'whatsapp-float';
    whatsappBtn.innerHTML = '<i class="fab fa-whatsapp"></i>';
    whatsappBtn.title = 'Contactez-nous sur WhatsApp';
    
    // Styles du bouton
    whatsappBtn.style.cssText = `
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: #25d366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        text-decoration: none;
        box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
        z-index: 1000;
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    `;
    
    // Effet de survol (seulement sur desktop)
    if (window.matchMedia('(hover: hover)').matches) {
        whatsappBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 8px 25px rgba(37, 211, 102, 0.6)';
        });
        
        whatsappBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 5px 20px rgba(37, 211, 102, 0.4)';
        });
    }
    
    document.body.appendChild(whatsappBtn);
}

// Initialiser les optimisations mobiles
function initializeMobileOptimizations() {
    // Détecter si c'est un appareil mobile
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        // Optimiser les animations pour mobile
        document.body.classList.add('mobile-device');
        
        // Réduire les animations sur mobile pour de meilleures performances
        const style = document.createElement('style');
        style.textContent = `
            .mobile-device .floating-card {
                animation-duration: 8s;
            }
            .mobile-device .hero {
                background-attachment: scroll;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Optimiser le défilement tactile
    let touchStartY = 0;
    let touchEndY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });
    
    document.addEventListener('touchend', function(e) {
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartY - touchEndY;
        
        // Swipe vers le haut pour fermer le menu mobile
        if (Math.abs(diff) > swipeThreshold) {
            const navMenu = document.getElementById('nav-menu');
            const hamburger = document.getElementById('hamburger');
            
            if (navMenu && navMenu.classList.contains('active') && diff > 0) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            }
        }
    }
    
    // Ajuster la hauteur de la viewport sur mobile
    function setVH() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
    
    setVH();
    window.addEventListener('resize', setVH);
    window.addEventListener('orientationchange', setVH);
}

// Initialiser l'alternative AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observer les sections pour l'animation
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
});

// Initialize Hero Animations
function initializeHeroAnimations() {
    // Add hover effects to floating cards
    const floatingCards = document.querySelectorAll('.floating-card');
    
    floatingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) translateY(-10px)';
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) translateY(0)';
            this.style.zIndex = '5';
        });
    });
    
    // Add click effects to buttons
    const heroButtons = document.querySelectorAll('.hero-buttons .btn');
    
    heroButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Initialize Counter Animation
function initializeCounterAnimation() {
    const counters = document.querySelectorAll('.counter');
    const observerOptions = {
        threshold: 0.7,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 seconds
                const increment = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
}

// Initialize Typewriter Effect
function initializeTypewriterEffect() {
    const typewriterElement = document.querySelector('.typewriter-effect');
    if (!typewriterElement) return;
    
    const text = typewriterElement.textContent;
    typewriterElement.textContent = '';
    
    let i = 0;
    const typeWriter = () => {
        if (i < text.length) {
            typewriterElement.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 100);
        } else {
            // Remove cursor after typing is complete
            setTimeout(() => {
                typewriterElement.style.borderRight = 'none';
            }, 1000);
        }
    };
    
    // Start typewriter effect after a delay
    setTimeout(typeWriter, 1000);
}

// Enhanced Parallax Effect for Hero Section with RAF
function initializeEnhancedParallax() {
    const hero = document.querySelector('.hero');
    const heroContent = document.querySelector('.hero-container');
    const floatingCards = document.querySelectorAll('.floating-card');
    const particles = document.querySelectorAll('.particle');
    const shapes = document.querySelectorAll('.animated-shape');
    
    let ticking = false;
    let lastScrollY = 0;
    
    function updateParallax() {
        const scrolled = lastScrollY;
        const heroHeight = hero ? hero.offsetHeight : 0;
        
        if (hero && scrolled < heroHeight) {
            const scrollProgress = scrolled / heroHeight;
            
            // Smooth parallax for hero content with fade
            if (heroContent) {
                const contentRate = scrolled * 0.5;
                const opacity = 1 - (scrollProgress * 0.7);
                heroContent.style.transform = `translate3d(0, ${contentRate}px, 0)`;
                heroContent.style.opacity = Math.max(opacity, 0.3);
            }
            
            // Enhanced parallax for floating cards
            floatingCards.forEach((card, index) => {
                const cardRate = scrolled * (0.3 + index * 0.05);
                card.style.transform = `translate3d(0, ${cardRate}px, 0)`;
            });
            
            // Parallax for particles - slower movement
            particles.forEach((particle, index) => {
                const particleRate = scrolled * (0.15 + index * 0.02);
                particle.style.transform = `translate3d(0, ${particleRate}px, 0)`;
            });
            
            // Parallax for shapes - medium speed
            shapes.forEach((shape, index) => {
                const shapeRate = scrolled * (0.2 + index * 0.03);
                shape.style.transform = `translate3d(0, ${shapeRate}px, 0)`;
            });
        }
        
        ticking = false;
    }
    
    function onScroll() {
        lastScrollY = window.pageYOffset;
        
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', onScroll, { passive: true });
}

// Initialize enhanced parallax on load
document.addEventListener('DOMContentLoaded', function() {
    initializeEnhancedParallax();
});

// Add mouse movement parallax effect
document.addEventListener('mousemove', debounce((e) => {
    const hero = document.querySelector('.hero');
    if (!hero) return;
    
    const rect = hero.getBoundingClientRect();
    if (rect.top <= 0 && rect.bottom >= 0) {
        const x = (e.clientX / window.innerWidth) - 0.5;
        const y = (e.clientY / window.innerHeight) - 0.5;
        
        const floatingCards = document.querySelectorAll('.floating-card');
        floatingCards.forEach((card, index) => {
            const intensity = (index + 1) * 10;
            card.style.transform += ` translate(${x * intensity}px, ${y * intensity}px)`;
        });
        
        const particles = document.querySelectorAll('.particle');
        particles.forEach((particle, index) => {
            const intensity = (index + 1) * 5;
            particle.style.transform += ` translate(${x * intensity}px, ${y * intensity}px)`;
        });
    }
}, 50));

console.log('MYKLI Multi-services website loaded successfully!');

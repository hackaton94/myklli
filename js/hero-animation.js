/**
 * Animation sophistiquée pour la section héro de MYKLI Multi-services
 * Inspirée des activités de l'entreprise : matériaux, services, IT, finance
 */

class HeroAnimation {
    constructor() {
        this.container = null;
        this.isInitialized = false;
        this.animationElements = [];
        this.resizeTimeout = null;
        
        // Configuration de l'animation
        this.config = {
            particles: {
                count: 15,
                minSize: 3,
                maxSize: 8
            },
            serviceLines: {
                horizontal: 8,
                vertical: 6
            },
            activityIcons: [
                { icon: 'fas fa-chart-line', class: 'finance' },
                { icon: 'fas fa-laptop-code', class: 'tech' },
                { icon: 'fas fa-boxes', class: 'materials' },
                { icon: 'fas fa-handshake', class: 'services' }
            ],
            dataWaves: 5,
            expansionCircles: 3
        };
    }

    // Initialiser l'animation
    init() {
        if (this.isInitialized) return;
        
        const heroSection = document.querySelector('.hero');
        if (!heroSection) return;

        this.createAnimationContainer(heroSection);
        this.createMaterialParticles();
        this.createServiceLines();
        this.createActivityIcons();
        this.createDataWaves();
        this.createExpansionCircles();
        
        this.setupResponsiveHandling();
        this.isInitialized = true;
        
        console.log('Animation héro MYKLI initialisée avec succès');
    }

    // Créer le conteneur principal de l'animation
    createAnimationContainer(heroSection) {
        this.container = document.createElement('div');
        this.container.className = 'hero-animation-container';
        heroSection.appendChild(this.container);
    }

    // Créer les particules de matériaux flottantes
    createMaterialParticles() {
        for (let i = 0; i < this.config.particles.count; i++) {
            const particle = document.createElement('div');
            particle.className = 'material-particle';
            
            // Taille aléatoire
            const size = Math.random() * (this.config.particles.maxSize - this.config.particles.minSize) + this.config.particles.minSize;
            if (size > 6) particle.classList.add('large');
            else if (size > 4) particle.classList.add('medium');
            else particle.classList.add('small');
            
            // Position initiale aléatoire
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (15 + Math.random() * 10) + 's';
            
            this.container.appendChild(particle);
            this.animationElements.push(particle);
        }
    }

    // Créer les lignes de service
    createServiceLines() {
        // Lignes horizontales
        for (let i = 0; i < this.config.serviceLines.horizontal; i++) {
            const line = document.createElement('div');
            line.className = 'service-line horizontal';
            
            line.style.top = Math.random() * 100 + '%';
            line.style.animationDelay = Math.random() * 12 + 's';
            
            this.container.appendChild(line);
            this.animationElements.push(line);
        }

        // Lignes verticales
        for (let i = 0; i < this.config.serviceLines.vertical; i++) {
            const line = document.createElement('div');
            line.className = 'service-line vertical';
            
            line.style.left = Math.random() * 100 + '%';
            line.style.animationDelay = Math.random() * 10 + 's';
            
            this.container.appendChild(line);
            this.animationElements.push(line);
        }
    }

    // Créer les icônes d'activités flottantes
    createActivityIcons() {
        this.config.activityIcons.forEach((iconConfig, index) => {
            // Créer plusieurs instances de chaque icône
            for (let i = 0; i < 3; i++) {
                const iconElement = document.createElement('i');
                iconElement.className = `activity-icon ${iconConfig.class} ${iconConfig.icon}`;
                
                // Position aléatoire
                iconElement.style.left = Math.random() * 90 + '%';
                iconElement.style.top = Math.random() * 90 + '%';
                iconElement.style.animationDelay = (index * 5 + i * 2) + 's';
                
                this.container.appendChild(iconElement);
                this.animationElements.push(iconElement);
            }
        });
    }

    // Créer les vagues de données
    createDataWaves() {
        for (let i = 0; i < this.config.dataWaves; i++) {
            const wave = document.createElement('div');
            wave.className = 'data-wave';
            
            wave.style.top = (20 + i * 15) + '%';
            wave.style.animationDelay = i * 1.5 + 's';
            
            this.container.appendChild(wave);
            this.animationElements.push(wave);
        }
    }

    // Créer les cercles d'expansion
    createExpansionCircles() {
        const sizes = ['small', 'medium', 'large'];
        
        for (let i = 0; i < this.config.expansionCircles; i++) {
            const circle = document.createElement('div');
            circle.className = `expansion-circle ${sizes[i]}`;
            
            // Position centrale avec légère variation
            circle.style.left = (45 + Math.random() * 10) + '%';
            circle.style.top = (45 + Math.random() * 10) + '%';
            circle.style.animationDelay = i * 4 + 's';
            
            this.container.appendChild(circle);
            this.animationElements.push(circle);
        }
    }

    // Gérer la responsivité
    setupResponsiveHandling() {
        window.addEventListener('resize', () => {
            if (this.resizeTimeout) {
                clearTimeout(this.resizeTimeout);
            }
            
            this.resizeTimeout = setTimeout(() => {
                this.adjustForScreenSize();
            }, 250);
        });
        
        // Ajustement initial
        this.adjustForScreenSize();
    }

    // Ajuster l'animation selon la taille d'écran
    adjustForScreenSize() {
        const isMobile = window.innerWidth <= 768;
        const isSmallMobile = window.innerWidth <= 480;
        
        if (this.container) {
            if (isSmallMobile) {
                this.container.style.opacity = '0.15';
            } else if (isMobile) {
                this.container.style.opacity = '0.25';
            } else {
                this.container.style.opacity = '0.3';
            }
        }
    }

    // Contrôler l'animation (pause/play)
    pauseAnimation() {
        if (this.container) {
            this.container.style.animationPlayState = 'paused';
            this.animationElements.forEach(element => {
                element.style.animationPlayState = 'paused';
            });
        }
    }

    playAnimation() {
        if (this.container) {
            this.container.style.animationPlayState = 'running';
            this.animationElements.forEach(element => {
                element.style.animationPlayState = 'running';
            });
        }
    }

    // Nettoyer l'animation
    destroy() {
        if (this.container && this.container.parentNode) {
            this.container.parentNode.removeChild(this.container);
        }
        
        if (this.resizeTimeout) {
            clearTimeout(this.resizeTimeout);
        }
        
        this.animationElements = [];
        this.isInitialized = false;
    }

    // Méthode pour optimiser les performances sur mobile
    optimizeForMobile() {
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        
        if (isMobile) {
            // Réduire le nombre d'éléments animés sur mobile
            this.config.particles.count = Math.floor(this.config.particles.count * 0.6);
            this.config.serviceLines.horizontal = Math.floor(this.config.serviceLines.horizontal * 0.7);
            this.config.serviceLines.vertical = Math.floor(this.config.serviceLines.vertical * 0.7);
            this.config.dataWaves = Math.floor(this.config.dataWaves * 0.8);
        }
    }
}

// Instance globale de l'animation
let heroAnimationInstance = null;

// Initialiser l'animation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', function() {
    // Attendre un peu pour que les autres éléments soient chargés
    setTimeout(() => {
        heroAnimationInstance = new HeroAnimation();
        heroAnimationInstance.optimizeForMobile();
        heroAnimationInstance.init();
    }, 500);
});

// Gérer la visibilité de la page pour optimiser les performances
document.addEventListener('visibilitychange', function() {
    if (heroAnimationInstance) {
        if (document.hidden) {
            heroAnimationInstance.pauseAnimation();
        } else {
            heroAnimationInstance.playAnimation();
        }
    }
});

// Exporter pour utilisation globale si nécessaire
window.HeroAnimation = HeroAnimation;

/**
 * Système de tracking des visiteurs
 * MYKLI Multi-services
 */

(function() {
    'use strict';

    // Générer un ID de session unique
    function generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    // Obtenir ou créer un ID de session
    function getSessionId() {
        let sessionId = sessionStorage.getItem('visitor_session_id');
        if (!sessionId) {
            sessionId = generateSessionId();
            sessionStorage.setItem('visitor_session_id', sessionId);
        }
        return sessionId;
    }

    // Envoyer les données de tracking
    function trackVisitor() {
        const data = {
            page_url: window.location.href,
            page_title: document.title,
            referrer: document.referrer,
            session_id: getSessionId(),
            screen_width: window.screen.width,
            screen_height: window.screen.height,
            language: navigator.language || navigator.userLanguage,
            timestamp: new Date().toISOString()
        };

        // Envoyer via fetch
        fetch('/MykliMultiservices/api/track-visitor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('✅ Visitor tracked successfully');
            } else {
                console.warn('⚠️ Tracking failed:', result.message);
            }
        })
        .catch(error => {
            console.error('❌ Tracking error:', error);
        });
    }

    // Tracker les événements de navigation
    function trackPageView() {
        trackVisitor();
    }

    // Tracker le temps passé sur la page
    let startTime = Date.now();
    
    window.addEventListener('beforeunload', function() {
        const timeSpent = Math.round((Date.now() - startTime) / 1000);
        
        // Utiliser sendBeacon pour envoyer les données même si la page se ferme
        if (navigator.sendBeacon) {
            const data = JSON.stringify({
                session_id: getSessionId(),
                time_spent: timeSpent,
                page_url: window.location.href,
                event: 'page_exit'
            });
            
            navigator.sendBeacon('/MykliMultiservices/api/track-visitor.php', data);
        }
    });

    // Initialiser le tracking au chargement de la page
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', trackPageView);
    } else {
        trackPageView();
    }

    // Tracker les clics sur les liens importants
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a, button');
        if (target) {
            const eventData = {
                session_id: getSessionId(),
                event_type: 'click',
                element: target.tagName,
                text: target.textContent.trim().substring(0, 50),
                href: target.href || '',
                page_url: window.location.href
            };

            // Envoyer l'événement de manière asynchrone
            fetch('/MykliMultiservices/api/track-event.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(eventData)
            }).catch(error => console.error('Event tracking error:', error));
        }
    });

    // Exposer une fonction globale pour le tracking manuel
    window.MykliTracker = {
        trackEvent: function(eventName, eventData) {
            fetch('/MykliMultiservices/api/track-event.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    session_id: getSessionId(),
                    event_name: eventName,
                    event_data: eventData,
                    page_url: window.location.href,
                    timestamp: new Date().toISOString()
                })
            }).catch(error => console.error('Custom event tracking error:', error));
        }
    };

    console.log('🔍 MYKLI Visitor Tracker initialized');
})();

document.addEventListener('DOMContentLoaded', () => {
    
    // Hilfsfunktion zum Öffnen
    const openModal = (id) => {
        const modal = document.getElementById(id);
        if (!modal) return;

        // 1. Overlay anzeigen (Hintergrund)
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // 2. Kurz warten (Browser-Reflow abwarten)
        setTimeout(() => {
            const innerBox = modal.querySelector('.trailer-shell');
            if (innerBox) {
                innerBox.classList.remove('opacity-0', 'scale-95');
                innerBox.classList.add('opacity-100', 'scale-100');
            }
        }, 10); // 10ms warten
    };

    // Hilfsfunktion zum Schließen
    const closeModal = (modalElement) => {
        const innerBox = modalElement.querySelector('.trailer-shell');
        
        // 1. Erst Animation zurücksetzen
        if (innerBox) {
            innerBox.classList.remove('opacity-100', 'scale-100');
            innerBox.classList.add('opacity-0', 'scale-95');
        }

        // 2. Nach der Animation (300ms) das Overlay verstecken
        setTimeout(() => {
            modalElement.classList.add('hidden');
            modalElement.classList.remove('flex');
        }, 300);
    };

    // --- Event Listener ---

    // Buttons zum Öffnen finden
    document.querySelectorAll('[data-modal]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const target = button.getAttribute('data-modal');
            openModal(target);
        });
    });

    // Schließen via X-Button
    document.querySelectorAll('[data-close]').forEach(button => {
        button.addEventListener('click', (e) => {
            const modal = button.closest('.modal');
            closeModal(modal);
        });
    });

    // Schließen via Klick auf dunklen Hintergrund
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            closeModal(e.target);
        }
    });

    // Schließen via ESC-Taste
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.modal.flex');
            if (activeModal) closeModal(activeModal);
        }
    });
});
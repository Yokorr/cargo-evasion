import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('bookingSystem', () => ({
    openDrawer: false,
    selectedBike: null,
    selectedDate: '',
    currentType: null,
    result: null,
    adding: false, // Fixe l'erreur "adding is not defined"

    initBooking(bike) {
        this.selectedBike = bike;
        this.selectedDate = '';
        this.currentType = null;
        this.result = null;
        this.openDrawer = true;
    },

    // Vérifie la disponibilité en fonction des réservations déjà présentes
    isSlotAvailable(type) {
        if (!this.selectedDate || !this.selectedBike || !this.selectedBike.bookings) return true;

        // On filtre les réservations du vélo pour la date sélectionnée
        const bookingsToday = this.selectedBike.bookings.filter(b => b.start_date.startsWith(this.selectedDate));

        if (bookingsToday.length === 0) return true;

        // Cas 1 : Quelqu'un a déjà pris la journée complète (09h - 17h30)
        const hasFullDay = bookingsToday.some(b => b.start_date.includes('09:00') && b.end_date.includes('17:30'));
        if (hasFullDay) return false;

        // Cas 2 : Vérification par créneau individuel
        if (type === 'morning') {
            return !bookingsToday.some(b => b.start_date.includes('09:00'));
        }
        if (type === 'afternoon') {
            return !bookingsToday.some(b => b.start_date.includes('13:30'));
        }
        if (type === 'full_day') {
            // Pour réserver la journée, il faut qu'il n'y ait ABSOLUMENT rien ce jour-là
            return bookingsToday.length === 0;
        }

        return true;
    },

    setSlot(type) {
        if (!this.isSlotAvailable(type)) return;

        this.currentType = type;
        let price = 0;

        // On récupère le prix selon le type (assure-toi que ces colonnes existent dans ton modèle Bike)
        if(type === 'morning') price = this.selectedBike.price_morning;
        if(type === 'afternoon') price = this.selectedBike.price_afternoon;
        if(type === 'full_day') price = this.selectedBike.price_full_day;

        this.result = { 
            available: true, 
            total_price: price,
            label: type === 'morning' ? 'Matinée' : (type === 'afternoon' ? 'Après-midi' : 'Journée complète')
        };
    },

    // Fixe l'erreur "addToCart is not defined"
    async addToCart() {
        if (!this.selectedDate || !this.currentType) return;
        
        this.adding = true;

        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
		    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    bike_id: this.selectedBike.id,
                    date: this.selectedDate,
                    type: this.currentType
                })
            });

            const data = await response.json();

            if (data.success) {
                // Redirige vers le panier si succès
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Erreur lors de l\'ajout');
                this.adding = false;
            }
        } catch (error) {
            console.error('Erreur AJAX:', error);
            this.adding = false;
        }
    }
}));

Alpine.data('paymentSelector', () => ({
    selected: 'monetico', // Par défaut, Monetico est sélectionné
    
    // Fonction pour changer le mode de paiement au clic
    selectMethod(method) {
        this.selected = method;
    }
}));

Alpine.start();
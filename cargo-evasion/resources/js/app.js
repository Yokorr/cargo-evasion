import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Composant de réservation pour la flotte
Alpine.data('bookingSystem', () => ({
    openDrawer: false,
    selectedBike: null,
    selectedDate: new Date().toISOString().slice(0, 10),
    start: '',
    end: '',
    result: null,
    loading: false,
    adding: false,
    currentType: '',

    initBooking(bike) {
        this.selectedBike = bike;
        this.openDrawer = true;
        this.result = null;
        this.start = '';
        this.end = '';
    },

    setSlot(type) {
        this.result = null; // On vide le résultat précédent pour forcer le rafraîchissement
        this.currentType = type;
        
        if(type === 'morning') {
            this.start = this.selectedDate + ' 09:00';
            this.end = this.selectedDate + ' 13:00';
        } else if(type === 'afternoon') {
            this.start = this.selectedDate + ' 13:30';
            this.end = this.selectedDate + ' 17:30';
        } else if(type === 'full_day') {
            this.start = this.selectedDate + ' 09:00';
            this.end = this.selectedDate + ' 17:30';
        }
        
        this.check();
    },

    async check() {
        if(!this.start || !this.end) return;
        this.loading = true;
        try {
            const response = await fetch('/bookings/check', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({ 
                    bike_id: this.selectedBike.id, 
                    start_date: this.start, 
                    end_date: this.end, 
                    type: this.currentType 
                })
            });
            this.result = await response.json();
        } catch (error) {
            console.error('Erreur check:', error);
        } finally {
            this.loading = false;
        }
    },

    async addToCart() {
        this.adding = true;
        try {
            await fetch('/cart/add', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({ 
                    bike_id: this.selectedBike.id, 
                    start_date: this.start, 
                    end_date: this.end,
                    total_price: this.result.total_price,
                    label: this.result.label
                })
            });
            window.location.href = '/cart';
        } catch (error) {
            console.error('Erreur ajout panier:', error);
            this.adding = false;
        }
    }
}));

Alpine.start();
document.addEventListener('DOMContentLoaded', function() {
    // Sample hotel data
    const hotels = [
        {
            id: 1,
            name: "Grand Plaza Hotel",
            location: "New York, USA",
            price: 199,
            rating: 4.5,
            image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
            amenities: ["Free WiFi", "Pool", "Spa", "Restaurant"]
        },
        {
            id: 2,
            name: "Beachside Resort",
            location: "Miami, USA",
            price: 249,
            rating: 4.8,
            image: "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
            amenities: ["Free WiFi", "Beach Access", "Pool", "Bar"]
        },
        {
            id: 3,
            name: "Mountain View Lodge",
            location: "Aspen, USA",
            price: 179,
            rating: 4.3,
            image: "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
            amenities: ["Free WiFi", "Ski-in/Ski-out", "Hot Tub", "Restaurant"]
        },
        {
            id: 4,
            name: "Urban Boutique Hotel",
            location: "San Francisco, USA",
            price: 229,
            rating: 4.6,
            image: "https://images.unsplash.com/photo-1534612899740-55c821a90129?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
            amenities: ["Free WiFi", "Gym", "Rooftop Bar", "Concierge"]
        }
    ];

    // DOM Elements
    const hotelsContainer = document.getElementById('hotels-container');
    const bookingsContainer = document.getElementById('bookings-container');
    const searchBtn = document.getElementById('search-hotels');
    const bookingModal = document.getElementById('booking-modal');
    const closeBtn = document.querySelector('.close-btn');
    const bookingForm = document.getElementById('booking-form');
    const newsletterForm = document.getElementById('newsletter-form');

    // Initialize bookings array from localStorage or create empty array
    let bookings = JSON.parse(localStorage.getItem('bookings')) || [];

    // Display hotels on homepage
    function displayHotels(hotelsToDisplay) {
        if (!hotelsContainer) return;
        
        hotelsContainer.innerHTML = '';
        
        hotelsToDisplay.forEach(hotel => {
            const stars = '★'.repeat(Math.floor(hotel.rating)) + '☆'.repeat(5 - Math.floor(hotel.rating));
            
            const hotelCard = document.createElement('div');
            hotelCard.className = 'hotel-card';
            hotelCard.innerHTML = `
                <div class="hotel-img">
                    <img src="${hotel.image}" alt="${hotel.name}">
                </div>
                <div class="hotel-info">
                    <h3>${hotel.name}</h3>
                    <p class="location"><i class="fas fa-map-marker-alt"></i> ${hotel.location}</p>
                    <div class="amenities">
                        ${hotel.amenities.map(amenity => `<span><i class="fas fa-check"></i> ${amenity}</span>`).join('')}
                    </div>
                    <p class="price">$${hotel.price} <span>/night</span></p>
                    <div class="rating">
                        ${stars}
                    </div>
                    <button class="btn book-now" data-id="${hotel.id}">Book Now</button>
                </div>
            `;
            
            hotelsContainer.appendChild(hotelCard);
        });
        
        // Add event listeners to book now buttons
        document.querySelectorAll('.book-now').forEach(button => {
            button.addEventListener('click', function() {
                const hotelId = parseInt(this.getAttribute('data-id'));
                const hotel = hotels.find(h => h.id === hotelId);
                openBookingModal(hotel);
            });
        });
    }

    // Open booking modal with hotel details
    function openBookingModal(hotel) {
        if (!bookingModal) return;
        
        document.getElementById('hotel-name').textContent = hotel.name;
        document.getElementById('hotel-id').value = hotel.id;
        
        // Set default dates
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        document.getElementById('check-in').valueAsDate = today;
        document.getElementById('check-out').valueAsDate = tomorrow;
        
        bookingModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    // Close booking modal
    function closeBookingModal() {
        if (!bookingModal) return;
        bookingModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Save booking to localStorage
    function saveBooking(bookingData) {
        bookings.push(bookingData);
        localStorage.setItem('bookings', JSON.stringify(bookings));
        
        // Show confirmation
        alert(`Booking confirmed for ${bookingData.hotelName}!\nCheck-in: ${bookingData.checkIn}\nTotal: $${bookingData.totalPrice}`);
        
        // If on bookings page, refresh the display
        if (bookingsContainer) {
            displayBookings();
        }
        
        closeBookingModal();
    }

    // Display all bookings on bookings page
    function displayBookings() {
        if (!bookingsContainer) return;
        
        if (bookings.length === 0) {
            bookingsContainer.innerHTML = '<p class="no-bookings">You have no bookings yet.</p>';
            return;
        }
        
        bookingsContainer.innerHTML = bookings.map((booking, index) => `
            <div class="booking-card">
                <div class="booking-header">
                    <h3>${booking.hotelName}</h3>
                    <span class="booking-status">Confirmed</span>
                </div>
                <div class="booking-details">
                    <div class="booking-image">
                        <img src="${booking.hotelImage || 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'}" alt="${booking.hotelName}">
                    </div>
                    <div class="booking-info">
                        <p><strong>Guest:</strong> ${booking.fullName}</p>
                        <p><strong>Email:</strong> ${booking.email}</p>
                        <p><strong>Phone:</strong> ${booking.phone}</p>
                        <p><strong>Dates:</strong> ${formatDate(booking.checkIn)} to ${formatDate(booking.checkOut)}</p>
                        <p><strong>Guests:</strong> ${booking.guests}</p>
                        <p><strong>Total:</strong> $${booking.totalPrice}</p>
                        <p><strong>Booked on:</strong> ${formatDate(booking.bookingDate)}</p>
                    </div>
                </div>
                <button class="btn cancel-booking" data-index="${index}">Cancel Booking</button>
            </div>
        `).join('');
        
        // Add event listeners to cancel buttons
        document.querySelectorAll('.cancel-booking').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                cancelBooking(index);
            });
        });
    }

    // Format date for display
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    // Calculate number of nights between two dates
    function calculateNights(checkIn, checkOut) {
        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        const firstDate = new Date(checkIn);
        const secondDate = new Date(checkOut);
        return Math.round(Math.abs((firstDate - secondDate) / oneDay));
    }

    // Cancel a booking
    function cancelBooking(index) {
        if (confirm('Are you sure you want to cancel this booking?')) {
            const cancelledBooking = bookings.splice(index, 1)[0];
            localStorage.setItem('bookings', JSON.stringify(bookings));
            
            // Show confirmation
            alert(`Booking for ${cancelledBooking.hotelName} has been cancelled.`);
            
            displayBookings();
        }
    }

    // Search hotels
    function searchHotels() {
        if (!searchBtn) return;
        
        const destination = document.getElementById('destination').value.toLowerCase();
        const checkIn = document.getElementById('check-in').value;
        const checkOut = document.getElementById('check-out').value;
        const guests = document.getElementById('guests').value;
        
        // In a real app, you would make an API call here
        let results = hotels;
        
        if (destination) {
            results = results.filter(hotel => 
                hotel.name.toLowerCase().includes(destination) || 
                hotel.location.toLowerCase().includes(destination)
            );
        }
        
        displayHotels(results);
    }

    // Event Listeners
    if (searchBtn) {
        searchBtn.addEventListener('click', searchHotels);
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeBookingModal);
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === bookingModal) {
            closeBookingModal();
        }
    });
    
    // Booking form submission
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const hotelId = parseInt(document.getElementById('hotel-id').value);
            const hotel = hotels.find(h => h.id === hotelId);
            
            // Calculate total price
            const nights = calculateNights(
                document.getElementById('check-in').value,
                document.getElementById('check-out').value
            );
            const totalPrice = hotel.price * nights;
            
            const bookingData = {
                hotelId: hotel.id,
                hotelName: hotel.name,
                hotelImage: hotel.image,
                fullName: document.getElementById('full-name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                checkIn: document.getElementById('check-in').value,
                checkOut: document.getElementById('check-out').value,
                guests: document.getElementById('guests').value,
                totalPrice: totalPrice,
                bookingDate: new Date().toISOString()
            };
            
            saveBooking(bookingData);
            this.reset();
        });
    }
    
    // Newsletter form submission
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input').value;
            
            // Save to localStorage
            let subscribers = JSON.parse(localStorage.getItem('newsletterSubscribers')) || [];
            subscribers.push(email);
            localStorage.setItem('newsletterSubscribers', JSON.stringify(subscribers));
            
            alert(`Thank you for subscribing with ${email}!`);
            this.reset();
        });
    }

    // Initialize
    if (hotelsContainer) {
        displayHotels(hotels);
        
        // Set default dates for search
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        document.getElementById('check-in').valueAsDate = today;
        document.getElementById('check-out').valueAsDate = tomorrow;
    }
    
    // Display bookings if on bookings page
    displayBookings();
});
<?php 
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$table = new Userstable(new MySQL);
$users = $table->all();

$user = Auth::check();
if ($user) {
    $table = new UsersTable(new MySQL());
   
    $currentUser = $table->findById($user->id);
} else {
    HTTP::redirect("/login.php");
}
?>



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise Hotels - Book Your Dream Stay</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        
        .profile-container {
            max-width: 600px;
            margin-top: 50px;
            text-align: center;
        
        }
  .profile-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #007bff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 15px;
  }

  .name {
    font-weight: bold;
    color: #007bff;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    text-align: center;
  }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>Paradise Hotels</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#hotels">Hotels</a></li>
                    <li><a href="#destinations">Destinations</a></li>
                    <li><a href="#deals">Deals</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="bookings.html">My Bookings</a></li>
                </ul>
            </nav>
            <div class="auth-buttons navbar-nav">
                <!-- <a href="home.php"><button class="btn login-btn">Login</button></a> -->
                <a href="profile.php" class="nav-link name" style="display: inline;" > 
                        
                <?php if (!empty($currentUser->photo)): ?>
        <img src="photo/<?= $currentUser->photo; ?>" alt="Profile Photo" class="profile-img">
    <?php else: ?>
        <img src="photo/default.png" alt="Default Photo" class="profile-img">
    <?php endif; ?><?= $user->name?> </a>
                <a href="register.php"><button class="btn signup-btn">Sign Up</button></a>
            </div>
            <div id="user-profile" style="display: none;">
                <!-- Will be filled by JavaScript -->
            </div>
            <button id="logout-btn" class="btn" style="display: none;">Logout</button>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h2>Find Your Perfect Stay</h2>
            <p>Discover amazing hotels at unbeatable prices</p>
            
            <div class="search-box">
                <div class="search-input">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" placeholder="Where are you going?" id="destination">
                </div>
                <div class="search-input">
                    <i class="fas fa-calendar"></i>
                    <input type="date" id="check-in">
                </div>
                <div class="search-input">
                    <i class="fas fa-calendar"></i>
                    <input type="date" id="check-out">
                </div>
                <div class="search-input">
                    <i class="fas fa-user"></i>
                    <select id="guests">
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5+ Guests</option>
                    </select>
                </div>
                <button class="btn search-btn" id="search-hotels">Search</button>
            </div>
        </div>
    </section>

    <section class="featured-hotels" id="hotels">
        <div class="container">
            <h2>Featured Hotels</h2>
            <div class="hotels-grid" id="hotels-container">
                <!-- Hotels will be loaded here by JavaScript -->
            </div>
        </div>
    </section>

    <section class="destinations" id="destinations">
        <div class="container">
            <h2>Popular Destinations</h2>
            <div class="destinations-grid">
                <div class="destination-card">
                    <img src="https://images.unsplash.com/photo-1518391846015-55a9cc003b25?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Paris">
                    <div class="destination-info">
                        <h3>Paris</h3>
                        <p>France</p>
                    </div>
                </div>
                <div class="destination-card">
                    <img src="https://images.unsplash.com/photo-1533929736458-ca588d08c8be?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="New York">
                    <div class="destination-info">
                        <h3>New York</h3>
                        <p>USA</p>
                    </div>
                </div>
                <div class="destination-card">
                    <img src="https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Tokyo">
                    <div class="destination-info">
                        <h3>Tokyo</h3>
                        <p>Japan</p>
                    </div>
                </div>
                <div class="destination-card">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Rome">
                    <div class="destination-info">
                        <h3>Rome</h3>
                        <p>Italy</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="deals" id="deals">
        <div class="container">
            <h2>Special Deals</h2>
            <div class="deals-slider">
                <div class="deal-card">
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Beach Resort">
                    <div class="deal-info">
                        <h3>Beach Paradise</h3>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> Maldives</p>
                        <p class="price">$199 <span>/night</span></p>
                        <p class="discount">30% OFF</p>
                        <button class="btn book-now">Book Now</button>
                    </div>
                </div>
                <div class="deal-card">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Mountain Resort">
                    <div class="deal-info">
                        <h3>Mountain Retreat</h3>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> Switzerland</p>
                        <p class="price">$249 <span>/night</span></p>
                        <p class="discount">25% OFF</p>
                        <button class="btn book-now">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2>What Our Guests Say</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review">"The hotel was amazing! Great location, friendly staff, and comfortable rooms. Will definitely come back!"</p>
                    <p class="guest-name">- Sarah Johnson</p>
                </div>
                <div class="testimonial-card">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review">"Excellent service and beautiful facilities. The view from our room was breathtaking."</p>
                    <p class="guest-name">- Michael Chen</p>
                </div>
            </div>
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest deals and offers straight to your inbox</p>
            <form id="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit" class="btn subscribe-btn">Subscribe</button>
            </form>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Paradise Hotels</h3>
                    <p>Making your travel dreams come true with the perfect stay.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#hotels">Hotels</a></li>
                        <li><a href="#destinations">Destinations</a></li>
                        <li><a href="#deals">Deals</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Hotel Street, City</li>
                        <li><i class="fas fa-phone"></i> +1 234 567 890</li>
                        <li><i class="fas fa-envelope"></i> info@paradisehotels.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 Paradise Hotels. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Booking Modal -->
    <div class="modal" id="booking-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Complete Your Booking</h2>
            <h3 id="hotel-name"></h3>
            <form id="booking-form">
                <input type="hidden" id="hotel-id">
                
                <div class="form-group">
                    <label for="full-name">Full Name</label>
                    <input type="text" id="full-name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="check-in">Check-in Date</label>
                        <input type="date" id="check-in" required>
                    </div>
                    <div class="form-group">
                        <label for="check-out">Check-out Date</label>
                        <input type="date" id="check-out" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="guests">Number of Guests</label>
                    <select id="guests" required>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5+ Guests</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="card-number">Credit Card Number</label>
                    <input type="text" id="card-number" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry">Expiry Date</label>
                        <input type="text" id="expiry" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" required>
                    </div>
                </div>
                <button type="submit" class="btn confirm-booking">Confirm Booking</button>
            </form>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Login to Your Account</h2>
            <form id="login-form">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" required>
                </div>
                <button type="submit" class="btn">Login</button>
                <p class="auth-switch">Don't have an account? <a href="#" id="switch-to-signup">Sign up</a></p>
            </form>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal" id="signup-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Create an Account</h2>
            <form id="signup-form">
                <div class="form-group">
                    <label for="signup-name">Full Name</label>
                    <input type="text" id="signup-name" required>
                </div>
                <div class="form-group">
                    <label for="signup-email">Email</label>
                    <input type="email" id="signup-email" required>
                </div>
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" required>
                    <small>At least 6 characters</small>
                </div>
                <div class="form-group">
                    <label for="signup-confirm-password">Confirm Password</label>
                    <input type="password" id="signup-confirm-password" required>
                </div>
                <button type="submit" class="btn">Sign Up</button>
                <p class="auth-switch">Already have an account? <a href="#" id="switch-to-login">Login</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
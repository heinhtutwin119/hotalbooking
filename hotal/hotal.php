<?php
// Database connection (using default XAMPP credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_bookings";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Create table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS bookings (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT(3) NOT NULL,
    hotel_id INT(6) NOT NULL,
    special_requests TEXT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($createTable)) {
    die("Error creating table: " . $conn->error);
}

// Process form submission
$booking_success = false;
$booking_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_booking'])) {
    // Sanitize and validate input data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $check_in = $conn->real_escape_string($_POST['check_in']);
    $check_out = $conn->real_escape_string($_POST['check_out']);
    $guests = intval($_POST['guests']);
    $hotel_id = isset($_POST['hotel_id']) ? intval($_POST['hotel_id']) : 1;
    $special_requests = $conn->real_escape_string($_POST['special_requests']);

    // Insert into database
    $sql = "INSERT INTO bookings (full_name, email, phone, check_in, check_out, guests, hotel_id, special_requests)
            VALUES ('$full_name', '$email', '$phone', '$check_in', '$check_out', $guests, $hotel_id, '$special_requests')";

    if ($conn->query($sql)) {
        $booking_success = true;
        $booking_id = $conn->insert_id;
    } else {
        $booking_error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise Hotels - Book Your Stay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #003366;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .booking-form {
            background: #f4f4f4;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background: #003366;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background: #002244;
        }
        .success-message {
            color: green;
            font-weight: bold;
            padding: 15px;
            background: #e6ffe6;
            border: 1px solid #b3ffb3;
            border-radius: 4px;
            margin: 20px 0;
        }
        .error-message {
            color: red;
            font-weight: bold;
            padding: 15px;
            background: #ffebeb;
            border: 1px solid #ffb3b3;
            border-radius: 4px;
            margin: 20px 0;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Paradise Hotels</h1>
        </div>
    </header>

    <div class="container">
        <?php if (isset($booking_success) && $booking_success): ?>
            <div class="success-message">
                <h2>Booking Confirmed! <i class="fas fa-check-circle"></i></h2>
                <p>Thank you for your booking, <?php echo htmlspecialchars($full_name); ?>!</p>
                <p>Your booking reference number is: <strong><?php echo $booking_id; ?></strong></p>
                <p>We've sent a confirmation to <strong><?php echo htmlspecialchars($email); ?></strong></p>
                <p><a href="hotelbooking.php">Make another booking</a></p>
            </div>
        <?php elseif (isset($booking_error)): ?>
            <div class="error-message">
                <h2>Booking Error <i class="fas fa-exclamation-circle"></i></h2>
                <p><?php echo $booking_error; ?></p>
                <p>Please try again or contact support.</p>
            </div>
        <?php endif; ?>

        <h2>Book Your Hotel Stay</h2>
        
        <form class="booking-form" method="POST" action="hotelbooking.php">
            <input type="hidden" name="hotel_id" value="<?php echo isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 1; ?>">
            
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" required value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" id="phone" name="phone" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="check_in">Check-in Date *</label>
                    <input type="date" id="check_in" name="check_in" required value="<?php echo isset($_POST['check_in']) ? htmlspecialchars($_POST['check_in']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="check_out">Check-out Date *</label>
                    <input type="date" id="check_out" name="check_out" required value="<?php echo isset($_POST['check_out']) ? htmlspecialchars($_POST['check_out']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="guests">Number of Guests *</label>
                <select id="guests" name="guests" required>
                    <option value="1" <?php echo (isset($_POST['guests']) && $_POST['guests'] == 1) ? 'selected' : ''; ?>>1 Guest</option>
                    <option value="2" <?php echo (isset($_POST['guests']) && $_POST['guests'] == 2) ? 'selected' : ''; ?>>2 Guests</option>
                    <option value="3" <?php echo (isset($_POST['guests']) && $_POST['guests'] == 3) ? 'selected' : ''; ?>>3 Guests</option>
                    <option value="4" <?php echo (isset($_POST['guests']) && $_POST['guests'] == 4) ? 'selected' : ''; ?>>4 Guests</option>
                    <option value="5" <?php echo (isset($_POST['guests']) && $_POST['guests'] == 5) ? 'selected' : ''; ?>>5+ Guests</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="special_requests">Special Requests</label>
                <textarea id="special_requests" name="special_requests" rows="4"><?php echo isset($_POST['special_requests']) ? htmlspecialchars($_POST['special_requests']) : ''; ?></textarea>
            </div>
            
            <button type="submit" name="submit_booking">Confirm Booking</button>
        </form>
    </div>

    <?php
    // Close database connection
    $conn->close();
    ?>
</body>
</html>
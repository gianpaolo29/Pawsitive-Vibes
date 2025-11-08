<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Pawsitive Vibes</title>
    <link rel="icon" type="image/png" href="C:\Users\Theresa\OneDrive\Documents\Web System and Technologies & System Integration and Architecture\PawsitiveVibes\icons\logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-violet: #8a2be2;
            --light-violet: #b19cd9;
            --dark-violet: #6a0dad;
            --violet-blue: #6c63ff;
            --light-violet-blue: #a5a1ff;
            --dark-violet-blue: #5651d4;
            --vibrant-violet: #7b68ee;
            --bright-violet: #9370db;
            --yellow: #F9DF71;
            --light-yellow: #fff9e6;
            --soft-white: #fefefe;
            --light-gray: #f8f7ff;
            --medium-gray: #e0ddf5;
            --text-gray: #666;
            --dark-gray: #444;
            --card-shadow: 0 5px 15px rgba(138, 43, 226, 0.08);
            --hover-shadow: 0 8px 25px rgba(138, 43, 226, 0.15);
        }

        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: var(--dark-gray);
            line-height: 1.5;
        }

        /* Navigation Bar Styles - Compact */
        .glass-navbar {
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            color: var(--primary-violet);
            font-weight: 700;
            font-size: 1.3rem;
            font-family: 'Quicksand', sans-serif;
        }

        .logo-img {
            width: 35px;
            height: 35px;
            margin-right: 10px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin: 0 8px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-gray);
            font-weight: 500;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a i {
            font-size: 1.1rem;
            margin-bottom: 3px;
            transition: all 0.3s ease;
        }

        .nav-links a span {
            font-size: 0.75rem;
        }

        .nav-links a:hover {
            background: rgba(138, 43, 226, 0.05);
            color: var(--primary-violet);
            transform: translateY(-2px);
        }

        .nav-links a:hover i {
            color: var(--primary-violet);
            transform: scale(1.1);
        }

        .nav-links a.active {
            background: rgba(138, 43, 226, 0.08);
            color: var(--primary-violet);
        }

        .nav-links a.active i {
            color: var(--primary-violet);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background: var(--yellow);
            border-radius: 50%;
        }

        .nav-hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            color: var(--dark-gray);
            font-size: 1.3rem;
        }

        /* Main Content Styles - Compact */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
        }

        .page-title {
            text-align: center;
            margin: 25px 0 15px;
            font-size: 2.2rem;
            color: var(--dark-gray);
            font-weight: 700;
            font-family: 'Quicksand', sans-serif;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--yellow);
            border-radius: 2px;
        }

        .page-subtitle {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1rem;
            color: var(--text-gray);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.5;
        }

        /* Cart Section */
        .cart-section {
            margin: 40px 0;
        }

        .cart-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            margin-top: 20px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .cart-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .select-all {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            color: var(--primary-violet);
        }

        .select-all:hover {
            background: rgba(138, 43, 226, 0.05);
        }

        .select-all input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-violet);
            cursor: pointer;
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-item {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .cart-item-checkbox {
            margin-right: 15px;
        }

        .cart-item-checkbox input {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid var(--medium-gray);
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-item-checkbox input:checked {
            background: var(--primary-violet);
            border-color: var(--primary-violet);
        }

        .cart-item-checkbox input:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--light-violet), var(--vibrant-violet));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .cart-item-details {
            flex-grow: 1;
            padding-right: 20px;
        }

        .cart-item-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 8px;
            font-family: 'Quicksand', sans-serif;
        }

        .cart-item-variant {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .variant-select {
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid var(--medium-gray);
            background: white;
            font-size: 0.9rem;
            color: var(--dark-gray);
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238a2be2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 35px;
            min-width: 180px;
        }

        .variant-select:focus {
            outline: none;
            border-color: var(--primary-violet);
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.1);
        }

        .variant-select:hover {
            border-color: var(--primary-violet);
        }

        .cart-item-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-violet);
            margin-bottom: 10px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            background: var(--light-gray);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--dark-gray);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .quantity-btn:hover {
            background: var(--primary-violet);
            color: white;
            transform: scale(1.05);
        }

        .quantity-display {
            width: 50px;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark-gray);
            padding: 8px;
            background: var(--light-gray);
            border-radius: 8px;
        }

        .cart-item-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-gray);
            min-width: 120px;
            text-align: right;
        }

        .remove-item {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-item:hover {
            color: #ff4757;
            background: rgba(255, 71, 87, 0.1);
            transform: scale(1.1);
        }

        /* Cart Summary */
        .cart-summary {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
            text-align: center;
            position: relative;
        }

        .summary-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: var(--yellow);
            border-radius: 2px;
        }

        .order-number {
            background: var(--light-yellow);
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(249, 223, 113, 0.3);
        }

        .order-number-label {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 5px;
        }

        .order-number-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        /* Checkout Items Section */
        .checkout-items {
            margin-bottom: 20px;
        }

        .checkout-items-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkout-items-title i {
            color: var(--primary-violet);
        }

        .checkout-items-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            padding: 10px;
        }

        .checkout-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .checkout-item:last-child {
            border-bottom: none;
        }

        .checkout-item-name {
            font-size: 0.9rem;
            color: var(--dark-gray);
            flex: 1;
        }

        .checkout-item-variant {
            font-size: 0.8rem;
            color: var(--text-gray);
            margin-right: 10px;
        }

        .checkout-item-quantity {
            font-size: 0.8rem;
            color: var(--text-gray);
            margin-right: 10px;
        }

        .checkout-item-price {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-violet);
        }

        .no-items-message {
            text-align: center;
            color: var(--text-gray);
            font-size: 0.9rem;
            padding: 20px;
        }

        .summary-total {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-violet);
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .checkout-btn {
            background: var(--primary-violet);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.2);
        }

        .checkout-btn:hover {
            background: var(--dark-violet);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.3);
        }

        .checkout-btn:disabled {
            background: var(--text-gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-gray);
        }

        .empty-cart-icon {
            font-size: 4rem;
            color: var(--light-violet);
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-family: 'Quicksand', sans-serif;
        }

        .continue-shopping {
            display: inline-block;
            background: var(--primary-violet);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.2);
        }

        .continue-shopping:hover {
            background: var(--dark-violet);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.3);
        }

        /* Updated Footer with #8259E2 background - Compact */
        .footer {
            background: #8259E2;
            padding: 35px 20px 20px;
            margin-top: 60px;
            text-align: center;
            color: white;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--yellow);
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .footer-logo {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
            font-family: 'Quicksand', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer-logo-img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            list-style: none;
            margin: 20px 0;
        }

        .footer-links li {
            margin: 0 15px;
            position: relative;
        }

        .footer-links li:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -15px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 3px;
            background: var(--yellow);
            border-radius: 50%;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: var(--yellow);
            transform: translateY(-2px);
        }

        .copyright {
            margin-top: 20px;
            font-size: 0.8rem;
            opacity: 0.8;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Mobile Bottom Navigation - Hidden on Desktop */
        .mobile-bottom-nav {
            display: none;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            /* Add padding to body for mobile bottom nav */
            body {
                padding-bottom: 70px;
            }
            
            .cart-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }
            
            .cart-item-checkbox {
                position: absolute;
                top: 15px;
                left: 15px;
            }
            
            .cart-item-image {
                width: 100%;
                height: 150px;
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .cart-item-details {
                padding-right: 0;
                width: 100%;
            }
            
            .cart-summary {
                position: static;
            }
            
            /* Mobile Bottom Navigation */
            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                display: flex;
                justify-content: space-around;
                padding: 10px 0;
                box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.08);
                border-top: 1px solid rgba(0, 0, 0, 0.05);
                z-index: 1000;
            }
            
            .mobile-nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: var(--dark-gray);
                font-size: 0.7rem;
                padding: 5px 10px;
                border-radius: 10px;
                transition: all 0.3s ease;
            }
            
            .mobile-nav-item i {
                font-size: 1.2rem;
                margin-bottom: 3px;
                transition: all 0.3s ease;
            }
            
            .mobile-nav-item.active {
                color: var(--primary-violet);
                background: rgba(138, 43, 226, 0.08);
            }
            
            .mobile-nav-item.active i {
                color: var(--primary-violet);
            }
            
            .mobile-nav-item:hover {
                color: var(--primary-violet);
            }
            
            .nav-links {
                display: none;
            }

            .nav-hamburger {
                display: none; /* Remove hamburger menu */
            }

            .page-title {
                font-size: 1.8rem;
            }
            
            .footer-links {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .footer-links li {
                margin: 5px 10px;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.6rem;
            }
            
            .footer-links {
                flex-direction: column;
            }
            
            .footer-links li {
                margin: 3px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="glass-navbar">
        <div class="nav-logo">
            <img src="C:\Users\Theresa\OneDrive\Documents\Web System and Technologies & System Integration and Architecture\PawsitiveVibes\icons\logo.png" alt="Pawsitive Vibes Logo" class="logo-img">
            <span>Pawsitive Vibes</span>
        </div>
        
        <ul class="nav-links">
            <li><a href="index.html"><i class="fas fa-home"></i> <span>Home</span></a></li>
            <li><a href="#"><i class="fas fa-heart"></i> <span>Favorites</span></a></li>
            <li><a href="#"><i class="fas fa-hand-holding-usd"></i> <span>Donate</span></a></li>
            <li><a href="cart.html" class="active"><i class="fas fa-shopping-cart"></i> <span>Cart</span></a></li>
            <li><a href="#"><i class="fas fa-user"></i> <span>Profile</span></a></li>
        </ul>
        
        <button class="nav-hamburger" id="navHamburger">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Your Shopping Cart</h1>
        <p class="page-subtitle">Review your items and proceed to checkout</p>
        
        <!-- Cart Section -->
        <section class="cart-section">
            <div class="cart-container" id="cartContainer">
                <!-- Cart items will be dynamically added here -->
            </div>
        </section>
    </div>

    <!-- Updated Footer with #8259E2 background -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="C:\Users\Theresa\OneDrive\Documents\Web System and Technologies & System Integration and Architecture\PawsitiveVibes\icons\logo.png" alt="Pawsitive Vibes Logo" class="footer-logo-img">
                <span>Pawsitive Vibes</span>
            </div>
            <ul class="footer-links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Shipping Policy</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
            <p class="copyright">© 2023 Pawsitive Vibes. All rights reserved.</p>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <a href="index.html" class="mobile-nav-item">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="#" class="mobile-nav-item">
            <i class="fas fa-heart"></i>
            <span>Favorites</span>
        </a>
        <a href="#" class="mobile-nav-item">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Donate</span>
        </a>
        <a href="cart.html" class="mobile-nav-item active">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="#" class="mobile-nav-item">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </div>

    <script>
        // Sample product data for Pawsitive Vibes
        const products = [
            { 
                id: 1, 
                name: "Premium Dog Food", 
                price: 34.99, 
                icon: "fas fa-bone", 
                badge: "Popular", 
                category: "Dog Food", 
                description: "Nutritionally balanced food for all dog breeds with natural ingredients.",
                variants: ["Small (5kg)", "Medium (10kg)", "Large (20kg)"]
            },
            { 
                id: 2, 
                name: "Cat Scratching Post", 
                price: 42.99, 
                icon: "fas fa-cat", 
                category: "Cat Food", 
                description: "Durable scratching post to keep your cat's claws healthy and your furniture safe.",
                variants: ["Standard", "Deluxe"]
            },
            { 
                id: 3, 
                name: "Pet Carrier", 
                price: 59.99, 
                icon: "fas fa-suitcase", 
                badge: "New", 
                category: "Accessories", 
                description: "Comfortable and secure carrier for safe pet transportation.",
                variants: ["Small", "Medium", "Large"]
            },
            { 
                id: 4, 
                name: "Interactive Toy", 
                price: 18.99, 
                icon: "fas fa-gamepad", 
                category: "Toys", 
                description: "Engaging toy that stimulates your pet's mind and keeps them active.",
                variants: ["Standard", "Interactive"]
            },
            { 
                id: 5, 
                name: "Comfy Pet Bed", 
                price: 49.99, 
                icon: "fas fa-bed", 
                badge: "Sale", 
                category: "Beds", 
                description: "Orthopedic pet bed with memory foam for ultimate comfort.",
                variants: ["Small", "Medium", "Large"]
            }
        ];

        // Initialize cart with 5 dummy items
        let cart = [
            { id: 1, quantity: 2, variant: "Medium (10kg)", selected: true },
            { id: 2, quantity: 1, variant: "Deluxe", selected: true },
            { id: 3, quantity: 1, variant: "Large", selected: true },
            { id: 4, quantity: 1, variant: "Interactive", selected: true },
            { id: 5, quantity: 3, variant: "Medium", selected: true }
        ];

        let orderNumber = generateOrderNumber();

        // Save to localStorage to persist the cart
        localStorage.setItem('cart', JSON.stringify(cart));

        // Function to generate order number
        function generateOrderNumber() {
            const prefix = "PV";
            const timestamp = Date.now().toString().slice(-6);
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            return `${prefix}-${timestamp}-${random}`;
        }

        // Function to render cart items
        function renderCart() {
            const cartContainer = document.getElementById('cartContainer');
            
            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="index.html" class="continue-shopping">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                `;
                return;
            }

            let total = 0;
            const allSelected = cart.every(item => item.selected);
            const selectedItems = cart.filter(item => item.selected);

            // Generate cart items HTML
            const cartItemsHTML = cart.map(item => {
                const product = products.find(p => p.id === item.id);
                const itemTotal = product.price * item.quantity;
                if (item.selected) {
                    total += itemTotal;
                }
                
                // Generate options for variant dropdown
                const variantOptions = product.variants.map(variant => 
                    `<option value="${variant}" ${variant === item.variant ? 'selected' : ''}>${variant}</option>`
                ).join('');
                
                return `
                    <div class="cart-item" data-id="${item.id}">
                        <div class="cart-item-checkbox">
                            <input type="checkbox" ${item.selected ? 'checked' : ''} data-id="${item.id}">
                        </div>
                        <div class="cart-item-image">
                            <i class="${product.icon}"></i>
                        </div>
                        <div class="cart-item-details">
                            <h3 class="cart-item-name">${product.name}</h3>
                            <div class="cart-item-variant">
                                <span>Variant:</span>
                                <select class="variant-select" data-id="${item.id}">
                                    ${variantOptions}
                                </select>
                            </div>
                            <div class="cart-item-price">$${product.price.toFixed(2)}</div>
                            <div class="cart-item-quantity">
                                <button class="quantity-btn decrease-btn" data-id="${item.id}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <div class="quantity-display">${item.quantity}</div>
                                <button class="quantity-btn increase-btn" data-id="${item.id}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="cart-item-total">$${itemTotal.toFixed(2)}</div>
                        <button class="remove-item" data-id="${item.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            }).join('');

            // Generate checkout items HTML
            const checkoutItemsHTML = selectedItems.length > 0 
                ? selectedItems.map(item => {
                    const product = products.find(p => p.id === item.id);
                    const itemTotal = product.price * item.quantity;
                    return `
                        <div class="checkout-item">
                            <div class="checkout-item-name">${product.name}</div>
                            <div class="checkout-item-variant">${item.variant}</div>
                            <div class="checkout-item-quantity">${item.quantity}x</div>
                            <div class="checkout-item-price">$${itemTotal.toFixed(2)}</div>
                        </div>
                    `;
                }).join('')
                : `<div class="no-items-message">No items selected for checkout</div>`;

            const hasSelectedItems = selectedItems.length > 0;

            cartContainer.innerHTML = `
                <div class="cart-items-container">
                    <div class="cart-header">
                        <h2 class="cart-title">Your Items (${cart.length})</h2>
                        <div class="select-all" id="selectAll">
                            <input type="checkbox" ${allSelected ? 'checked' : ''}>
                            <span>${allSelected ? 'Unselect All' : 'Select All'}</span>
                        </div>
                    </div>
                    <div class="cart-items">
                        ${cartItemsHTML}
                    </div>
                </div>
                <div class="cart-summary">
                    <div class="order-number">
                        <div class="order-number-label">Order Number</div>
                        <div class="order-number-value">${orderNumber}</div>
                    </div>
                    
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="checkout-items">
                        <div class="checkout-items-title">
                            <i class="fas fa-shopping-bag"></i>
                            Items to Checkout (${selectedItems.length})
                        </div>
                        <div class="checkout-items-list">
                            ${checkoutItemsHTML}
                        </div>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span>$${total.toFixed(2)}</span>
                    </div>
                    
                    <button class="checkout-btn" ${!hasSelectedItems ? 'disabled' : ''}>
                        <i class="fas fa-lock"></i> Proceed to Checkout
                    </button>
                </div>
            `;

            // Add event listeners
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', removeItem);
            });

            document.querySelectorAll('.cart-item-checkbox input').forEach(checkbox => {
                checkbox.addEventListener('change', toggleItemSelection);
            });

            document.querySelectorAll('.decrease-btn').forEach(btn => {
                btn.addEventListener('click', decreaseQuantity);
            });

            document.querySelectorAll('.increase-btn').forEach(btn => {
                btn.addEventListener('click', increaseQuantity);
            });

            document.querySelectorAll('.variant-select').forEach(select => {
                select.addEventListener('change', updateVariant);
            });

            // Fixed select all functionality
            const selectAllElement = document.getElementById('selectAll');
            if (selectAllElement) {
                selectAllElement.addEventListener('click', toggleSelectAll);
            }

            document.querySelector('.checkout-btn').addEventListener('click', checkout);
        }

        // Function to decrease quantity
        function decreaseQuantity(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const itemIndex = cart.findIndex(item => item.id === productId);
            
            if (itemIndex !== -1) {
                if (cart[itemIndex].quantity > 1) {
                    cart[itemIndex].quantity--;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                }
            }
        }

        // Function to increase quantity
        function increaseQuantity(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const itemIndex = cart.findIndex(item => item.id === productId);
            
            if (itemIndex !== -1) {
                cart[itemIndex].quantity++;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        }

        // Function to update variant
        function updateVariant(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const newVariant = e.target.value;
            const itemIndex = cart.findIndex(item => item.id === productId);
            
            if (itemIndex !== -1) {
                cart[itemIndex].variant = newVariant;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        }

        // Function to toggle item selection
        function toggleItemSelection(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const itemIndex = cart.findIndex(item => item.id === productId);
            
            if (itemIndex !== -1) {
                cart[itemIndex].selected = e.target.checked;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        }

        // Function to toggle select all - FIXED
        function toggleSelectAll() {
            const allSelected = cart.every(item => item.selected);
            const newState = !allSelected;
            
            cart.forEach(item => {
                item.selected = newState;
            });
            
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }

        // Function to remove item from cart
        function removeItem(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }

        // Function to handle checkout
        function checkout() {
            const selectedItems = cart.filter(item => item.selected);
            
            if (selectedItems.length === 0) {
                alert('Please select at least one item to checkout.');
                return;
            }
            
            const itemNames = selectedItems.map(item => {
                const product = products.find(p => p.id === item.id);
                return `${product.name} (${item.variant}) - ${item.quantity}x`;
            }).join('\n');
            
            alert(`Thank you for your order!\n\nOrder Number: ${orderNumber}\n\nItems:\n${itemNames}\n\nTotal: $${calculateTotal()}\n\nYou will be redirected to the checkout page.`);
            // In a real application, you would redirect to a checkout page
        }

        // Function to calculate total
        function calculateTotal() {
            let total = 0;
            cart.forEach(item => {
                if (item.selected) {
                    const product = products.find(p => p.id === item.id);
                    total += product.price * item.quantity;
                }
            });
            return total.toFixed(2);
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderCart();
        });
    </script>
</body>
</html>
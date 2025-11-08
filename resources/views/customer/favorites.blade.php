<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - Pawsitive Vibes</title>
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

        /* Search Bar Styles - Compact */
        .search-container {
            max-width: 1200px;
            margin: 0 auto 20px;
            padding: 0 20px;
        }

        .search-bar {
            display: flex;
            background: white;
            border-radius: 40px;
            padding: 6px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .search-bar:focus-within {
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 10px 18px;
            border-radius: 40px;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            outline: none;
            color: var(--dark-gray);
        }

        .search-input::placeholder {
            color: var(--text-gray);
        }

        .search-btn {
            background: var(--primary-violet);
            color: white;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .search-btn:hover {
            background: var(--dark-violet);
            transform: scale(1.05);
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

        /* Empty State Styles */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-gray);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--light-violet);
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            background: var(--primary-violet);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary:hover {
            background: var(--dark-violet);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.3);
        }

        /* Favorites Counter */
        .favorites-counter {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1rem;
            color: var(--text-gray);
        }

        .favorites-counter span {
            color: var(--primary-violet);
            font-weight: 700;
        }

        /* Products Grid - Compact */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .product-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }

        .product-image {
            width: 100%;
            height: 160px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-violet);
            font-size: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.03), rgba(249, 223, 113, 0.05));
        }

        .product-info {
            padding: 16px;
        }

        .product-name {
            font-size: 1.1rem;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-violet);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .product-price::before {
            content: '';
            width: 5px;
            height: 5px;
            background: var(--yellow);
            border-radius: 50%;
            margin-right: 6px;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
        }

        .action-btn {
            background: #f8f9fa;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-gray);
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(249, 223, 113, 0.1);
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .favorite-btn:hover {
            background: #ff4757;
            color: white;
        }

        .favorite-btn:hover::before {
            transform: scale(1);
        }

        .cart-btn:hover {
            background: var(--primary-violet);
            color: white;
        }

        .cart-btn:hover::before {
            transform: scale(1);
        }

        .favorite-btn.active {
            background: #ff4757;
            color: white;
        }

        .cart-btn.active {
            background: var(--primary-violet);
            color: white;
        }

        /* Section Title - Compact */
        .section-title {
            font-size: 1.6rem;
            margin: 40px 0 20px;
            color: var(--dark-gray);
            font-weight: 600;
            text-align: center;
            font-family: 'Quicksand', sans-serif;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 35px;
            height: 3px;
            background: var(--yellow);
            border-radius: 2px;
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

        /* New subtle yellow accents */
        .highlight-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--yellow);
            color: var(--dark-gray);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-card:nth-child(2n) .product-image::before {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.03), rgba(249, 223, 113, 0.08));
        }

        .nav-logo::after {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            background: var(--yellow);
            border-radius: 50%;
            margin-left: 6px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
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
            
            /* Removed Yellow Periods */
            .nav-links a.active::after {
                display: none;
            }
            
            .footer-links li:not(:last-child)::after {
                display: none;
            }
            
            /* Smaller Footer for Mobile */
            .footer {
                padding: 20px 15px 15px;
                margin-top: 40px;
            }
            
            .footer-logo {
                font-size: 1.3rem;
                margin-bottom: 10px;
            }
            
            .footer-links {
                margin: 15px 0;
                flex-wrap: wrap;
            }
            
            .footer-links a {
                font-size: 0.8rem;
            }
            
            .copyright {
                font-size: 0.7rem;
                margin-top: 15px;
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

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }

            .footer-links {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .footer-links li {
                margin: 5px 10px;
            }

            .empty-state {
                padding: 40px 20px;
            }

            .empty-state i {
                font-size: 3rem;
            }

            .empty-state h3 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .page-title {
                font-size: 1.6rem;
            }
            
            .section-title {
                font-size: 1.4rem;
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
            <li><a href="home.html"><i class="fas fa-home"></i> <span>Home</span></a></li>
            <li><a href="favorites.html" class="active"><i class="fas fa-heart"></i> <span>Favorites</span></a></li>
            <li><a href="donation.html"><i class="fas fa-hand-holding-usd"></i> <span>Donate</span></a></li>
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i> <span>Cart</span></a></li>
            <li><a href="profile.html"><i class="fas fa-user"></i> <span>Profile</span></a></li>
        </ul>
        
        <button class="nav-hamburger" id="navHamburger">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Search your favorite products..." id="searchInput">
            <button class="search-btn" id="searchBtn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Your Favorites</h1>
        <p class="page-subtitle">All your loved pet products in one place. Easy to find, easy to shop!</p>
        
        <!-- Favorites Counter -->
        <div class="favorites-counter" id="favoritesCounter">
            You have <span id="favoritesCount">0</span> favorite products
        </div>

        <!-- Favorites Products Grid -->
        <div id="favoritesContent">
            <!-- Content will be dynamically added here -->
        </div>
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
        <a href="home.html" class="mobile-nav-item">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="favorites.html" class="mobile-nav-item active">
            <i class="fas fa-heart"></i>
            <span>Favorites</span>
        </a>
        <a href="donation.html" class="mobile-nav-item">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Donate</span>
        </a>
        <a href="cart.html" class="mobile-nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="profile.html" class="mobile-nav-item">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </div>

    <script>
        // Sample product data for Pawsitive Vibes
        const products = [
            { id: 1, name: "Premium Dog Food", price: 34.99, icon: "fas fa-bone", badge: "Popular", category: "Dog Food", description: "Nutritionally balanced food for all dog breeds with natural ingredients." },
            { id: 2, name: "Cat Scratching Post", price: 42.99, icon: "fas fa-cat", category: "Cat Food", description: "Durable scratching post to keep your cat's claws healthy and your furniture safe." },
            { id: 3, name: "Pet Carrier", price: 59.99, icon: "fas fa-suitcase", badge: "New", category: "Accessories", description: "Comfortable and secure carrier for safe pet transportation." },
            { id: 4, name: "Interactive Toy", price: 18.99, icon: "fas fa-gamepad", category: "Toys", description: "Engaging toy that stimulates your pet's mind and keeps them active." },
            { id: 5, name: "Comfy Pet Bed", price: 49.99, icon: "fas fa-bed", badge: "Sale", category: "Beds", description: "Orthopedic pet bed with memory foam for ultimate comfort." },
            { id: 6, name: "Automatic Feeder", price: 64.99, icon: "fas fa-utensils", category: "Accessories", description: "Programmable automatic feeder for consistent feeding schedules." },
            { id: 7, name: "Pet GPS Tracker", price: 89.99, icon: "fas fa-map-marker-alt", badge: "Popular", category: "Accessories", description: "Real-time GPS tracking for your pet's safety and your peace of mind." },
            { id: 8, name: "Organic Cat Treats", price: 12.99, icon: "fas fa-cookie", category: "Treats", description: "All-natural, grain-free treats that cats love." },
            { id: 9, name: "Dog Training Leash", price: 24.99, icon: "fas fa-dog", category: "Accessories", description: "Durable training leash with comfortable handle." },
            { id: 10, name: "Pet First Aid Kit", price: 32.99, icon: "fas fa-first-aid", category: "Health Care", description: "Comprehensive first aid kit for pet emergencies." },
            { id: 11, name: "Water Fountain", price: 39.99, icon: "fas fa-tint", category: "Accessories", description: "Continuous fresh water circulation to encourage hydration." },
            { id: 12, name: "Litter Box", price: 32.99, icon: "fas fa-box", category: "Cat Food", description: "Odor-control litter box with privacy hood." }
        ];

        // Initialize favorites and cart from localStorage
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Function to render favorites
        function renderFavorites() {
            const favoritesContent = document.getElementById('favoritesContent');
            const favoritesCount = document.getElementById('favoritesCount');
            
            // Update favorites count
            favoritesCount.textContent = favorites.length;
            
            if (favorites.length === 0) {
                // Show empty state
                favoritesContent.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-heart"></i>
                        <h3>No favorites yet</h3>
                        <p>Start exploring our products and add your favorites to see them here!</p>
                        <a href="index.html" class="btn-primary">
                            <i class="fas fa-shopping-bag"></i> Start Shopping
                        </a>
                    </div>
                `;
                return;
            }

            // Get favorited products
            const favoriteProducts = products.filter(product => favorites.includes(product.id));
            
            // Create products grid
            favoritesContent.innerHTML = `
                <div class="products-grid" id="favoritesGrid">
                    <!-- Favorite products will be dynamically added here -->
                </div>
            `;
            
            const favoritesGrid = document.getElementById('favoritesGrid');
            
            favoriteProducts.forEach(product => {
                const isFavorite = favorites.includes(product.id);
                const inCart = cart.includes(product.id);

                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    ${product.badge ? `<div class="highlight-badge">${product.badge}</div>` : ''}
                    <div class="product-image">
                        <i class="${product.icon}"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <div class="product-price">$${product.price.toFixed(2)}</div>
                        <div class="product-actions">
                            <button class="action-btn favorite-btn active" data-id="${product.id}">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button class="action-btn cart-btn ${inCart ? 'active' : ''}" data-id="${product.id}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                `;
                favoritesGrid.appendChild(productCard);
            });

            // Add event listeners to buttons
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', removeFromFavorites);
            });

            document.querySelectorAll('.cart-btn').forEach(btn => {
                btn.addEventListener('click', toggleCart);
            });
        }

        // Remove from favorites
        function removeFromFavorites(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const index = favorites.indexOf(productId);
            
            if (index !== -1) {
                favorites.splice(index, 1);
                localStorage.setItem('favorites', JSON.stringify(favorites));
                
                // Re-render favorites
                renderFavorites();
            }
            
            // Reset the button size after click
            e.currentTarget.style.transform = 'scale(1)';
        }

        // Toggle cart status
        function toggleCart(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const index = cart.indexOf(productId);
            
            if (index === -1) {
                cart.push(productId);
                e.currentTarget.classList.add('active');
            } else {
                cart.splice(index, 1);
                e.currentTarget.classList.remove('active');
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Reset the button size after click
            e.currentTarget.style.transform = 'scale(1)';
        }

        // Search functionality for favorites
        function handleSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            if (searchTerm === '') {
                renderFavorites();
                return;
            }

            const favoriteProducts = products.filter(product => 
                favorites.includes(product.id) && (
                    product.name.toLowerCase().includes(searchTerm) || 
                    product.category.toLowerCase().includes(searchTerm) ||
                    product.description.toLowerCase().includes(searchTerm)
                )
            );

            const favoritesContent = document.getElementById('favoritesContent');
            
            if (favoriteProducts.length > 0) {
                favoritesContent.innerHTML = `
                    <div class="favorites-counter">
                        Found <span>${favoriteProducts.length}</span> favorite products matching "${searchTerm}"
                    </div>
                    <div class="products-grid" id="favoritesGrid">
                        <!-- Search results will be dynamically added here -->
                    </div>
                `;
                
                const favoritesGrid = document.getElementById('favoritesGrid');
                
                favoriteProducts.forEach(product => {
                    const inCart = cart.includes(product.id);

                    const productCard = document.createElement('div');
                    productCard.className = 'product-card';
                    productCard.innerHTML = `
                        ${product.badge ? `<div class="highlight-badge">${product.badge}</div>` : ''}
                        <div class="product-image">
                            <i class="${product.icon}"></i>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">${product.name}</h3>
                            <div class="product-price">$${product.price.toFixed(2)}</div>
                            <div class="product-actions">
                                <button class="action-btn favorite-btn active" data-id="${product.id}">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="action-btn cart-btn ${inCart ? 'active' : ''}" data-id="${product.id}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    favoritesGrid.appendChild(productCard);
                });

                // Add event listeners to buttons
                document.querySelectorAll('.favorite-btn').forEach(btn => {
                    btn.addEventListener('click', removeFromFavorites);
                });

                document.querySelectorAll('.cart-btn').forEach(btn => {
                    btn.addEventListener('click', toggleCart);
                });
            } else {
                favoritesContent.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h3>No favorites found</h3>
                        <p>No favorite products match your search for "${searchTerm}"</p>
                        <button class="btn-primary" onclick="document.getElementById('searchInput').value = ''; renderFavorites();">
                            <i class="fas fa-times"></i> Clear Search
                        </button>
                    </div>
                `;
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderFavorites();

            // Search event listeners
            document.getElementById('searchBtn').addEventListener('click', handleSearch);
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    handleSearch();
                }
            });
        });
    </script>
</body>
</html>
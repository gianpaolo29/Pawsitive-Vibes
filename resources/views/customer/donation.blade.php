<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate - Pawsitive Vibes</title>
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

        /* Donation Options */
        .donation-options {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .donation-option {
            flex: 1;
            min-width: 280px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .donation-option:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }

        .donation-option.active {
            border-color: var(--primary-violet);
            background: rgba(138, 43, 226, 0.03);
        }

        .donation-icon {
            font-size: 2.5rem;
            color: var(--primary-violet);
            margin-bottom: 12px;
        }

        .donation-option h3 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .donation-option p {
            color: var(--text-gray);
            font-size: 0.85rem;
        }

        /* Donation Forms */
        .donation-form {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
            display: none;
        }

        .donation-form.active {
            display: block;
        }

        .form-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-violet);
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.1);
        }

        .form-row {
            display: flex;
            gap: 12px;
        }

        .form-row .form-group {
            flex: 1;
        }

        /* Product Browser Popup */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
        }

        .popup-overlay.active {
            display: flex;
        }

        .product-browser-popup {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
            position: sticky;
            top: 0;
            background: white;
            border-radius: 12px 12px 0 0;
        }

        .popup-title {
            font-size: 1.3rem;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .close-popup {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--text-gray);
            cursor: pointer;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .close-popup:hover {
            color: var(--primary-violet);
            transform: rotate(90deg);
        }

        .popup-content {
            padding: 20px;
        }

        /* Products Grid - More Compact */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }

        .product-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }

        .product-card.selected {
            border-color: var(--primary-violet);
            box-shadow: 0 3px 10px rgba(138, 43, 226, 0.2);
        }

        .product-image {
            width: 100%;
            height: 90px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-violet);
            font-size: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .product-info {
            padding: 10px;
        }

        .product-name {
            font-size: 0.8rem;
            margin-bottom: 4px;
            font-weight: 600;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
            line-height: 1.2;
        }

        .product-price {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-violet);
            display: flex;
            align-items: center;
        }

        .product-price::before {
            content: '';
            width: 4px;
            height: 4px;
            background: var(--yellow);
            border-radius: 50%;
            margin-right: 4px;
        }

        /* Selected Products Display */
        .selected-products {
            background: var(--light-yellow);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .selected-products.active {
            display: block;
        }

        .selected-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .selected-title {
            font-size: 1.1rem;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .selected-summary {
            display: flex;
            gap: 15px;
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 12px;
        }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .summary-item i {
            color: var(--primary-violet);
        }

        .selected-items {
            max-height: 200px;
            overflow-y: auto;
        }

        .selected-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .selected-item:last-child {
            border-bottom: none;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item-icon {
            color: var(--primary-violet);
            font-size: 1rem;
        }

        .item-name {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .item-price {
            font-size: 0.85rem;
            color: var(--primary-violet);
            font-weight: 600;
        }

        .remove-item {
            background: none;
            border: none;
            color: #ff4757;
            cursor: pointer;
            padding: 4px;
            font-size: 0.8rem;
        }

        /* File Upload */
        .file-upload {
            border: 2px dashed var(--medium-gray);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload:hover {
            border-color: var(--primary-violet);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--primary-violet);
            margin-bottom: 10px;
        }

        .file-upload p {
            color: var(--text-gray);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .file-upload small {
            color: var(--text-gray);
            opacity: 0.7;
            font-size: 0.8rem;
        }

        .file-input {
            display: none;
        }

        .file-preview {
            margin-top: 12px;
            display: none;
        }

        .file-preview img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
        }

        .file-info {
            margin-top: 8px;
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        .remove-file {
            color: #ff4757;
            cursor: pointer;
            margin-left: 8px;
            font-size: 0.8rem;
        }

        /* GCash Info */
        .gcash-info {
            background: linear-gradient(135deg, #0c7c3f, #00a64f);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 18px;
        }

        .gcash-info h4 {
            font-size: 1.1rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gcash-details {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .gcash-detail {
            flex: 1;
            min-width: 180px;
        }

        .gcash-detail strong {
            display: block;
            margin-bottom: 4px;
            font-size: 1rem;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-primary {
            background: var(--primary-violet);
            color: white;
        }

        .btn-primary:hover {
            background: var(--dark-violet);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.3);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--dark-gray);
        }

        .btn-secondary:hover {
            background: var(--medium-gray);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-violet);
            color: var(--primary-violet);
        }

        .btn-outline:hover {
            background: var(--primary-violet);
            color: white;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        /* Success Message */
        .success-message {
            text-align: center;
            padding: 30px 20px;
            display: none;
        }

        .success-message i {
            font-size: 3rem;
            color: #00a64f;
            margin-bottom: 15px;
        }

        .success-message h3 {
            font-size: 1.5rem;
            margin-bottom: 12px;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .success-message p {
            color: var(--text-gray);
            margin-bottom: 25px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.9rem;
        }

        /* Updated Footer with #8259E2 background - Compact */
        .footer {
            background: #8259E2;
            padding: 30px 20px 15px;
            margin-top: 50px;
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
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
            font-family: 'Quicksand', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer-logo-img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            list-style: none;
            margin: 18px 0;
        }

        .footer-links li {
            margin: 0 12px;
            position: relative;
        }

        .footer-links li:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -12px;
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
            font-size: 0.85rem;
        }

        .footer-links a:hover {
            color: var(--yellow);
            transform: translateY(-2px);
        }

        .copyright {
            margin-top: 18px;
            font-size: 0.75rem;
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
            
            /* Horizontal Donation Options for Mobile */
            .donation-options {
                flex-direction: row;
                flex-wrap: nowrap;
                overflow-x: auto;
                gap: 12px;
                padding-bottom: 10px;
                margin-bottom: 25px;
                -webkit-overflow-scrolling: touch;
            }
            
            .donation-option {
                flex: 0 0 auto;
                min-width: 200px;
                padding: 15px;
            }
            
            .donation-icon {
                font-size: 2rem;
                margin-bottom: 8px;
            }
            
            .donation-option h3 {
                font-size: 1rem;
                margin-bottom: 6px;
            }
            
            .donation-option p {
                font-size: 0.8rem;
                line-height: 1.3;
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
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .gcash-details {
                flex-direction: column;
                gap: 8px;
            }

            .footer-links {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .footer-links li {
                margin: 5px 10px;
            }

            .selected-summary {
                flex-direction: column;
                gap: 8px;
            }

            .popup-overlay {
                padding: 10px;
            }

            .product-browser-popup {
                max-height: 90vh;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .page-title {
                font-size: 1.6rem;
            }
            
            .footer-links {
                flex-direction: column;
            }
            
            .footer-links li {
                margin: 3px 0;
            }
            
            /* Even more compact donation options for very small screens */
            .donation-option {
                min-width: 170px;
                padding: 12px;
            }
            
            .donation-icon {
                font-size: 1.8rem;
            }
            
            .donation-option h3 {
                font-size: 0.9rem;
            }
            
            .donation-option p {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 360px) {
            /* Extra small screen adjustments */
            .donation-option {
                min-width: 150px;
                padding: 10px;
            }
            
            .donation-icon {
                font-size: 1.6rem;
            }
            
            .donation-option h3 {
                font-size: 0.85rem;
            }
            
            .donation-option p {
                font-size: 0.7rem;
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
            <li><a href="favorites.html"><i class="fas fa-heart"></i> <span>Favorites</span></a></li>
            <li><a href="donations.html" class="active"><i class="fas fa-hand-holding-usd"></i> <span>Donate</span></a></li>
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i> <span>Cart</span></a></li>
            <li><a href="profile.html"><i class="fas fa-user"></i> <span>Profile</span></a></li>
        </ul>
        
        <button class="nav-hamburger" id="navHamburger">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Support Animal Welfare</h1>
        <p class="page-subtitle">Your donation helps provide care and shelter for abandoned and rescued animals. Choose how you'd like to contribute.</p>
        
        <!-- Donation Options -->
        <div class="donation-options">
            <div class="donation-option active" data-option="product">
                <div class="donation-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3>Donate Products</h3>
                <p>Select products from our store to donate to animal shelters</p>
            </div>
            <div class="donation-option" data-option="cash">
                <div class="donation-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3>Cash Donation</h3>
                <p>Make a monetary donation via GCash for maximum flexibility</p>
            </div>
        </div>

        <!-- Product Donation Form -->
        <div class="donation-form active" id="productForm">
            <h3 class="form-title">Donate Products to Animal Shelters</h3>
            
            <button class="btn btn-outline btn-block" id="browseProductsBtn">
                <i class="fas fa-search"></i> Browse Products to Donate
            </button>

            <!-- Selected Products Display -->
            <div class="selected-products" id="selectedProducts">
                <div class="selected-header">
                    <h4 class="selected-title">Selected Donation Items</h4>
                </div>
                <div class="selected-summary">
                    <div class="summary-item">
                        <i class="fas fa-cube"></i>
                        <span id="totalQuantity">0 items</span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-dollar-sign"></i>
                        <span id="totalPrice">$0.00</span>
                    </div>
                </div>
                <div class="selected-items" id="selectedItemsList">
                    <!-- Selected items will be displayed here -->
                </div>
            </div>

            <div class="form-group">
                <label for="donorName">Your Name *</label>
                <input type="text" id="donorName" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="donorEmail">Email Address *</label>
                <input type="email" id="donorEmail" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="donorPhone">Phone Number *</label>
                <input type="tel" id="donorPhone" class="form-control" placeholder="Enter your phone number" required>
            </div>

            <div class="form-group">
                <label>Upload Payment Receipt *</label>
                <div class="file-upload" id="paymentReceiptUpload">
                    <i class="fas fa-receipt"></i>
                    <p>Click to upload your payment receipt</p>
                    <small>Supported formats: JPG, PNG, PDF (Max 5MB)</small>
                    <input type="file" class="file-input" id="paymentReceiptFile" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="file-preview" id="paymentReceiptPreview">
                    <img id="paymentPreviewImage" src="" alt="Receipt preview">
                    <div class="file-info">
                        <span id="paymentFileName"></span>
                        <span class="remove-file" id="removePaymentFile"><i class="fas fa-times"></i> Remove</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="donorMessage">Message to Shelter (Optional)</label>
                <textarea id="donorMessage" class="form-control" rows="3" placeholder="Add a personal message to the shelter..."></textarea>
            </div>

            <button class="btn btn-primary btn-block" id="submitProductDonation">
                <i class="fas fa-paw"></i> Complete Product Donation
            </button>
        </div>

        <!-- Cash Donation Form -->
        <div class="donation-form" id="cashForm">
            <h3 class="form-title">Make a Cash Donation via GCash</h3>
            
            <div class="gcash-info">
                <h4><i class="fas fa-mobile-alt"></i> GCash Donation</h4>
                <div class="gcash-details">
                    <div class="gcash-detail">
                        <strong>GCash Number</strong>
                        <span>0917 123 4567</span>
                    </div>
                    <div class="gcash-detail">
                        <strong>Account Name</strong>
                        <span>Pawsitive Vibes Foundation</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="donationAmount">Donation Amount (PHP) *</label>
                <input type="number" id="donationAmount" class="form-control" placeholder="Enter amount" min="1" required>
            </div>

            <div class="form-group">
                <label for="cashDonorName">Your Name *</label>
                <input type="text" id="cashDonorName" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="cashDonorEmail">Email Address *</label>
                <input type="email" id="cashDonorEmail" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="cashDonorPhone">Phone Number *</label>
                <input type="tel" id="cashDonorPhone" class="form-control" placeholder="Enter your phone number" required>
            </div>

            <div class="form-group">
                <label>Upload GCash Receipt *</label>
                <div class="file-upload" id="receiptUpload">
                    <i class="fas fa-receipt"></i>
                    <p>Click to upload your GCash receipt</p>
                    <small>Supported formats: JPG, PNG, PDF (Max 5MB)</small>
                    <input type="file" class="file-input" id="receiptFile" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="file-preview" id="filePreview">
                    <img id="previewImage" src="" alt="Receipt preview">
                    <div class="file-info">
                        <span id="fileName"></span>
                        <span class="remove-file" id="removeFile"><i class="fas fa-times"></i> Remove</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="cashDonorMessage">Message (Optional)</label>
                <textarea id="cashDonorMessage" class="form-control" rows="3" placeholder="Add a message..."></textarea>
            </div>

            <button class="btn btn-primary btn-block" id="submitCashDonation">
                <i class="fas fa-heart"></i> Submit Cash Donation
            </button>
        </div>

        <!-- Success Message -->
        <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i>
            <h3>Thank You for Your Donation!</h3>
            <p>Your generous contribution will make a difference in the lives of animals in need. We've sent a confirmation email with details about your donation.</p>
            <button class="btn btn-secondary" id="newDonation">
                <i class="fas fa-plus"></i> Make Another Donation
            </button>
        </div>
    </div>

    <!-- Product Browser Popup -->
    <div class="popup-overlay" id="productBrowserPopup">
        <div class="product-browser-popup">
            <div class="popup-header">
                <h3 class="popup-title">Select Products to Donate</h3>
                <button class="close-popup" id="closeProductBrowser">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="popup-content">
                <div class="products-grid" id="donationProductsGrid">
                    <!-- Products will be dynamically added here -->
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px;">
                    <button class="btn btn-secondary" id="cancelSelection">
                        Cancel
                    </button>
                    <button class="btn btn-primary" id="confirmSelection">
                        Add Selected Items
                    </button>
                </div>
            </div>
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
        <a href="favorites.html" class="mobile-nav-item">
            <i class="fas fa-heart"></i>
            <span>Favorites</span>
        </a>
        <a href="donation.html" class="mobile-nav-item active">
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
        // Sample product data for donations
        const donationProducts = [
            { id: 1, name: "Premium Dog Food", price: 34.99, icon: "fas fa-bone", category: "Dog Food" },
            { id: 2, name: "Cat Food", price: 28.99, icon: "fas fa-fish", category: "Cat Food" },
            { id: 3, name: "Pet Carrier", price: 59.99, icon: "fas fa-suitcase", category: "Accessories" },
            { id: 4, name: "Interactive Toy", price: 18.99, icon: "fas fa-gamepad", category: "Toys" },
            { id: 5, name: "Comfy Pet Bed", price: 49.99, icon: "fas fa-bed", category: "Beds" },
            { id: 6, name: "Pet First Aid Kit", price: 32.99, icon: "fas fa-first-aid", category: "Health Care" },
            { id: 7, name: "Pet GPS Tracker", price: 89.99, icon: "fas fa-map-marker-alt", category: "Accessories" },
            { id: 8, name: "Organic Treats", price: 12.99, icon: "fas fa-cookie", category: "Treats" },
            { id: 9, name: "Dog Leash", price: 15.99, icon: "fas fa-dog", category: "Accessories" },
            { id: 10, name: "Cat Litter", price: 22.99, icon: "fas fa-cat", category: "Cat Food" },
            { id: 11, name: "Pet Bowl Set", price: 19.99, icon: "fas fa-utensils", category: "Accessories" },
            { id: 12, name: "Grooming Brush", price: 14.99, icon: "fas fa-bath", category: "Health Care" }
        ];

        let selectedProducts = [];
        let tempSelectedProducts = [];
        let uploadedFile = null;
        let paymentReceiptFile = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderDonationProducts();
            setupEventListeners();
            updateSelectedProductsDisplay();
        });

        // Render donation products
        function renderDonationProducts() {
            const productsGrid = document.getElementById('donationProductsGrid');
            productsGrid.innerHTML = '';

            donationProducts.forEach(product => {
                const isSelected = tempSelectedProducts.includes(product.id);
                
                const productCard = document.createElement('div');
                productCard.className = `product-card ${isSelected ? 'selected' : ''}`;
                productCard.setAttribute('data-id', product.id);
                productCard.innerHTML = `
                    <div class="product-image">
                        <i class="${product.icon}"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <div class="product-price">$${product.price.toFixed(2)}</div>
                    </div>
                `;
                productsGrid.appendChild(productCard);
            });

            // Add event listeners to product cards
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', toggleTempProductSelection);
            });
        }

        // Toggle temporary product selection (in browser panel)
        function toggleTempProductSelection(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const index = tempSelectedProducts.indexOf(productId);
            
            if (index === -1) {
                tempSelectedProducts.push(productId);
                e.currentTarget.classList.add('selected');
            } else {
                tempSelectedProducts.splice(index, 1);
                e.currentTarget.classList.remove('selected');
            }
        }

        // Update selected products display
        function updateSelectedProductsDisplay() {
            const selectedProductsContainer = document.getElementById('selectedProducts');
            const selectedItemsList = document.getElementById('selectedItemsList');
            const totalQuantity = document.getElementById('totalQuantity');
            const totalPrice = document.getElementById('totalPrice');
            
            // Show/hide selected products container
            if (selectedProducts.length > 0) {
                selectedProductsContainer.classList.add('active');
            } else {
                selectedProductsContainer.classList.remove('active');
            }
            
            // Update summary
            totalQuantity.textContent = `${selectedProducts.length} item${selectedProducts.length !== 1 ? 's' : ''}`;
            
            const total = selectedProducts.reduce((sum, productId) => {
                const product = donationProducts.find(p => p.id === productId);
                return sum + (product ? product.price : 0);
            }, 0);
            
            totalPrice.textContent = `$${total.toFixed(2)}`;
            
            // Update selected items list
            selectedItemsList.innerHTML = '';
            
            selectedProducts.forEach(productId => {
                const product = donationProducts.find(p => p.id === productId);
                if (product) {
                    const selectedItem = document.createElement('div');
                    selectedItem.className = 'selected-item';
                    selectedItem.innerHTML = `
                        <div class="item-info">
                            <i class="${product.icon} item-icon"></i>
                            <span class="item-name">${product.name}</span>
                        </div>
                        <div class="item-actions">
                            <span class="item-price">$${product.price.toFixed(2)}</span>
                            <button class="remove-item" data-id="${product.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    selectedItemsList.appendChild(selectedItem);
                }
            });
            
            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    removeFromSelectedProducts(productId);
                });
            });
        }

        // Remove product from selected products
        function removeFromSelectedProducts(productId) {
            const index = selectedProducts.indexOf(productId);
            if (index !== -1) {
                selectedProducts.splice(index, 1);
                updateSelectedProductsDisplay();
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Donation option selection
            document.querySelectorAll('.donation-option').forEach(option => {
                option.addEventListener('click', function() {
                    const selectedOption = this.getAttribute('data-option');
                    
                    // Update active states
                    document.querySelectorAll('.donation-option').forEach(opt => {
                        opt.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Show corresponding form
                    document.querySelectorAll('.donation-form').forEach(form => {
                        form.classList.remove('active');
                    });
                    document.getElementById(selectedOption + 'Form').classList.add('active');
                });
            });

            // Product browser popup
            document.getElementById('browseProductsBtn').addEventListener('click', function() {
                // Copy current selection to temporary selection
                tempSelectedProducts = [...selectedProducts];
                renderDonationProducts();
                document.getElementById('productBrowserPopup').classList.add('active');
            });

            document.getElementById('closeProductBrowser').addEventListener('click', closeProductBrowser);
            document.getElementById('cancelSelection').addEventListener('click', closeProductBrowser);

            document.getElementById('confirmSelection').addEventListener('click', function() {
                selectedProducts = [...tempSelectedProducts];
                updateSelectedProductsDisplay();
                closeProductBrowser();
            });

            // Close popup when clicking outside
            document.getElementById('productBrowserPopup').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeProductBrowser();
                }
            });

            // File upload handling
            document.getElementById('receiptUpload').addEventListener('click', function() {
                document.getElementById('receiptFile').click();
            });

            document.getElementById('receiptFile').addEventListener('change', handleFileUpload);
            document.getElementById('removeFile').addEventListener('click', removeUploadedFile);

            document.getElementById('paymentReceiptUpload').addEventListener('click', function() {
                document.getElementById('paymentReceiptFile').click();
            });

            document.getElementById('paymentReceiptFile').addEventListener('change', handlePaymentReceiptUpload);
            document.getElementById('removePaymentFile').addEventListener('click', removePaymentReceiptFile);

            // Form submissions
            document.getElementById('submitProductDonation').addEventListener('click', submitProductDonation);
            document.getElementById('submitCashDonation').addEventListener('click', submitCashDonation);
            document.getElementById('newDonation').addEventListener('click', resetToCashDonation);
        }

        // Close product browser popup
        function closeProductBrowser() {
            document.getElementById('productBrowserPopup').classList.remove('active');
        }

        // Handle file upload for cash donation
        function handleFileUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Check file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }

            // Check file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a JPG, PNG, or PDF file');
                return;
            }

            uploadedFile = file;

            // Show preview
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const previewImage = document.getElementById('previewImage');

            fileName.textContent = file.name;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = 'none';
            }

            filePreview.style.display = 'block';
        }

        // Handle payment receipt upload for product donation
        function handlePaymentReceiptUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Check file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }

            // Check file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a JPG, PNG, or PDF file');
                return;
            }

            paymentReceiptFile = file;

            // Show preview
            const filePreview = document.getElementById('paymentReceiptPreview');
            const fileName = document.getElementById('paymentFileName');
            const previewImage = document.getElementById('paymentPreviewImage');

            fileName.textContent = file.name;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = 'none';
            }

            filePreview.style.display = 'block';
        }

        // Remove uploaded file for cash donation
        function removeUploadedFile() {
            uploadedFile = null;
            document.getElementById('receiptFile').value = '';
            document.getElementById('filePreview').style.display = 'none';
        }

        // Remove payment receipt file for product donation
        function removePaymentReceiptFile() {
            paymentReceiptFile = null;
            document.getElementById('paymentReceiptFile').value = '';
            document.getElementById('paymentReceiptPreview').style.display = 'none';
        }

        // Submit product donation
        function submitProductDonation() {
            const donorName = document.getElementById('donorName').value;
            const donorEmail = document.getElementById('donorEmail').value;
            const donorPhone = document.getElementById('donorPhone').value;

            if (!donorName || !donorEmail || !donorPhone) {
                alert('Please fill in all required fields');
                return;
            }

            if (selectedProducts.length === 0) {
                alert('Please select at least one product to donate');
                return;
            }

            if (!paymentReceiptFile) {
                alert('Please upload your payment receipt');
                return;
            }

            // Calculate total
            const total = selectedProducts.reduce((sum, productId) => {
                const product = donationProducts.find(p => p.id === productId);
                return sum + (product ? product.price : 0);
            }, 0);

            // In a real application, you would send this data to a server
            console.log('Product Donation Submitted:', {
                donorName,
                donorEmail,
                donorPhone,
                selectedProducts,
                totalAmount: total,
                paymentReceipt: paymentReceiptFile,
                message: document.getElementById('donorMessage').value
            });

            showSuccessMessage();
        }

        // Submit cash donation
        function submitCashDonation() {
            const donorName = document.getElementById('cashDonorName').value;
            const donorEmail = document.getElementById('cashDonorEmail').value;
            const donorPhone = document.getElementById('cashDonorPhone').value;
            const donationAmount = document.getElementById('donationAmount').value;

            if (!donorName || !donorEmail || !donorPhone || !donationAmount) {
                alert('Please fill in all required fields');
                return;
            }

            if (!uploadedFile) {
                alert('Please upload your GCash receipt');
                return;
            }

            // In a real application, you would send this data to a server
            console.log('Cash Donation Submitted:', {
                donorName,
                donorEmail,
                donorPhone,
                donationAmount,
                receipt: uploadedFile,
                message: document.getElementById('cashDonorMessage').value
            });

            showSuccessMessage();
        }

        // Show success message
        function showSuccessMessage() {
            document.querySelectorAll('.donation-form').forEach(form => {
                form.style.display = 'none';
            });
            document.getElementById('successMessage').style.display = 'block';
        }

        // Reset to cash donation form only
        function resetToCashDonation() {
            // Hide success message
            document.getElementById('successMessage').style.display = 'none';
            
            // Show donation forms
            document.querySelectorAll('.donation-form').forEach(form => {
                form.style.display = 'block';
            });
            
            // Reset to cash donation form only
            document.querySelectorAll('.donation-option').forEach(opt => {
                opt.classList.remove('active');
            });
            document.querySelector('[data-option="cash"]').classList.add('active');
            
            document.querySelectorAll('.donation-form').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById('cashForm').classList.add('active');
            
            // Reset cash donation form
            document.getElementById('donationAmount').value = '';
            document.getElementById('cashDonorName').value = '';
            document.getElementById('cashDonorEmail').value = '';
            document.getElementById('cashDonorPhone').value = '';
            document.getElementById('cashDonorMessage').value = '';
            removeUploadedFile();
        }
    </script>
</body>
</html>
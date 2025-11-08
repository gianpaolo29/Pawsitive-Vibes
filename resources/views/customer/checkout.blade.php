<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsitive Vibes | Checkout</title>
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
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
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
            position: fixed;
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

        /* Main content wrapper */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 80px 20px 20px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Page Title */
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

        /* Checkout Layout */
        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        @media (max-width: 968px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }

        /* Order Summary Section */
        .order-summary {
            background: var(--soft-white);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 25px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .section-title {
            font-size: 1.4rem;
            margin-bottom: 20px;
            color: var(--dark-gray);
            font-weight: 600;
            font-family: 'Quicksand', sans-serif;
            position: relative;
            display: flex;
            align-items: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 35px;
            height: 3px;
            background: var(--yellow);
            border-radius: 2px;
        }

        .section-title i {
            margin-right: 10px;
            color: var(--primary-violet);
        }

        .order-id-container {
            background: var(--light-yellow);
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 25px;
            text-align: center;
            border-left: 4px solid var(--yellow);
        }

        .order-id-label {
            font-weight: 600;
            color: var(--text-gray);
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .order-id-value {
            font-weight: 800;
            color: var(--primary-violet);
            font-family: 'Quicksand', sans-serif;
            letter-spacing: 1.5px;
            font-size: 1.8rem;
        }

        .cart-items {
            margin-bottom: 25px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--medium-gray);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--light-violet), var(--vibrant-violet));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
            font-family: 'Quicksand', sans-serif;
            font-size: 1.1rem;
        }

        .item-option {
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .item-price {
            color: var(--primary-violet);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .order-total {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 16px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .total-row:last-child {
            margin-bottom: 0;
            border-top: 1px solid var(--medium-gray);
            padding-top: 10px;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-violet);
        }

        /* Payment Section */
        .payment-section {
            background: var(--soft-white);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 25px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .payment-method {
            margin-bottom: 25px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: var(--primary-violet);
        }

        .payment-option.active {
            border-color: var(--primary-violet);
            background: rgba(138, 43, 226, 0.05);
        }

        .payment-option input {
            margin-right: 10px;
            accent-color: var(--primary-violet);
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            background: var(--light-gray);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-violet);
            font-size: 1.2rem;
        }

        .payment-details {
            flex: 1;
        }

        .payment-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .payment-description {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        /* GCash QR Code */
        .gcash-qr {
            text-align: center;
            padding: 20px;
            background: var(--light-gray);
            border-radius: 16px;
            margin-bottom: 25px;
            display: none;
        }

        .gcash-qr.active {
            display: block;
        }

        .qr-code {
            width: 200px;
            height: 200px;
            background: white;
            margin: 0 auto 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--primary-violet);
            border: 1px solid var(--medium-gray);
        }

        .qr-instructions {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 15px;
        }

        /* Receipt Upload */
        .receipt-upload {
            margin-bottom: 25px;
            display: none;
        }

        .receipt-upload.active {
            display: block;
        }

        .upload-area {
            border: 2px dashed var(--medium-gray);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .upload-area:hover {
            border-color: var(--primary-violet);
            background: rgba(138, 43, 226, 0.03);
        }

        .upload-icon {
            font-size: 2.5rem;
            color: var(--primary-violet);
            margin-bottom: 15px;
        }

        .upload-text {
            margin-bottom: 10px;
            font-weight: 500;
        }

        .upload-hint {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .file-input {
            display: none;
        }

        .uploaded-file {
            display: flex;
            align-items: center;
            background: var(--light-gray);
            padding: 12px 15px;
            border-radius: 12px;
            margin-top: 15px;
            display: none;
        }

        .uploaded-file.active {
            display: flex;
        }

        .file-icon {
            color: var(--primary-violet);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .file-name {
            flex: 1;
            font-weight: 500;
        }

        .remove-file {
            color: var(--text-gray);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .remove-file:hover {
            color: #e74c3c;
        }

        /* Pickup Options */
        .pickup-options {
            margin-bottom: 25px;
        }

        .pickup-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pickup-option:hover {
            border-color: var(--primary-violet);
        }

        .pickup-option.active {
            border-color: var(--primary-violet);
            background: rgba(138, 43, 226, 0.05);
        }

        .pickup-option input {
            margin-right: 10px;
            accent-color: var(--primary-violet);
        }

        .pickup-icon {
            width: 40px;
            height: 40px;
            background: var(--light-gray);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-violet);
            font-size: 1.2rem;
        }

        .pickup-details {
            flex: 1;
        }

        .pickup-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .pickup-description {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        /* Schedule Pickup Section */
        .schedule-pickup {
            margin-top: 20px;
            padding: 20px;
            background: var(--light-gray);
            border-radius: 16px;
            display: none;
        }

        .schedule-pickup.active {
            display: block;
        }

        .date-time-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-gray);
        }

        /* Custom Date Input Styling */
        .date-input-wrapper {
            position: relative;
        }

        .date-input-wrapper::after {
            content: '\f073';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-violet);
            pointer-events: none;
        }

        .custom-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            font-size: 16px;
            background-color: var(--soft-white);
            transition: all 0.3s ease;
            outline: none;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .custom-input:focus {
            border-color: var(--primary-violet);
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.15);
        }

        /* Custom Select Styling */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-violet);
            pointer-events: none;
        }

        .custom-select {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            font-size: 16px;
            background-color: var(--soft-white);
            transition: all 0.3s ease;
            outline: none;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
        }

        .custom-select:focus {
            border-color: var(--primary-violet);
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.15);
        }

        /* Style the dropdown options */
        .custom-select option {
            padding: 10px;
            background: var(--soft-white);
            color: var(--dark-gray);
        }

        .custom-select option:hover {
            background: var(--primary-violet);
            color: white;
        }

        .date-note {
            font-size: 0.85rem;
            color: var(--text-gray);
            margin-top: 10px;
            font-style: italic;
        }

        /* Submit Button */
        .submit-order {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary-violet), var(--dark-violet));
            border: none;
            border-radius: 16px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.3);
            font-family: 'Poppins', sans-serif;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            -webkit-tap-highlight-color: transparent;
            margin-top: 10px;
        }

        .submit-order::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .submit-order:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(138, 43, 226, 0.4);
            background: linear-gradient(135deg, var(--dark-violet), var(--primary-violet));
        }

        .submit-order:hover::before {
            left: 100%;
        }

        .submit-order:active {
            transform: translateY(0);
        }

        /* Updated Footer with #8259E2 background - Compact */
        .footer {
            background: #8259E2;
            padding: 35px 20px 20px;
            text-align: center;
            color: white;
            position: relative;
            width: 100%;
            margin-top: auto;
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
            body {
                padding-bottom: 70px;
            }
            
            .main-content {
                padding: 80px 15px 15px;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .checkout-container {
                gap: 20px;
            }
            
            .order-summary, .payment-section {
                padding: 20px;
            }
            
            .date-time-inputs {
                grid-template-columns: 1fr;
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
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.6rem;
            }
            
            .section-title {
                font-size: 1.2rem;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .item-image {
                margin-bottom: 10px;
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
    </nav>
    
    <div class="main-content">
        <h1 class="page-title">Checkout</h1>
        <p class="page-subtitle">Review your order and complete your purchase</p>
        
        <div class="checkout-container">
            <!-- Order Summary Section -->
            <div class="order-summary">
                <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Order Summary</h2>
                
                <div class="order-id-container">
                    <div class="order-id-label">Order ID:</div>
                    <div class="order-id-value">PV-2023-5876</div>
                </div>
                
                <div class="cart-items">
                    <div class="cart-item">
                        <div class="item-image">
                            <i class="fas fa-bone"></i>
                        </div>
                        <div class="item-details">
                            <div class="item-name">Premium Dog Food</div>
                            <div class="item-option">Size: Large (15kg) • Flavor: Chicken & Rice</div>
                            <div class="item-price">₱34.99</div>
                        </div>
                    </div>
                    
                    <div class="cart-item">
                        <div class="item-image">
                            <i class="fas fa-cat"></i>
                        </div>
                        <div class="item-details">
                            <div class="item-name">Cat Scratching Post</div>
                            <div class="item-option">Color: Natural Sisal • Height: 32 inches</div>
                            <div class="item-price">₱42.99</div>
                        </div>
                    </div>
                    
                    <div class="cart-item">
                        <div class="item-image">
                            <i class="fas fa-paw"></i>
                        </div>
                        <div class="item-details">
                            <div class="item-name">Interactive Toy</div>
                            <div class="item-option">Type: Puzzle Feeder • For: Medium Dogs</div>
                            <div class="item-price">₱18.99</div>
                        </div>
                    </div>
                </div>
                
                <div class="order-total">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>₱96.97</span>
                    </div>
                    <div class="total-row">
                        <span>Total</span>
                        <span>₱96.97</span>
                    </div>
                </div>
            </div>
            
            <!-- Payment & Pickup Section -->
            <div class="payment-section">
                <h2 class="section-title"><i class="fas fa-credit-card"></i> Payment & Pickup</h2>
                
                <!-- Payment Method Section -->
                <div class="payment-method">
                    <h3 class="section-title" style="font-size: 1.2rem;">Payment Method</h3>
                    
                    <div class="payment-option active" data-payment="gcash">
                        <input type="radio" name="payment" id="gcash" checked>
                        <div class="payment-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="payment-details">
                            <div class="payment-name">GCash</div>
                            <div class="payment-description">Pay with your GCash account</div>
                        </div>
                    </div>
                    
                    <div class="payment-option" data-payment="in-store">
                        <input type="radio" name="payment" id="in-store">
                        <div class="payment-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="payment-details">
                            <div class="payment-name">In-Store Payment</div>
                            <div class="payment-description">Pay when you pickup your order</div>
                        </div>
                    </div>
                </div>
                
                <!-- GCash QR Code Section -->
                <div class="gcash-qr active">
                    <h3 class="section-title" style="font-size: 1.2rem;">GCash Payment</h3>
                    <div class="qr-code">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <p class="qr-instructions">Scan this QR code with your GCash app to complete payment</p>
                    <div class="order-id-container" style="background: var(--soft-white); padding: 15px; margin-top: 15px;">
                        <div class="order-id-label">Amount to pay:</div>
                        <div class="order-id-value">₱96.97</div>
                    </div>
                </div>
                
                <!-- Receipt Upload Section -->
                <div class="receipt-upload active">
                    <h3 class="section-title" style="font-size: 1.2rem;">Upload Payment Receipt</h3>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Click to upload your payment receipt</div>
                        <div class="upload-hint">PNG, JPG, or PDF (Max 5MB)</div>
                        <input type="file" class="file-input" id="receiptFile" accept=".png,.jpg,.jpeg,.pdf">
                    </div>
                    <div class="uploaded-file" id="uploadedFile">
                        <i class="fas fa-file-invoice file-icon"></i>
                        <div class="file-name" id="fileName">receipt.png</div>
                        <div class="remove-file" id="removeFile">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Pickup Options -->
                <div class="pickup-options">
                    <h3 class="section-title" style="font-size: 1.2rem;">Pickup Option</h3>
                    
                    <div class="pickup-option active" data-pickup="now">
                        <input type="radio" name="pickup" id="pickup-now" checked>
                        <div class="pickup-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="pickup-details">
                            <div class="pickup-name">Pickup Now</div>
                            <div class="pickup-description">Ready for immediate pickup</div>
                        </div>
                    </div>
                    
                    <div class="pickup-option" data-pickup="schedule">
                        <input type="radio" name="pickup" id="pickup-schedule">
                        <div class="pickup-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="pickup-details">
                            <div class="pickup-name">Schedule Pickup</div>
                            <div class="pickup-description">Pick a date and time (within 3 days)</div>
                        </div>
                    </div>
                </div>
                
                <!-- Schedule Pickup Section -->
                <div class="schedule-pickup">
                    <h3 class="section-title" style="font-size: 1.2rem;">Schedule Your Pickup</h3>
                    
                    <div class="date-time-inputs">
                        <div class="input-group">
                            <label class="input-label" for="pickup-date">Pickup Date</label>
                            <div class="date-input-wrapper">
                                <input type="date" class="custom-input" id="pickup-date" min="" max="">
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label class="input-label" for="pickup-time">Pickup Time</label>
                            <div class="select-wrapper">
                                <select class="custom-select" id="pickup-time">
                                    <option value="">Select Time</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                    <option value="18:00">6:00 PM</option>
                                    <option value="19:00">7:00 PM</option>
                                    <option value="20:00">8:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <p class="date-note">Note: Pickup can be scheduled within the next 3 days only.</p>
                </div>
                
                <!-- Submit Order Button -->
                <button class="submit-order" id="submitOrder">
                    <i class="fas fa-check-circle"></i> Submit Order
                </button>
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
        <a href="donation.html" class="mobile-nav-item">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Donate</span>
        </a>
        <a href="cart.html" class="mobile-nav-item active">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="profile.html" class="mobile-nav-item">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const gcashQR = document.querySelector('.gcash-qr');
            const receiptUpload = document.querySelector('.receipt-upload');
            
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Get the payment method
                    const paymentMethod = this.getAttribute('data-payment');
                    
                    // Show/hide sections based on payment method
                    if (paymentMethod === 'gcash') {
                        gcashQR.classList.add('active');
                        receiptUpload.classList.add('active');
                    } else {
                        gcashQR.classList.remove('active');
                        receiptUpload.classList.remove('active');
                    }
                });
            });
            
            // Pickup option selection
            const pickupOptions = document.querySelectorAll('.pickup-option');
            const schedulePickup = document.querySelector('.schedule-pickup');
            
            pickupOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    pickupOptions.forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Get the pickup option
                    const pickupOption = this.getAttribute('data-pickup');
                    
                    // Show/hide schedule section based on pickup option
                    if (pickupOption === 'schedule') {
                        schedulePickup.classList.add('active');
                    } else {
                        schedulePickup.classList.remove('active');
                    }
                });
            });
            
            // Set date constraints for pickup (today to 3 days from now)
            const pickupDate = document.getElementById('pickup-date');
            const today = new Date();
            const maxDate = new Date();
            maxDate.setDate(today.getDate() + 3);
            
            // Format dates for input min/max attributes
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            pickupDate.min = formatDate(today);
            pickupDate.max = formatDate(maxDate);
            pickupDate.value = formatDate(today);
            
            // File upload functionality
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('receiptFile');
            const uploadedFile = document.getElementById('uploadedFile');
            const fileName = document.getElementById('fileName');
            const removeFile = document.getElementById('removeFile');
            
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    fileName.textContent = file.name;
                    uploadedFile.classList.add('active');
                }
            });
            
            removeFile.addEventListener('click', function(e) {
                e.stopPropagation();
                fileInput.value = '';
                uploadedFile.classList.remove('active');
            });
            
            // Submit order button
            const submitOrder = document.getElementById('submitOrder');
            submitOrder.addEventListener('click', function() {
                // Get selected payment method
                const selectedPayment = document.querySelector('.payment-option.active').getAttribute('data-payment');
                
                // Get selected pickup option
                const selectedPickup = document.querySelector('.pickup-option.active').getAttribute('data-pickup');
                
                // Get pickup details
                let pickupDetails = '';
                if (selectedPickup === 'schedule') {
                    const pickupDate = document.getElementById('pickup-date').value;
                    const pickupTime = document.getElementById('pickup-time').value;
                    
                    if (!pickupTime) {
                        alert('Please select a pickup time for your scheduled pickup.');
                        return;
                    }
                    
                    const formattedDate = new Date(pickupDate).toLocaleDateString('en-US', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                    
                    pickupDetails = `${formattedDate} at ${pickupTime}`;
                } else {
                    pickupDetails = 'Immediate pickup';
                }
                
                // Check if receipt is uploaded for GCash
                if (selectedPayment === 'gcash' && !uploadedFile.classList.contains('active')) {
                    alert('Please upload your payment receipt before submitting your order.');
                    return;
                }
                
                // Show loading state
                const originalText = submitOrder.innerHTML;
                submitOrder.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitOrder.disabled = true;
                
                // Simulate order processing
                setTimeout(() => {
                    alert(`Order submitted successfully!\n\nOrder ID: PV-2023-5876\nPickup: ${pickupDetails}\nPayment Method: ${selectedPayment === 'gcash' ? 'GCash' : 'In-Store Payment'}\n\nThank you for your order!`);
                    
                    // Reset button
                    submitOrder.innerHTML = originalText;
                    submitOrder.disabled = false;
                    
                    // In a real app, you would redirect to order confirmation page
                }, 2000);
            });
        });
    </script>
</body>
</html>
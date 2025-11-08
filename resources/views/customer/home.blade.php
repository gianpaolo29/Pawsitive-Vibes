<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsitive Vibes - Pet Store</title>
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

        /* Categories Section - Centered */
        .categories-section {
            margin-bottom: 30px;
        }

        .categories-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .categories-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 15px;
            justify-content: center;
            max-width: 100%;
        }

        .category-card {
            background: white;
            border-radius: 12px;
            padding: 15px 12px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            min-width: 100px;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--yellow);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .category-card:hover::before {
            transform: scaleX(1);
        }

        .category-card.active {
            background: rgba(138, 43, 226, 0.05);
            border: 1px solid rgba(138, 43, 226, 0.1);
        }

        .category-card.active::before {
            transform: scaleX(1);
        }

        .category-icon {
            font-size: 1.8rem;
            color: var(--primary-violet);
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
            color: var(--dark-violet);
        }

        .category-card h3 {
            font-size: 0.85rem;
            color: var(--dark-gray);
            font-weight: 600;
            font-family: 'Quicksand', sans-serif;
        }

        /* Enhanced Donation Section - Compact */
        .donation-section {
            background: linear-gradient(135deg, var(--vibrant-violet), var(--bright-violet));
            color: white;
            border-radius: 16px;
            padding: 35px 30px;
            margin-bottom: 35px;
            box-shadow: 0 10px 25px rgba(123, 104, 238, 0.2);
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .donation-section::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }

        .donation-section::after {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .donation-icon {
            font-size: 45px;
            margin-bottom: 18px;
            color: white;
            text-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        .donation-content h3 {
            font-size: 24px;
            margin-bottom: 15px;
            font-family: 'Quicksand', sans-serif;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .donation-content p {
            font-size: 14px;
            margin-bottom: 20px;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.5;
        }

        .btn-donate {
            background: var(--yellow);
            color: var(--dark-gray);
            font-size: 14px;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 40px;
            box-shadow: 0 6px 15px rgba(249, 223, 113, 0.4);
            border: 2px solid white;
            position: relative;
            overflow: hidden;
            z-index: 1;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-donate:hover {
            background: #f8da5e;
            box-shadow: 0 8px 20px rgba(249, 223, 113, 0.6);
            transform: translateY(-3px);
        }

        .btn-donate::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.7s;
            z-index: -1;
        }

        .btn-donate:hover::before {
            left: 100%;
        }

        /* Featured Products Section - Special Layout */
        .featured-section {
            margin: 40px 0;
        }

        .featured-products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .featured-product-card {
            background: linear-gradient(135deg, #ffffff, #f8f7ff);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(138, 43, 226, 0.1);
            border: 2px solid rgba(138, 43, 226, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .featured-product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(138, 43, 226, 0.2);
            border-color: rgba(138, 43, 226, 0.3);
        }

        .featured-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--yellow);
            color: var(--dark-gray);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 3px 10px rgba(249, 223, 113, 0.4);
        }

        .featured-product-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--light-violet), var(--vibrant-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .featured-product-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(249, 223, 113, 0.1));
        }

        .featured-product-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .featured-product-name {
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: 700;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .featured-product-description {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 15px;
            line-height: 1.5;
            flex-grow: 1;
        }

        .featured-product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-violet);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .featured-product-price::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--yellow);
            border-radius: 50%;
            margin-right: 8px;
        }

        .featured-product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
        }

        .featured-action-btn {
            background: var(--primary-violet);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            margin: 0 5px;
        }

        .featured-action-btn i {
            margin-right: 8px;
        }

        .featured-action-btn:hover {
            background: var(--dark-violet);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.3);
        }

        .featured-favorite-btn {
            background: #ff4757;
        }

        .featured-favorite-btn:hover {
            background: #ff3742;
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.3);
        }

        /* Regular Products Grid - Compact */
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
            
            /* Centered Categories for Mobile */
            .categories-container {
                display: flex;
                justify-content: center;
            }
            
            .categories-grid {
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
            }
            
            /* Stadium-Shaped Categories for Mobile */
            .category-card {
                border-radius: 50px;
                padding: 8px 16px;
                min-width: auto;
                flex: 0 0 auto;
            }
            
            .category-icon {
                font-size: 1.2rem;
                margin-bottom: 4px;
            }
            
            .category-card h3 {
                font-size: 0.7rem;
            }
            
            /* Featured Products Mobile Layout */
            .featured-products {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .featured-product-image {
                height: 180px;
            }
            
            .featured-product-name {
                font-size: 1.2rem;
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

            .donation-section {
                padding: 25px 20px;
            }

            .donation-content h3 {
                font-size: 20px;
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

            .category-card {
                padding: 6px 12px;
            }

            .category-icon {
                font-size: 1rem;
            }

            .category-card h3 {
                font-size: 0.65rem;
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
            <li><a href="home.html" class="active"><i class="fas fa-home"></i> <span>Home</span></a></li>
            <li><a href="favorites.html"><i class="fas fa-heart"></i> <span>Favorites</span></a></li>
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
            <input type="text" class="search-input" placeholder="Search for pet products, toys, food..." id="searchInput">
            <button class="search-btn" id="searchBtn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Welcome to Pawsitive Vibes</h1>
        <p class="page-subtitle">Discover premium pet products that bring joy to your furry friends and create pawsitive moments every day.</p>
        
        <!-- Categories Section -->
        <section class="categories-section">
            <h2 class="section-title">Shop by Category</h2>
            <div class="categories-container">
                <div class="categories-grid" id="categoriesGrid">
                    <!-- Categories will be dynamically added here -->
                </div>
            </div>
        </section>
        
        <!-- Enhanced Donation Banner -->
        <section class="donation-section">
            <div class="donation-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="donation-content">
                <h3>Support Animal Welfare</h3>
                <p>Help us provide care and shelter for abandoned and rescued animals. Your donation makes a difference in the lives of our furry friends in need.</p>
                <button class="btn-donate">
                    <i class="fas fa-heart"></i> Donate Now
                </button>
            </div>
        </section>
        
        <!-- Featured Products Section -->
        <section class="featured-section">
            <h2 class="section-title">Featured Products</h2>
            <div class="featured-products" id="featuredProductsGrid">
                <!-- Featured products will be dynamically added here -->
            </div>
        </section>
        
        <!-- All Products Section -->
        <section class="all-products-section">
            <h2 class="section-title">All Products</h2>
            <div class="products-grid" id="productsGrid">
                <!-- All products will be dynamically added here -->
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
        <a href="home.html" class="mobile-nav-item active">
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
        // Categories data (removed Grooming)
        const categories = [
            { id: 1, name: "Dog Food", icon: "fas fa-bone" },
            { id: 2, name: "Cat Food", icon: "fas fa-fish" },
            { id: 3, name: "Toys", icon: "fas fa-paw" },
            { id: 4, name: "Accessories", icon: "fas fa-vest" },
            { id: 5, name: "Health Care", icon: "fas fa-shield-alt" },
            { id: 6, name: "Beds", icon: "fas fa-bed" },
            { id: 7, name: "Treats", icon: "fas fa-cookie" }
        ];

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

        // Featured products (first 4 products)
        const featuredProducts = products.slice(0, 4);

        // Initialize favorites and cart from localStorage or empty arrays
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let activeCategory = 'all';

        // Function to render categories
        function renderCategories() {
            const categoriesGrid = document.getElementById('categoriesGrid');
            categoriesGrid.innerHTML = '';

            // Add "All" category
            const allCategory = document.createElement('div');
            allCategory.className = `category-card ${activeCategory === 'all' ? 'active' : ''}`;
            allCategory.setAttribute('data-category', 'all');
            allCategory.innerHTML = `
                <i class="fas fa-th-large category-icon"></i>
                <h3>All Products</h3>
            `;
            categoriesGrid.appendChild(allCategory);

            // Add other categories
            categories.forEach(category => {
                const categoryCard = document.createElement('div');
                categoryCard.className = `category-card ${activeCategory === category.name ? 'active' : ''}`;
                categoryCard.setAttribute('data-category', category.name);
                categoryCard.innerHTML = `
                    <i class="${category.icon} category-icon"></i>
                    <h3>${category.name}</h3>
                `;
                categoriesGrid.appendChild(categoryCard);
            });

            // Add event listeners to category cards
            document.querySelectorAll('.category-card').forEach(card => {
                card.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    filterProductsByCategory(category);
                    
                    // Update active state
                    document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }

        // Function to filter products by category
        function filterProductsByCategory(category) {
            activeCategory = category;
            
            if (category === 'all') {
                renderFeaturedProducts();
                renderProducts(products, 'productsGrid');
            } else {
                const filteredProducts = products.filter(product => product.category === category);
                const filteredFeatured = featuredProducts.filter(product => product.category === category);
                
                renderFeaturedProducts(filteredFeatured);
                renderProducts(filteredProducts, 'productsGrid');
            }
        }

        // Function to render featured products
        function renderFeaturedProducts(featuredArray = featuredProducts) {
            const featuredProductsGrid = document.getElementById('featuredProductsGrid');
            featuredProductsGrid.innerHTML = '';

            if (featuredArray.length === 0) {
                featuredProductsGrid.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--text-gray);">
                        <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.5;"></i>
                        <h3>No featured products found</h3>
                        <p>Try adjusting your filter criteria</p>
                    </div>
                `;
                return;
            }

            featuredArray.forEach(product => {
                const isFavorite = favorites.includes(product.id);
                const inCart = cart.includes(product.id);

                const featuredProductCard = document.createElement('div');
                featuredProductCard.className = 'featured-product-card';
                featuredProductCard.innerHTML = `
                    ${product.badge ? `<div class="featured-badge">${product.badge}</div>` : ''}
                    <div class="featured-product-image">
                        <i class="${product.icon}"></i>
                    </div>
                    <div class="featured-product-info">
                        <h3 class="featured-product-name">${product.name}</h3>
                        <p class="featured-product-description">${product.description}</p>
                        <div class="featured-product-price">$${product.price.toFixed(2)}</div>
                        <div class="featured-product-actions">
                            <button class="featured-action-btn featured-favorite-btn ${isFavorite ? 'active' : ''}" data-id="${product.id}">
                                <i class="fas fa-heart"></i> ${isFavorite ? 'Liked' : 'Like'}
                            </button>
                            <button class="featured-action-btn ${inCart ? 'active' : ''}" data-id="${product.id}">
                                <i class="fas fa-shopping-cart"></i> ${inCart ? 'In Cart' : 'Add to Cart'}
                            </button>
                        </div>
                    </div>
                `;
                featuredProductsGrid.appendChild(featuredProductCard);
            });

            // Add event listeners to featured product buttons
            document.querySelectorAll('.featured-favorite-btn').forEach(btn => {
                btn.addEventListener('click', toggleFeaturedFavorite);
            });

            document.querySelectorAll('.featured-action-btn:not(.featured-favorite-btn)').forEach(btn => {
                btn.addEventListener('click', toggleFeaturedCart);
            });
        }

        // Function to render regular products
        function renderProducts(productsArray, containerId) {
            const productsGrid = document.getElementById(containerId);
            productsGrid.innerHTML = '';

            if (productsArray.length === 0) {
                productsGrid.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--text-gray);">
                        <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.5;"></i>
                        <h3>No products found</h3>
                        <p>Try adjusting your search or filter criteria</p>
                    </div>
                `;
                return;
            }

            productsArray.forEach(product => {
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
                            <button class="action-btn favorite-btn ${isFavorite ? 'active' : ''}" data-id="${product.id}">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button class="action-btn cart-btn ${inCart ? 'active' : ''}" data-id="${product.id}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                `;
                productsGrid.appendChild(productCard);
            });

            // Add event listeners to buttons
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', toggleFavorite);
            });

            document.querySelectorAll('.cart-btn').forEach(btn => {
                btn.addEventListener('click', toggleCart);
            });
        }

        // Toggle favorite status for regular products
        function toggleFavorite(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const index = favorites.indexOf(productId);
            
            if (index === -1) {
                favorites.push(productId);
                e.currentTarget.classList.add('active');
            } else {
                favorites.splice(index, 1);
                e.currentTarget.classList.remove('active');
            }
            
            localStorage.setItem('favorites', JSON.stringify(favorites));
            
            // Update featured products if needed
            renderFeaturedProducts();
            
            // Reset the button size after click
            e.currentTarget.style.transform = 'scale(1)';
        }

        // Toggle favorite status for featured products
        function toggleFeaturedFavorite(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const index = favorites.indexOf(productId);
            
            if (index === -1) {
                favorites.push(productId);
                e.currentTarget.classList.add('active');
                e.currentTarget.innerHTML = '<i class="fas fa-heart"></i> Liked';
            } else {
                favorites.splice(index, 1);
                e.currentTarget.classList.remove('active');
                e.currentTarget.innerHTML = '<i class="fas fa-heart"></i> Like';
            }
            
            localStorage.setItem('favorites', JSON.stringify(favorites));
            
            // Update regular products if needed
            renderProducts(products, 'productsGrid');
        }

        // Toggle cart status for regular products
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
            
            // Update featured products if needed
            renderFeaturedProducts();
            
            // Reset the button size after click
            e.currentTarget.style.transform = 'scale(1)';
        }

        // Toggle cart status for featured products
        function toggleFeaturedCart(e) {
            const productId = parseInt(e.currentTarget.getAttribute('data-id'));
            const index = cart.indexOf(productId);
            
            if (index === -1) {
                cart.push(productId);
                e.currentTarget.classList.add('active');
                e.currentTarget.innerHTML = '<i class="fas fa-shopping-cart"></i> In Cart';
            } else {
                cart.splice(index, 1);
                e.currentTarget.classList.remove('active');
                e.currentTarget.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Update regular products if needed
            renderProducts(products, 'productsGrid');
        }

        // Search functionality
        function handleSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            if (searchTerm === '') {
                filterProductsByCategory(activeCategory);
                return;
            }

            const searchResults = products.filter(product => 
                product.name.toLowerCase().includes(searchTerm) || 
                product.category.toLowerCase().includes(searchTerm) ||
                product.description.toLowerCase().includes(searchTerm)
            );

            const featuredSearchResults = featuredProducts.filter(product => 
                product.name.toLowerCase().includes(searchTerm) || 
                product.category.toLowerCase().includes(searchTerm) ||
                product.description.toLowerCase().includes(searchTerm)
            );

            // Clear both product grids and show search results
            document.getElementById('featuredProductsGrid').innerHTML = '';
            document.getElementById('productsGrid').innerHTML = '';
            
            if (searchResults.length > 0) {
                renderFeaturedProducts(featuredSearchResults);
                renderProducts(searchResults, 'productsGrid');
                document.querySelector('.section-title').textContent = 'Search Results';
            } else {
                document.getElementById('featuredProductsGrid').innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--text-gray);">
                        <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.5;"></i>
                        <h3>No products found for "${searchTerm}"</h3>
                        <p>Try adjusting your search terms</p>
                    </div>
                `;
                document.querySelector('.section-title').textContent = 'Search Results';
            }
        }

        // Donate button functionality
        document.querySelector('.btn-donate').addEventListener('click', function() {
            alert('Thank you for your willingness to support animal shelters! You will be redirected to our donation page.');
            // In a real application, you would redirect to a donation page
        });

        // Mobile bottom nav functionality
        document.querySelectorAll('.mobile-nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.mobile-nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderCategories();
            renderFeaturedProducts();
            renderProducts(products, 'productsGrid');

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
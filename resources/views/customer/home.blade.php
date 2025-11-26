<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsitive Vibes | Pet Supply Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --main-color: #FFFFFF;
            --secondary-color: #8259E2;
            --accent-color: #F9DF97;
            --text-color: #333333;
            --light-text: #666666;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --transition: all 0.3s ease;
            --footer-bg: #1a1a2e;
            --footer-text: #e6e6e6;
            --vibrant-violet: #8259E2;
            --bright-violet: #9d7cf0;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--secondary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 50px;
            width: auto;
            margin-right: 10px;
            border-radius: 8px;
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 14px;
        }

        .btn-login {
            background: transparent;
            color: var(--secondary-color);
            border: 2px solid var(--secondary-color);
        }

        .btn-login:hover {
            background: var(--secondary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(130, 89, 226, 0.3);
        }

        .btn-signup {
            background: var(--secondary-color);
            color: white;
        }

        .btn-signup:hover {
            background: #6a46c4;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(130, 89, 226, 0.3);
        }

        /* Hero Section with Integrated Card */
        .hero {
            padding: 150px 0 80px;
            display: flex;
            align-items: center;
            min-height: 80vh;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            position: relative;
            z-index: 2;
        }

        .hero-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            padding: 40px;
            box-shadow: var(--shadow);
            display: flex;
            gap: 40px;
            align-items: center;
            transition: var(--transition);
            width: 100%;
        }

        .hero-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(31, 38, 135, 0.2);
        }

        .hero-text {
            flex: 1;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .hero-image img {
            width: 100%;
            max-width: 300px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
        }

        .hero-image img:hover {
            transform: scale(1.03);
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 20px;
            color: var(--secondary-color);
            line-height: 1.2;
        }

        .hero p {
            font-size: 16px;
            margin-bottom: 30px;
            color: var(--light-text);
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        /* Glass Morphism Buttons */
        .btn-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 16px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .btn-shop {
            color: #333;
            background: rgba(249, 223, 151, 0.7);
            border: 1px solid rgba(249, 223, 151, 0.5);
        }

        .btn-shop:hover {
            background: rgba(249, 223, 151, 0.9);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(249, 223, 151, 0.4);
        }

        .btn-donate-hero {
            color: white;
            background: rgba(130, 89, 226, 0.7);
            border: 1px solid rgba(130, 89, 226, 0.5);
        }

        .btn-donate-hero:hover {
            background: rgba(130, 89, 226, 0.9);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(130, 89, 226, 0.4);
        }

        .btn-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.7s;
        }

        .btn-glass:hover::before {
            left: 100%;
        }

        /* Enhanced donation button with better visibility */
        .btn-donate {
            background: var(--accent-color);
            color: #333;
            font-size: 18px;
            font-weight: 700;
            padding: 16px 35px;
            box-shadow: 0 8px 20px rgba(249, 223, 151, 0.4);
            border: 2px solid white;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-donate:hover {
            background: #f5d57a;
            box-shadow: 0 12px 25px rgba(249, 223, 151, 0.6);
            transform: translateY(-5px) scale(1.05);
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

        /* Categories Section */
        .categories {
            padding: 80px 0;
        }

        .categories-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 0;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px 20px;
            position: relative;
            transition: var(--transition);
            cursor: pointer;
        }

        .category-item:hover {
            transform: translateY(-5px);
        }

        .category-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 40px;
            background: rgba(130, 89, 226, 0.2);
        }

        .category-icon {
            font-size: 24px;
            margin-bottom: 8px;
            color: var(--secondary-color);
            transition: var(--transition);
        }

        .category-item:hover .category-icon {
            color: var(--accent-color);
            transform: scale(1.1);
        }

        .category-name {
            font-weight: 500;
            font-size: 14px;
            color: var(--text-color);
            text-align: center;
            transition: var(--transition);
        }

        .category-item:hover .category-name {
            color: var(--secondary-color);
            font-weight: 600;
        }

        /* Donation Section */
        .donation-section {
            background: rgba(130, 89, 226, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 30px;
            margin: 80px auto;
            max-width: 900px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.3);
            transition: var(--transition);
            color: white;
        }

        .donation-section:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(31, 38, 135, 0.4);
        }

        .donation-icon {
            font-size: 60px;
            color: var(--accent-color);
            flex-shrink: 0;
        }

        .donation-content {
            flex: 1;
        }

        .donation-content h3 {
            font-size: 28px;
            margin-bottom: 15px;
            color: white;
        }

        .donation-content p {
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
        }

        /* Featured Products */
        .featured-products {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-size: 36px;
            color: var(--secondary-color);
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--shadow);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(31, 38, 135, 0.2);
        }

        .best-selling {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--accent-color);
            color: #333;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            z-index: 2;
        }

        .product-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .product-price {
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 20px;
        }

        /* Featured Product Reviews - Carousel */
        .reviews {
            padding: 80px 0;
        }

        .reviews-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 20px;
        }

        .reviews-slider {
            display: flex;
            transition: transform 0.5s ease;
            gap: 20px;
            padding: 20px;
        }

        .review-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 20px;
            transition: var(--transition);
            box-shadow: var(--shadow);
            flex: 0 0 calc(33.333% - 14px);
            min-height: 350px;
            display: flex;
            flex-direction: column;
        }

        .review-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(31, 38, 135, 0.2);
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .review-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
        }

        .reviewer-info {
            flex: 1;
        }

        .reviewer-name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .product-details {
            font-size: 12px;
            color: var(--light-text);
            margin-bottom: 3px;
        }

        .stars {
            color: var(--accent-color);
            font-size: 12px;
        }

        .review-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            margin: 10px 0;
        }

        .review-comment {
            font-size: 13px;
            color: var(--text-color);
            line-height: 1.4;
            flex: 1;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }

        .reviews-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            color: var(--secondary-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
            font-size: 16px;
            box-shadow: var(--shadow);
        }

        .reviews-nav:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-50%) scale(1.1);
        }

        .reviews-prev {
            left: 10px;
        }

        .reviews-next {
            right: 10px;
        }

        .reviews-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
        }

        .review-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(130, 89, 226, 0.3);
            cursor: pointer;
            transition: var(--transition);
        }

        .review-dot.active {
            background: var(--secondary-color);
            transform: scale(1.2);
        }

        .review-dot:hover {
            background: var(--secondary-color);
            transform: scale(1.1);
        }

        /* Services Section */
        .services {
            padding: 80px 0;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: rgba(130, 89, 226, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            transition: var(--transition);
            color: white;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.3);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .service-card:hover::before {
            left: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(31, 38, 135, 0.4);
        }

        .service-icon {
            font-size: 60px;
            color: var(--accent-color);
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .service-title {
            font-size: 24px;
            margin-bottom: 15px;
            color: white;
            position: relative;
            z-index: 2;
        }

        .service-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            position: relative;
            z-index: 2;
        }

        /* Gallery Section - 3 Images at a Time */
        .gallery {
            padding: 80px 0;
        }

        .gallery-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 20px;
        }

        .gallery-slider {
            display: flex;
            transition: transform 0.5s ease;
            gap: 20px;
            padding: 20px;
        }

        .gallery-slide {
            flex: 0 0 calc(33.333% - 14px);
            height: 350px;
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            transition: var(--transition);
            opacity: 0.7;
            transform: scale(0.9);
        }

        .gallery-slide.active {
            opacity: 1;
            transform: scale(1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .gallery-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            color: var(--secondary-color);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
            font-size: 20px;
            box-shadow: var(--shadow);
        }

        .gallery-nav:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-50%) scale(1.1);
        }

        .gallery-prev {
            left: 20px;
        }

        .gallery-next {
            right: 20px;
        }

        /* Gallery Navigation Dots */
        .gallery-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
        }

        .gallery-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(130, 89, 226, 0.3);
            cursor: pointer;
            transition: var(--transition);
        }

        .gallery-dot.active {
            background: var(--secondary-color);
            transform: scale(1.2);
        }

        .gallery-dot:hover {
            background: var(--secondary-color);
            transform: scale(1.1);
        }

        /* Footer */
        footer {
            background: var(--footer-bg);
            color: var(--footer-text);
            padding: 60px 0 30px;
            margin-top: 50px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--accent-color);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--footer-text);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent-color);
            padding-left: 5px;
        }

        .contact-info {
            color: var(--footer-text);
        }

        .social-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: var(--secondary-color);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: var(--transition);
        }

        .social-icon:hover {
            background: #6a46c4;
            transform: translateY(-5px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--footer-text);
            font-size: 14px;
        }

        .footer-bottom p {
            margin-bottom: 5px;
        }

        /* New UI Improvements */
        .floating-paw {
            position: absolute;
            font-size: 20px;
            color: var(--secondary-color);
            opacity: 0.7;
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--secondary-color), transparent);
            margin: 40px auto;
            width: 80%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
            }
            
            .hero-card {
                flex-direction: column;
                text-align: center;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-glass, .btn-donate {
                width: 100%;
                text-align: center;
            }
            
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .auth-buttons {
                width: 100%;
                justify-content: center;
            }
            
            .donation-section {
                flex-direction: column;
                text-align: center;
            }
            
            .categories-container {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .category-item:not(:last-child)::after {
                display: none;
            }
            
            .gallery-slide, .review-card {
                flex: 0 0 calc(100% - 20px);
                height: 250px;
            }
            
            .gallery-nav, .reviews-nav {
                width: 40px;
                height: 40px;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">
                    <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\pawsitive-logo.jpg" alt="Pawsitive Vibes" class="logo-img">
                     Pawsitive Vibes
                </a>
                <div class="auth-buttons">
                    <button class="btn btn-login">Login</button>
                    <button class="btn btn-signup">Sign Up</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-card">
                    <div class="hero-text">
                        <h1>Premium Pet Supplies for Happy Pets</h1>
                        <p>At Pawsitive Vibes, we believe every pet deserves the best. From nutritious food to fun toys and cozy beds, we've got everything to keep your furry friends healthy and happy.</p>
                        <div class="hero-buttons">
                            <button class="btn-glass btn-shop">View Shop</button>
                            <button class="btn-glass btn-donate-hero">Donate Now</button>
                        </div>
                    </div>
                    <div class="hero-image">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\temp-cover2.jpg" alt="Happy pets with toys">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Our Products</h2>
            <div class="categories-container">
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-bone"></i>
                    </div>
                    <div class="category-name">Dry Dog Food</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                    <div class="category-name">Wet Dog Food</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-dog"></i>
                    </div>
                    <div class="category-name">For Puppies</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <div class="category-name">Dry Cat Food</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="category-name">Wet Cat Food</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-cat"></i>
                    </div>
                    <div class="category-name">For Kittens</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-cookie"></i>
                    </div>
                    <div class="category-name">Treats</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="category-name">Vitamins</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div class="category-name">Other Supplies</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Section -->
    <section class="container">
        <div class="donation-section">
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
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">Best Selling Products</h2>
            <div class="products-grid">
                <div class="product-card">
                    <div class="best-selling">Best Seller</div>
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80" alt="Premium Dog Food" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">Premium Dog Food</h3>
                        <p class="product-price">₱1,250</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="best-selling">Best Seller</div>
                    <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Cat Tree" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">Multi-Level Cat Tree</h3>
                        <p class="product-price">₱2,800</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="best-selling">Best Seller</div>
                    <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c3a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Pet Toys" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">Assorted Pet Toys</h3>
                        <p class="product-price">₱350</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="best-selling">Best Seller</div>
                    <img src="https://images.unsplash.com/photo-1591946614720-90c6a604b7be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Pet Bed" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">Orthopedic Pet Bed</h3>
                        <p class="product-price">₱1,750</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery -->
    <section class="gallery">
        <div class="container">
            <h2 class="section-title">Store Gallery</h2>
            <div class="gallery-container">
                <div class="gallery-slider">
                    <div class="gallery-slide">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img2.jpg" alt="Store Image 2">
                    </div>
                    <div class="gallery-slide active">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img3.jpg" alt="Store Image 3">
                    </div>
                    <div class="gallery-slide">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img4.jpg" alt="Store Image 4">
                    </div>
                    <div class="gallery-slide">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img5.jpg" alt="Store Image 5">
                    </div>
                    <div class="gallery-slide">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img6.jpg" alt="Store Image 6">
                    </div>
                    <div class="gallery-slide">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img7.jpg" alt="Store Image 7">
                    </div>
                    <div class="gallery-slide">
                        <img src="C:\Users\Theresa\Pawsitive Vibes Pet Supplies Shop\Pawsitive-Vibes\public\images\img8.jpg" alt="Store Image 8">
                    </div>
                </div>
                <button class="gallery-nav gallery-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="gallery-nav gallery-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <!-- Gallery Navigation Dots -->
            <div class="gallery-dots">
                <!-- Dots will be generated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="service-title">Online Ordering</h3>
                    <p class="service-description">Order anytime, anywhere & pay your way! Smooth pickup, zero hassle.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="service-title">In-store Pickup</h3>
                    <p class="service-description">Pickup your order within 24 hours! Hassle-free and convenient.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Product Reviews -->
    <section class="reviews">
        <div class="container">
            <h2 class="section-title">Featured Product Reviews</h2>
            <div class="reviews-container">
                <div class="reviews-slider">
                    <!-- Review 1 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Sarah Johnson" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">Sarah Johnson</div>
                                <div class="product-details">Premium Dog Food • Large Bag</div>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">My golden retriever absolutely loves this food! His coat has never been shinier and he has so much more energy. Will definitely purchase again!</p>
                    </div>

                    <!-- Review 2 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Michael Chen" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">Michael Chen</div>
                                <div class="product-details">Multi-Level Cat Tree • Large</div>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">This cat tree is amazing! My three cats fight over who gets to sleep on the top level. Very sturdy and well-made. Worth every penny!</p>
                    </div>

                    <!-- Review 3 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Emily Rodriguez" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">Emily Rodriguez</div>
                                <div class="product-details">Assorted Pet Toys • Mixed Set</div>
                                <div class="stars">★★★★☆</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c3a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">Great variety of toys! My puppy loves the squeaky balls the most. Some toys are more durable than others, but overall good value.</p>
                    </div>

                    <!-- Review 4 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="David Kim" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">David Kim</div>
                                <div class="product-details">Orthopedic Pet Bed • Medium</div>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1591946614720-90c6a604b7be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">My senior dog with arthritis sleeps so much better on this bed. It provides excellent support and is easy to clean. Highly recommend!</p>
                    </div>

                    <!-- Review 5 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1167&q=80" alt="Lisa Thompson" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">Lisa Thompson</div>
                                <div class="product-details">Wet Cat Food • Chicken Flavor</div>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1574231164645-d6f0e8553590?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=735&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">My picky eater finally found a wet food she loves! The ingredients are high quality and she's maintaining a healthy weight. Great product!</p>
                    </div>

                    <!-- Review 6 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Robert Garcia" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">Robert Garcia</div>
                                <div class="product-details">Dog Vitamins • Joint Support</div>
                                <div class="stars">★★★★☆</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1130&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">Noticed improvement in my dog's mobility after a month. Easy to administer with food. Would give 5 stars if the tablets were smaller.</p>
                    </div>

                    <!-- Review 7 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Maria Santos" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">Maria Santos</div>
                                <div class="product-details">Puppy Training Treats • Chicken</div>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1559056199-5ef0f86b53a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">Perfect size for training! My puppy responds well to these treats and they don't upset his stomach. We're making great progress with obedience training!</p>
                    </div>

                    <!-- Review 8 -->
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="James Wilson" class="review-profile">
                            <div class="reviewer-info">
                                <div class="reviewer-name">James Wilson</div>
                                <div class="product-details">Cat Scratching Post • Tall</div>
                                <div class="stars">★★★★☆</div>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1143&q=80" alt="Product Review" class="review-image">
                        <p class="review-comment">Saved my furniture! My cats prefer this over the couch now. Sturdy construction and the included catnip really attracted them to it initially.</p>
                    </div>
                </div>
                <button class="reviews-nav reviews-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="reviews-nav reviews-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <!-- Reviews Navigation Dots -->
            <div class="reviews-dots">
                <!-- Dots will be generated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>About Us</h3>
                    <ul class="footer-links">
                        <li><a href="aboutus.html">Our Story</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Policies</h3>
                    <ul class="footer-links">
                        <li><a href="userpolicy.html">User Policy</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <div class="contact-info">
                        <p>0917 828 0994</p>
                        <p>pawsitivevibes@gmail.com</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/profile.php?id=61575048088417" class="social-icon">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Learn More</h3>
                    <ul class="footer-links">
                        <li><a href="donationinformation.html">About Donations</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Location: 122 JP Laurel St., Brgy. 2-Poblacion, Nasugbu, Batangas</p>
                <p>Pawsitive Vibes | Pet Supplies Shop</p>
                <p>by Ivory Studio (2025)</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect to buttons
            const buttons = document.querySelectorAll('.btn, .btn-glass, .btn-donate');
            
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Add click effect to cards
            const cards = document.querySelectorAll('.product-card, .donation-section, .category-item, .review-card, .service-card');
            
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
            
            // Create floating paw elements
            const heroSection = document.querySelector('.hero');
            for (let i = 0; i < 10; i++) {
                const paw = document.createElement('div');
                paw.classList.add('floating-paw');
                paw.innerHTML = '<i class="fas fa-paw"></i>';
                paw.style.left = `${Math.random() * 100}%`;
                paw.style.top = `${Math.random() * 100}%`;
                paw.style.animationDelay = `${Math.random() * 5}s`;
                heroSection.appendChild(paw);
            }

            // Gallery slider functionality - 3 images at a time
            const gallerySlider = document.querySelector('.gallery-slider');
            const gallerySlides = document.querySelectorAll('.gallery-slide');
            const galleryPrevBtn = document.querySelector('.gallery-prev');
            const galleryNextBtn = document.querySelector('.gallery-next');
            const galleryDotsContainer = document.querySelector('.gallery-dots');
            let currentGallerySlide = 1; // Start with center slide
            const totalGallerySlides = gallerySlides.length;
            const visibleGallerySlides = 3;
            let galleryAutoSlideInterval;
            let galleryUserInteracted = false;

            // Create gallery navigation dots
            function createGalleryDots() {
                for (let i = 0; i < totalGallerySlides; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('gallery-dot');
                    if (i === currentGallerySlide) {
                        dot.classList.add('active');
                    }
                    dot.addEventListener('click', () => {
                        galleryUserInteracted = true;
                        goToGallerySlide(i);
                        resetGalleryAutoSlide();
                    });
                    galleryDotsContainer.appendChild(dot);
                }
            }

            function updateGallery() {
                // Remove active class from all slides
                gallerySlides.forEach(slide => slide.classList.remove('active'));
                
                // Add active class to current slide and adjacent slides
                for (let i = -1; i <= 1; i++) {
                    const index = (currentGallerySlide + i + totalGallerySlides) % totalGallerySlides;
                    gallerySlides[index].classList.add('active');
                }
                
                // Calculate transform for smooth sliding
                const slideWidth = 100 / visibleGallerySlides;
                const offset = -(currentGallerySlide - 1) * slideWidth;
                gallerySlider.style.transform = `translateX(${offset}%)`;
                
                // Update dots
                const dots = document.querySelectorAll('.gallery-dot');
                dots.forEach((dot, index) => {
                    if (index === currentGallerySlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            function goToGallerySlide(slideIndex) {
                currentGallerySlide = slideIndex;
                updateGallery();
            }

            function nextGallerySlide() {
                currentGallerySlide = (currentGallerySlide + 1) % totalGallerySlides;
                updateGallery();
            }

            function prevGallerySlide() {
                currentGallerySlide = (currentGallerySlide - 1 + totalGallerySlides) % totalGallerySlides;
                updateGallery();
            }

            function startGalleryAutoSlide() {
                if (!galleryUserInteracted) {
                    galleryAutoSlideInterval = setInterval(nextGallerySlide, 5000);
                }
            }

            function resetGalleryAutoSlide() {
                clearInterval(galleryAutoSlideInterval);
                if (!galleryUserInteracted) {
                    startGalleryAutoSlide();
                }
            }

            function handleGalleryUserInteraction() {
                if (!galleryUserInteracted) {
                    galleryUserInteracted = true;
                    clearInterval(galleryAutoSlideInterval);
                }
            }

            galleryPrevBtn.addEventListener('click', () => {
                handleGalleryUserInteraction();
                prevGallerySlide();
            });

            galleryNextBtn.addEventListener('click', () => {
                handleGalleryUserInteraction();
                nextGallerySlide();
            });

            // Initialize gallery
            createGalleryDots();
            updateGallery();
            startGalleryAutoSlide();

            // Reviews slider functionality - 3 reviews at a time
            const reviewsSlider = document.querySelector('.reviews-slider');
            const reviewCards = document.querySelectorAll('.review-card');
            const reviewsPrevBtn = document.querySelector('.reviews-prev');
            const reviewsNextBtn = document.querySelector('.reviews-next');
            const reviewsDotsContainer = document.querySelector('.reviews-dots');
            let currentReviewSlide = 0; // Start with first slide
            const totalReviewSlides = Math.ceil(reviewCards.length / 3);
            let reviewsAutoSlideInterval;
            let reviewsUserInteracted = false;

            // Create reviews navigation dots
            function createReviewsDots() {
                for (let i = 0; i < totalReviewSlides; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('review-dot');
                    if (i === currentReviewSlide) {
                        dot.classList.add('active');
                    }
                    dot.addEventListener('click', () => {
                        reviewsUserInteracted = true;
                        goToReviewSlide(i);
                        resetReviewsAutoSlide();
                    });
                    reviewsDotsContainer.appendChild(dot);
                }
            }

            function updateReviews() {
                // Calculate transform for smooth sliding
                const slideWidth = 100 / 3;
                const offset = -(currentReviewSlide) * slideWidth * 3;
                reviewsSlider.style.transform = `translateX(${offset}%)`;
                
                // Update dots
                const dots = document.querySelectorAll('.review-dot');
                dots.forEach((dot, index) => {
                    if (index === currentReviewSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            function goToReviewSlide(slideIndex) {
                currentReviewSlide = slideIndex;
                updateReviews();
            }

            function nextReviewSlide() {
                currentReviewSlide = (currentReviewSlide + 1) % totalReviewSlides;
                updateReviews();
            }

            function prevReviewSlide() {
                currentReviewSlide = (currentReviewSlide - 1 + totalReviewSlides) % totalReviewSlides;
                updateReviews();
            }

            function startReviewsAutoSlide() {
                if (!reviewsUserInteracted) {
                    reviewsAutoSlideInterval = setInterval(nextReviewSlide, 5000);
                }
            }

            function resetReviewsAutoSlide() {
                clearInterval(reviewsAutoSlideInterval);
                if (!reviewsUserInteracted) {
                    startReviewsAutoSlide();
                }
            }

            function handleReviewsUserInteraction() {
                if (!reviewsUserInteracted) {
                    reviewsUserInteracted = true;
                    clearInterval(reviewsAutoSlideInterval);
                }
            }

            reviewsPrevBtn.addEventListener('click', () => {
                handleReviewsUserInteraction();
                prevReviewSlide();
            });

            reviewsNextBtn.addEventListener('click', () => {
                handleReviewsUserInteraction();
                nextReviewSlide();
            });

            // Initialize reviews
            createReviewsDots();
            updateReviews();
            startReviewsAutoSlide();
        });
    </script>
</body>
</html>
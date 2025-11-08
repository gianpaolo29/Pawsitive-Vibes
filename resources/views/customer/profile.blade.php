<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Pawsitive Vibes</title>
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

        /* Navigation Bar Styles */
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

        /* Main Content Styles */
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

        /* Profile Header Section */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .profile-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-violet);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.3);
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 5px;
            font-family: 'Quicksand', sans-serif;
        }

        .profile-email {
            color: var(--text-gray);
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .edit-profile-btn {
            background: var(--primary-violet);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .edit-profile-btn:hover {
            background: var(--dark-violet);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.3);
        }

        /* Stats Section */
        .stats-section {
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--primary-violet);
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-gray);
            font-size: 0.9rem;
        }

        /* Profile List Section */
        .profile-list-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--yellow);
            border-radius: 2px;
        }

        .profile-list {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .list-item {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid var(--light-gray);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .list-item:hover {
            background: rgba(138, 43, 226, 0.05);
            transform: translateX(5px);
        }

        .list-item.danger:hover {
            background: rgba(255, 71, 87, 0.05);
        }

        .list-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(138, 43, 226, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-violet);
            font-size: 1.2rem;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .list-item:hover .list-icon {
            background: var(--primary-violet);
            color: white;
        }

        .list-item.danger .list-icon {
            background: rgba(255, 71, 87, 0.1);
            color: #ff4757;
        }

        .list-item.danger:hover .list-icon {
            background: #ff4757;
            color: white;
        }

        .list-content {
            flex: 1;
        }

        .list-title {
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 1rem;
        }

        .list-description {
            color: var(--text-gray);
            font-size: 0.85rem;
        }

        .list-arrow {
            color: var(--text-gray);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .list-item:hover .list-arrow {
            color: var(--primary-violet);
            transform: translateX(3px);
        }

        .list-item.danger:hover .list-arrow {
            color: #ff4757;
        }

        /* Footer */
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

        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            display: none;
        }

        /* Modal Styles */
        .modal-overlay {
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

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
        }

        .modal-title {
            font-size: 1.3rem;
            color: var(--dark-gray);
            font-family: 'Quicksand', sans-serif;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--text-gray);
            cursor: pointer;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            color: var(--primary-violet);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark-gray);
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
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            text-align: center;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            body {
                padding-bottom: 70px;
            }
            
            .nav-links {
                display: none;
            }

            .nav-hamburger {
                display: block;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .profile-icon {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .footer-links {
                flex-wrap: wrap;
            }

            .footer-links li:not(:last-child)::after {
                display: none;
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
            .stats-grid {
                grid-template-columns: 1fr;
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
            <li><a href="donations.html"><i class="fas fa-hand-holding-usd"></i> <span>Donate</span></a></li>
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i> <span>Cart</span></a></li>
            <li><a href="profile.html" class="active"><i class="fas fa-user"></i> <span>Profile</span></a></li>
        </ul>
        
        <button class="nav-hamburger" id="navHamburger">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">My Profile</h1>
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2 class="profile-name" id="profileName">Alex Johnson</h2>
                <p class="profile-email" id="profileEmail">alex.johnson@example.com</p>
                <button class="edit-profile-btn" id="editProfileBtn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-number">12</div>
                    <div class="stat-label">Orders Made</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-number">2</div>
                    <div class="stat-label">Unclaimed Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-number">8</div>
                    <div class="stat-label">Favorites</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-number">3</div>
                    <div class="stat-label">Items in Cart</div>
                </div>
            </div>
        </div>

        <!-- Profile List Section -->
        <div class="profile-list-section">
            <h2 class="section-title">Account Settings</h2>
            
            <div class="profile-list">
                <a href="#" class="list-item">
                    <div class="list-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="list-content">
                        <div class="list-title">View Unclaimed Orders</div>
                        <div class="list-description">Check your pending orders and pickup status</div>
                    </div>
                    <div class="list-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="#" class="list-item">
                    <div class="list-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="list-content">
                        <div class="list-title">View Order History</div>
                        <div class="list-description">See all your past purchases and order details</div>
                    </div>
                    <div class="list-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="#" class="list-item">
                    <div class="list-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="list-content">
                        <div class="list-title">View Reviews</div>
                        <div class="list-description">See all reviews you've written for products</div>
                    </div>
                    <div class="list-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="#" class="list-item">
                    <div class="list-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="list-content">
                        <div class="list-title">Review Product</div>
                        <div class="list-description">Write a review for products you've purchased</div>
                    </div>
                    <div class="list-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="#" class="list-item" id="changePasswordItem">
                    <div class="list-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="list-content">
                        <div class="list-title">Change Password</div>
                        <div class="list-description">Update your account password for security</div>
                    </div>
                    <div class="list-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="#" class="list-item danger" id="signOutItem">
                    <div class="list-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="list-content">
                        <div class="list-title">Sign Out</div>
                        <div class="list-description">Securely sign out of your account</div>
                    </div>
                    <div class="list-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Edit Profile</h3>
                <button class="close-modal" id="closeEditProfileModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editName">Full Name</label>
                    <input type="text" id="editName" class="form-control" value="Alex Johnson">
                </div>
                <div class="form-group">
                    <label for="editEmail">Email Address</label>
                    <input type="email" id="editEmail" class="form-control" value="alex.johnson@example.com">
                </div>
                <div class="form-group">
                    <label for="editPhone">Phone Number</label>
                    <input type="tel" id="editPhone" class="form-control" value="+1 (555) 123-4567">
                </div>
                <div class="form-group">
                    <label for="editAddress">Address</label>
                    <textarea id="editAddress" class="form-control" rows="3">123 Main Street, Apt 4B, New York, NY 10001</textarea>
                </div>
                <button class="btn btn-primary btn-block" id="saveProfileBtn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal-overlay" id="changePasswordModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Change Password</h3>
                <button class="close-modal" id="closeChangePasswordModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" id="currentPassword" class="form-control" placeholder="Enter current password">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" class="form-control" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm new password">
                    </div>
                </div>
                <button class="btn btn-primary btn-block" id="updatePasswordBtn">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
        <a href="donations.html" class="mobile-nav-item">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Donate</span>
        </a>
        <a href="cart.html" class="mobile-nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="profile.html" class="mobile-nav-item active">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </div>

    <script>
        // DOM Elements
        const editProfileBtn = document.getElementById('editProfileBtn');
        const editProfileModal = document.getElementById('editProfileModal');
        const closeEditProfileModal = document.getElementById('closeEditProfileModal');
        const saveProfileBtn = document.getElementById('saveProfileBtn');
        const changePasswordItem = document.getElementById('changePasswordItem');
        const changePasswordModal = document.getElementById('changePasswordModal');
        const closeChangePasswordModal = document.getElementById('closeChangePasswordModal');
        const updatePasswordBtn = document.getElementById('updatePasswordBtn');
        const signOutItem = document.getElementById('signOutItem');

        // Profile data
        let profileData = {
            name: "Alex Johnson",
            email: "alex.johnson@example.com",
            phone: "+1 (555) 123-4567",
            address: "123 Main Street, Apt 4B, New York, NY 10001"
        };

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            updateProfileDisplay();
            setupEventListeners();
        });

        // Update profile display
        function updateProfileDisplay() {
            document.getElementById('profileName').textContent = profileData.name;
            document.getElementById('profileEmail').textContent = profileData.email;
            document.getElementById('editName').value = profileData.name;
            document.getElementById('editEmail').value = profileData.email;
            document.getElementById('editPhone').value = profileData.phone;
            document.getElementById('editAddress').value = profileData.address;
        }

        // Setup event listeners
        function setupEventListeners() {
            // Edit profile modal
            editProfileBtn.addEventListener('click', function() {
                editProfileModal.classList.add('active');
            });

            closeEditProfileModal.addEventListener('click', function() {
                editProfileModal.classList.remove('active');
            });

            // Save profile changes
            saveProfileBtn.addEventListener('click', function() {
                profileData.name = document.getElementById('editName').value;
                profileData.email = document.getElementById('editEmail').value;
                profileData.phone = document.getElementById('editPhone').value;
                profileData.address = document.getElementById('editAddress').value;
                
                updateProfileDisplay();
                editProfileModal.classList.remove('active');
                
                // Show success message
                alert('Profile updated successfully!');
            });

            // Change password modal
            changePasswordItem.addEventListener('click', function(e) {
                e.preventDefault();
                changePasswordModal.classList.add('active');
            });

            closeChangePasswordModal.addEventListener('click', function() {
                changePasswordModal.classList.remove('active');
            });

            // Update password
            updatePasswordBtn.addEventListener('click', function() {
                const currentPassword = document.getElementById('currentPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                
                if (!currentPassword || !newPassword || !confirmPassword) {
                    alert('Please fill in all password fields');
                    return;
                }
                
                if (newPassword !== confirmPassword) {
                    alert('New passwords do not match');
                    return;
                }
                
                if (newPassword.length < 6) {
                    alert('Password must be at least 6 characters long');
                    return;
                }
                
                // In a real app, you would send this to a server
                console.log('Password change requested');
                
                changePasswordModal.classList.remove('active');
                alert('Password updated successfully!');
                
                // Reset form
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            });

            // Sign out
            signOutItem.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to sign out?')) {
                    // In a real app, this would clear authentication and redirect
                    alert('You have been signed out. Redirecting to login page...');
                    // window.location.href = 'login.html';
                }
            });

            // Close modals when clicking outside
            editProfileModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });

            changePasswordModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pawsitive Vibes | Pet Shop Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('icons/logo.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{
            --primary-violet:#8a2be2;--light-violet:#b19cd9;--dark-violet:#6a0dad;
            --violet-blue:#6c63ff;--light-violet-blue:#a5a1ff;--dark-violet-blue:#5651d4;
            --vibrant-violet:#7b68ee;--bright-violet:#9370db;--yellow:#F9DF71;--light-yellow:#fff9e6;
            --soft-white:#fefefe;--light-gray:#f8f7ff;--medium-gray:#e0ddf5;--text-gray:#666;--dark-gray:#444;
            --card-shadow:0 5px 15px rgba(138,43,226,.08);--hover-shadow:0 8px 25px rgba(138,43,226,.15)
        }
        body{background:#ffffff;min-height:100vh;font-family:'Poppins',sans-serif;color:var(--dark-gray);line-height:1.5;display:flex;flex-direction:column;position:relative;overflow-x:hidden}
        .glass-navbar{width:100%;background:rgba(255,255,255,.98);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);padding:12px 20px;display:flex;justify-content:space-between;align-items:center;position:fixed;top:0;z-index:100;box-shadow:0 2px 20px rgba(0,0,0,.04);border-bottom:1px solid rgba(0,0,0,.03)}
        .nav-logo{display:flex;align-items:center;color:var(--primary-violet);font-weight:700;font-size:1.3rem;font-family:'Quicksand',sans-serif}
        .logo-img{width:35px;height:35px;margin-right:10px;object-fit:contain}
        .nav-logo::after{content:'';display:inline-block;width:6px;height:6px;background:var(--yellow);border-radius:50%;margin-left:6px;animation:pulse 2s infinite}
        @keyframes pulse{0%{transform:scale(1);opacity:1}50%{transform:scale(1.2);opacity:.7}100%{transform:scale(1);opacity:1}}
        .main-content{flex:1;display:flex;justify-content:center;align-items:center;padding:80px 20px 20px;width:100%}
        .login-container{background:rgba(255,255,255,.98);backdrop-filter:blur(15px);border-radius:20px;box-shadow:var(--card-shadow);width:100%;max-width:460px;padding:45px 40px;position:relative;overflow:hidden;opacity:0;transform:translateY(30px) scale(.95);animation:fadeInUp .8s ease forwards;border:1px solid rgba(0,0,0,.03);transition:all .4s ease}
        .login-container:hover{box-shadow:var(--hover-shadow);transform:translateY(-5px) scale(1)}
        @keyframes fadeInUp{to{opacity:1;transform:translateY(0) scale(1)}}
        .login-container::before{content:'';position:absolute;top:0;left:0;width:100%;height:6px;background:linear-gradient(90deg,var(--primary-violet),var(--yellow),var(--primary-violet));transform:scaleX(0);transform-origin:left;animation:expandLine 1.2s ease .5s forwards}
        @keyframes expandLine{to{transform:scaleX(1)}}
        .logo{text-align:center;margin-bottom:35px;opacity:0;animation:fadeIn 1s ease .3s forwards}
        @keyframes fadeIn{to{opacity:1}}
        .logo h1{color:var(--primary-violet);font-size:42px;font-weight:700;letter-spacing:1.5px;font-family:'Quicksand',sans-serif;margin-bottom:8px;position:relative;display:inline-block;text-shadow:2px 2px 4px rgba(138,43,226,.2)}
        .logo h1::after{content:'';position:absolute;bottom:-8px;left:10%;width:80%;height:3px;background:linear-gradient(90deg,transparent,var(--yellow),transparent);transform:scaleX(0);transform-origin:center;animation:expandLine 1s ease 1s forwards}
        .logo p{color:var(--text-gray);font-size:16px;margin-top:12px;letter-spacing:1.2px;font-weight:500}
        .pet-icons{display:flex;justify-content:center;gap:20px;margin-bottom:30px;opacity:0;animation:fadeIn 1s ease 1.6s forwards}
        .pet-icon{font-size:24px;color:var(--primary-violet);background:linear-gradient(135deg,var(--light-yellow),#fff);width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 15px rgba(138,43,226,.15);transition:all .4s ease;animation:bounceIn .6s ease forwards;opacity:0;transform:translateY(20px);cursor:pointer;position:relative;overflow:hidden}
        .pet-icon.active{background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));color:#fff;transform:translateY(-8px) scale(1.1);box-shadow:0 12px 20px rgba(138,43,226,.4)}
        .pet-icon:nth-child(1){animation-delay:1.8s}.pet-icon:nth-child(2){animation-delay:2s}.pet-icon:nth-child(3){animation-delay:2.2s}.pet-icon:nth-child(4){animation-delay:2.4s}
        @keyframes bounceIn{0%{opacity:0;transform:translateY(20px) scale(.8)}70%{transform:translateY(-5px) scale(1.05)}100%{opacity:1;transform:translateY(0) scale(1)}}
        .input-group{position:relative;margin-bottom:30px;opacity:0;transform:translateX(-30px);animation:slideInLeft .6s ease forwards}
        .input-group:nth-child(1){animation-delay:.6s}.input-group:nth-child(2){animation-delay:.8s}
        @keyframes slideInLeft{to{opacity:1;transform:translateX(0)}}
        .input-field{width:100%;padding:18px 50px 18px 20px;border:2px solid var(--medium-gray);border-radius:16px;font-size:16px;background-color:var(--light-gray);transition:all .4s ease;outline:none;font-family:'Poppins',sans-serif;letter-spacing:.5px;-webkit-appearance:none;box-shadow:inset 0 2px 4px rgba(0,0,0,.05)}
        .input-field:focus{border-color:var(--primary-violet);background-color:var(--soft-white);box-shadow:0 0 0 4px rgba(138,43,226,.15), inset 0 2px 4px rgba(0,0,0,.05);transform:translateY(-2px)}
        .input-label{position:absolute;top:18px;left:20px;font-size:16px;color:var(--text-gray);pointer-events:none;transition:all .4s ease;background-color:var(--light-gray);padding:0 8px;font-family:'Poppins',sans-serif;font-weight:500}
        .input-field:focus + .input-label,.input-field:not(:placeholder-shown) + .input-label{top:-10px;left:12px;font-size:13px;color:var(--primary-violet);background-color:var(--soft-white);font-weight:600}
        .password-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-gray);cursor:pointer;font-size:18px;transition:all .3s ease;padding:8px;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;z-index:10}
        .password-toggle:hover{color:var(--yellow);background-color:rgba(249,223,113,.1);transform:translateY(-50%) scale(1.1)}
        .login-btn{width:100%;padding:18px;background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));border:none;border-radius:16px;color:#fff;font-size:16px;font-weight:600;cursor:pointer;transition:all .4s ease;box-shadow:0 8px 20px rgba(138,43,226,.3);font-family:'Poppins',sans-serif;letter-spacing:1px;opacity:0;animation:fadeIn .8s ease 1s forwards;position:relative;overflow:hidden;-webkit-tap-highlight-color:transparent}
        .login-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.3),transparent);transition:left .5s}
        .login-btn:hover{transform:translateY(-5px);box-shadow:0 12px 25px rgba(138,43,226,.4);background:linear-gradient(135deg,var(--dark-violet),var(--primary-violet))}
        .login-btn:hover::before{left:100%}.login-btn:active{transform:translateY(0)}
        .options{display:flex;justify-content:space-between;margin:20px 0;font-size:14px;opacity:0;animation:fadeIn .8s ease 1.2s forwards}
        .remember-me{display:flex;align-items:center;color:var(--dark-gray);font-weight:500}
        .remember-me input{margin-right:8px;accent-color:var(--yellow);transform:scale(1.2)}
        .forgot-password{color:var(--primary-violet);text-decoration:none;transition:all .3s;font-weight:600;position:relative}
        .forgot-password::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:2px;background:linear-gradient(90deg,var(--primary-violet),var(--yellow));transition:width .3s ease}
        .forgot-password:hover{color:var(--dark-violet)}.forgot-password:hover::after{width:100%}
        .divider{text-align:center;margin:25px 0;position:relative;color:var(--text-gray);opacity:0;animation:fadeIn .8s ease 1.4s forwards;font-weight:500}
        .divider::before{content:'';position:absolute;top:50%;left:0;width:45%;height:1px;background:linear-gradient(90deg,transparent,var(--medium-gray))}
        .divider::after{content:'';position:absolute;top:50%;right:0;width:45%;height:1px;background:linear-gradient(90deg,var(--medium-gray),transparent)}
        .social-login{display:flex;justify-content:center;margin-bottom:25px;opacity:0;animation:fadeIn .8s ease 1.6s forwards}
        .social-btn{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--light-gray),#fff);color:var(--dark-gray);font-size:22px;transition:all .4s ease;cursor:pointer;position:relative;overflow:hidden;border:2px solid transparent;box-shadow:0 5px 15px rgba(0,0,0,.08)}
        .social-btn:hover{transform:translateY(-5px) scale(1.05);box-shadow:0 10px 20px rgba(0,0,0,.15);border-color:var(--yellow)}
        .google:hover{color:#db4437}
        .signup-link{text-align:center;color:var(--dark-gray);font-size:15px;opacity:0;animation:fadeIn .8s ease 1.8s forwards;margin-top:10px}
        .signup-link a{color:var(--primary-violet);text-decoration:none;font-weight:700;transition:all .3s;position:relative}
        .signup-link a:hover{color:var(--dark-violet)}
        .footer{background:#8259E2;padding:35px 20px 20px;text-align:center;color:#fff;position:relative;width:100%;margin-top:auto}
        .footer::before{content:'';position:absolute;top:0;left:0;width:100%;height:3px;background:var(--yellow)}
        .footer-content{max-width:800px;margin:0 auto}
        .footer-logo{font-size:1.6rem;font-weight:700;color:#fff;margin-bottom:15px;font-family:'Quicksand',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px}
        .footer-logo-img{width:30px;height:30px;object-fit:contain}
        .footer-links{display:flex;justify-content:center;list-style:none;margin:20px 0}
        .footer-links li{margin:0 15px;position:relative}
        .footer-links li:not(:last-child)::after{content:'';position:absolute;right:-15px;top:50%;transform:translateY(-50%);width:3px;height:3px;background:var(--yellow);border-radius:50%}
        .footer-links a{color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;font-weight:500;font-size:.9rem}
        .footer-links a:hover{color:var(--yellow);transform:translateY(-2px)}
        .copyright{margin-top:20px;font-size:.8rem;opacity:.8;color:rgba(255,255,255,.8)}
        .floating-pet{position:absolute;z-index:-1;opacity:.7;animation:floatAround 15s linear infinite}
        .floating-pet:nth-child(1){top:10%;left:5%;font-size:40px;color:var(--primary-violet);animation-delay:0s}
        .floating-pet:nth-child(2){top:70%;right:8%;font-size:35px;color:var(--yellow);animation-delay:3s}
        .floating-pet:nth-child(3){bottom:20%;left:15%;font-size:30px;color:var(--light-violet);animation-delay:6s}
        .floating-pet:nth-child(4){top:20%;right:15%;font-size:45px;color:var(--primary-violet);animation-delay:9s}
        @keyframes floatAround{0%{transform:translate(0,0) rotate(0)}25%{transform:translate(20px,-20px) rotate(5deg)}50%{transform:translate(0,-40px) rotate(0)}75%{transform:translate(-20px,-20px) rotate(-5deg)}100%{transform:translate(0,0) rotate(0)}}
        .particles{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:-1}
        .particle{position:absolute;border-radius:50%;animation:particleFloat 8s linear infinite}
        .yellow-particle{background-color:rgba(249,223,113,.6)}
        @keyframes particleFloat{0%{transform:translateY(100vh) rotate(0);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-100px) rotate(360deg);opacity:0}}
        .mobile-bottom-nav{display:none}
        /* ... keep your responsive sections exactly as you had them ... */
        html,body{max-width:100%;overflow-x:hidden}
        button,.password-toggle,.social-btn{min-height:44px;min-width:44px}
        .input-field:focus,.login-btn:focus,.password-toggle:focus,.social-btn:focus{outline:2px solid var(--primary-violet);outline-offset:2px}
        input[type="password"]::-webkit-credentials-auto-fill-button{display:none!important;visibility:hidden!important;pointer-events:none!important;position:absolute!important;right:0!important}
        input[type="password"]::-moz-reveal{display:none!important}
        input[type="password"]::-ms-reveal{display:none!important}
        /* error text */
        .field-error{color:#c0392b;font-size:.85rem;margin-top:.5rem}
    </style>
</head>
<body>
    <nav class="glass-navbar">
        <div class="nav-logo">
            <img src="{{ asset('images/pawsitive-logo.jpg') }}" alt="Pawsitive Vibes Logo" class="logo-img">
            <span>Pawsitive Vibes</span>
        </div>
    </nav>


    <div class="floating-pet"><i class="fas fa-paw"></i></div>
    <div class="floating-pet"><i class="fas fa-dog"></i></div>
    <div class="floating-pet"><i class="fas fa-cat"></i></div>
    <div class="floating-pet"><i class="fas fa-bone"></i></div>
    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="login-container">
            <div class="logo">
                <h1>Pawsitive Vibes</h1>
                <p>Your Pet's Happy Place</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="pet-icons" aria-hidden="true">
                <div class="pet-icon" data-pet="paw"><i class="fas fa-paw"></i></div>
                <div class="pet-icon" data-pet="dog"><i class="fas fa-dog"></i></div>
                <div class="pet-icon" data-pet="cat"><i class="fas fa-cat"></i></div>
                <div class="pet-icon" data-pet="bone"><i class="fas fa-bone"></i></div>
            </div>

            <form method="POST" id="loginForm" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <input
                        type="text"
                        id="email"
                        name="username"
                        class="input-field @error('username') is-invalid @enderror"
                        placeholder=" "
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                        autofocus
                    >
                    <label for="username" class="input-label">Username</label>
                    @error('username')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="input-field @error('password') is-invalid @enderror"
                        placeholder=" "
                        required
                        autocomplete="current-password"
                    >
                    <label for="password" class="input-label">Password</label>
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                        <i class="far fa-eye"></i>
                    </button>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="options">
                    <label class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember"> Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="divider">or continue with</div>

            <div class="social-login">
                <a href="{{ route('auth.google.redirect') }}"
                class="social-btn google" aria-label="Continue with Google">
                    <i class="fab fa-google"></i>
                </a>
            </div>


            <div class="signup-link">
                Don’t have an account?
                @if(Route::has('register'))
                    <a href="{{ route('register') }}">Sign up now</a>
                @else
                    <a href="#">Sign up now</a>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Pawsitive Vibes Logo" class="footer-logo-img">
                <span>Pawsitive Vibes</span>
            </div>
            <ul class="footer-links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Shipping Policy</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
            <p class="copyright">© {{ now()->year }} Pawsitive Vibes. All rights reserved.</p>
        </div>
    </div>

    <div class="mobile-bottom-nav" aria-label="Bottom navigation">
        <a href="{{ url('/') }}" class="mobile-nav-item">
            <i class="fas fa-home"></i><span>Home</span>
        </a>
        <a href="#" class="mobile-nav-item">
            <i class="fas fa-heart"></i><span>Favorites</span>
        </a>
        <a href="#" class="mobile-nav-item">
            <i class="fas fa-hand-holding-usd"></i><span>Donate</span>
        </a>
        <a href="#" class="mobile-nav-item">
            <i class="fas fa-shopping-cart"></i><span>Cart</span>
        </a>
        <a href="#" class="mobile-nav-item active">
            <i class="fas fa-user"></i><span>Profile</span>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const petIcons = document.querySelectorAll('.pet-icon');

            createParticles();

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const eyeIcon = this.querySelector('i');
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });

            petIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });

            document.querySelectorAll('.input-field').forEach(field => {
                field.addEventListener('focus', function() {
                    this.parentNode.classList.add('focused');
                });
                field.addEventListener('blur', function() {
                    if (!this.value) this.parentNode.classList.remove('focused');
                });
            });

            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = window.innerWidth < 480 ? 15 : 25;

                for (let i = 0; i < particleCount; i++) {
                    const p = document.createElement('div');
                    p.classList.add('particle');
                    if (Math.random() > 0.7) {
                        p.classList.add('yellow-particle');
                        p.style.width = '6px'; p.style.height = '6px';
                        p.style.backgroundColor = 'rgba(249, 223, 113, 0.6)';
                    } else {
                        p.style.width = '4px'; p.style.height = '4px';
                        p.style.backgroundColor = 'rgba(138, 43, 226, 0.4)';
                    }
                    p.style.left = `${Math.random() * 100}%`;
                    p.style.animationDuration = `${Math.random() * 10 + 5}s`;
                    p.style.animationDelay = `${Math.random() * 5}s`;
                    particlesContainer.appendChild(p);
                }
            }

            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    20%, 60% { transform: translateX(-8px); }
                    40%, 80% { transform: translateX(8px); }
                }
            `;
            document.head.appendChild(style);

        });
    </script>
</body>
</html>

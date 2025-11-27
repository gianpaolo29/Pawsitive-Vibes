<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsitive Vibes | Pet Shop Sign Up</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{--primary-violet:#8a2be2;--light-violet:#b19cd9;--dark-violet:#6a0dad;--violet-blue:#6c63ff;--light-violet-blue:#a5a1ff;--dark-violet-blue:#5651d4;--vibrant-violet:#7b68ee;--bright-violet:#9370db;--yellow:#F9DF71;--light-yellow:#fff9e6;--soft-white:#fefefe;--light-gray:#f8f7ff;--medium-gray:#e0ddf5;--text-gray:#666;--dark-gray:#444;--error-red:#e74c3c;--success-green:#2ecc71;--card-shadow:0 5px 15px rgba(138,43,226,.08);--hover-shadow:0 8px 25px rgba(138,43,226,.15)}
        body{background:#ffffff;min-height:100vh;font-family:'Poppins',sans-serif;color:var(--dark-gray);line-height:1.5;display:flex;flex-direction:column;position:relative;overflow-x:hidden}
        .glass-navbar{width:100%;background:rgba(255,255,255,.98);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);padding:12px 20px;display:flex;justify-content:space-between;align-items:center;position:fixed;top:0;z-index:100;box-shadow:0 2px 20px rgba(0,0,0,.04);border-bottom:1px solid rgba(0,0,0,.03)}
        .nav-logo{display:flex;align-items:center;color:var(--primary-violet);font-weight:700;font-size:1.3rem;font-family:'Quicksand',sans-serif}
        .logo-img{width:35px;height:35px;margin-right:10px;object-fit:contain}
        .nav-logo::after{content:'';display:inline-block;width:6px;height:6px;background:var(--yellow);border-radius:50%;margin-left:6px;animation:pulse 2s infinite}
        @keyframes pulse{0%{transform:scale(1);opacity:1}50%{transform:scale(1.2);opacity:.7}100%{transform:scale(1);opacity:1}}
        .main-content{flex:1;display:flex;justify-content:center;align-items:center;padding:80px 20px 20px;width:100%}
        .signup-container{background:rgba(255,255,255,.98);backdrop-filter:blur(15px);border-radius:20px;box-shadow:var(--card-shadow);width:100%;max-width:460px;padding:45px 40px;position:relative;overflow:hidden;opacity:0;transform:translateY(30px) scale(.95);animation:fadeInUp .8s ease forwards;border:1px solid rgba(0,0,0,.03);transition:all .4s ease}
        .signup-container:hover{box-shadow:var(--hover-shadow);transform:translateY(-5px) scale(1)}
        @keyframes fadeInUp{to{opacity:1;transform:translateY(0) scale(1)}}
        .signup-container::before{content:'';position:absolute;top:0;left:0;width:100%;height:6px;background:linear-gradient(90deg,var(--primary-violet),var(--yellow),var(--primary-violet));transform:scaleX(0);transform-origin:left;animation:expandLine 1.2s ease .5s forwards}
        @keyframes expandLine{to{transform:scaleX(1)}}
        .logo{text-align:center;margin-bottom:30px;opacity:0;animation:fadeIn 1s ease .3s forwards}
        @keyframes fadeIn{to{opacity:1}}
        .logo h1{color:var(--primary-violet);font-size:42px;font-weight:700;letter-spacing:1.5px;font-family:'Quicksand',sans-serif;margin-bottom:8px;position:relative;display:inline-block;text-shadow:2px 2px 4px rgba(138,43,226,.2)}
        .logo h1::after{content:'';position:absolute;bottom:-8px;left:10%;width:80%;height:3px;background:linear-gradient(90deg,transparent,var(--yellow),transparent);transform:scaleX(0);transform-origin:center;animation:expandLine 1s ease 1s forwards}
        .logo p{color:var(--text-gray);font-size:16px;margin-top:12px;letter-spacing:1.2px;font-weight:500}
        .pet-icons{display:flex;justify-content:center;gap:20px;margin-bottom:30px;opacity:0;animation:fadeIn 1s ease 1.6s forwards}
        .pet-icon{font-size:24px;color:var(--primary-violet);background:linear-gradient(135deg,var(--light-yellow),#fff);width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 15px rgba(138,43,226,.15);transition:all .4s ease;animation:bounceIn .6s ease forwards;opacity:0;transform:translateY(20px);cursor:pointer;position:relative;overflow:hidden}
        .pet-icon.active{background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));color:white;transform:translateY(-8px) scale(1.1);box-shadow:0 12px 20px rgba(138,43,226,.4)}
        .pet-icon:nth-child(1){animation-delay:1.8s}.pet-icon:nth-child(2){animation-delay:2s}.pet-icon:nth-child(3){animation-delay:2.2s}.pet-icon:nth-child(4){animation-delay:2.4s}
        @keyframes bounceIn{0%{opacity:0;transform:translateY(20px) scale(.8)}70%{transform:translateY(-5px) scale(1.05)}100%{opacity:1;transform:translateY(0) scale(1)}
        }
        .name-group{display:flex;gap:15px;margin-bottom:25px}
        .input-group{position:relative;margin-bottom:25px;opacity:0;transform:translateX(-30px);animation:slideInLeft .6s ease forwards}
        .input-group:nth-child(1){animation-delay:.6s}.input-group:nth-child(2){animation-delay:.7s}.input-group:nth-child(3){animation-delay:.8s}.input-group:nth-child(4){animation-delay:.9s}.input-group:nth-child(5){animation-delay:1s}
        @keyframes slideInLeft{to{opacity:1;transform:translateX(0)}}
        .input-field{width:100%;padding:16px 45px 16px 20px;border:2px solid var(--medium-gray);border-radius:16px;font-size:16px;background-color:var(--light-gray);transition:all .4s ease;outline:none;font-family:'Poppins',sans-serif;letter-spacing:.5px;-webkit-appearance:none;box-shadow:inset 0 2px 4px rgba(0,0,0,.05)}
        .input-field:focus{border-color:var(--primary-violet);background-color:var(--soft-white);box-shadow:0 0 0 4px rgba(138,43,226,.15), inset 0 2px 4px rgba(0,0,0,.05);transform:translateY(-2px)}
        .input-field.error{border-color:var(--error-red);background-color:rgba(231,76,60,.05)}
        .input-label{position:absolute;top:16px;left:20px;font-size:16px;color:var(--text-gray);pointer-events:none;transition:all .4s ease;background-color:var(--light-gray);padding:0 8px;font-family:'Poppins',sans-serif;font-weight:500}
        .input-field:focus + .input-label,.input-field:not(:placeholder-shown) + .input-label{top:-10px;left:12px;font-size:13px;color:var(--primary-violet);background-color:var(--soft-white);font-weight:600}
        .error-message{color:var(--error-red);font-size:13px;margin-top:8px;display:flex;align-items:center;gap:5px;opacity:0;height:0;transition:all .3s ease}
        .error-message.show{opacity:1;height:auto}
        .password-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-gray);cursor:pointer;font-size:18px;transition:all .3s ease;padding:8px;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center}
        .password-toggle:hover{color:var(--yellow);background-color:rgba(249,223,113,.1);transform:translateY(-50%) scale(1.1)}
        .password-requirements{margin-top:10px;padding:15px;background-color:rgba(245,245,245,.7);border-radius:12px;font-size:13px;border-left:3px solid var(--primary-violet)}
        .requirement{display:flex;align-items:center;margin-bottom:8px;color:var(--text-gray);transition:color .3s ease}
        .requirement.valid{color:var(--success-green)}.requirement.invalid{color:var(--error-red)}
        .requirement i{margin-right:8px;font-size:12px;min-width:12px}
        .password-strength{margin-top:10px;font-size:13px;font-weight:500;transition:color .3s ease}
        .password-strength.weak{color:var(--error-red)}.password-strength.medium{color:#f39c12}.password-strength.strong{color:var(--success-green)}
        .signup-btn{width:100%;padding:18px;background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));border:none;border-radius:16px;color:white;font-size:16px;font-weight:600;cursor:pointer;transition:all .4s ease;box-shadow:0 8px 20px rgba(138,43,226,.3);font-family:'Poppins',sans-serif;letter-spacing:1px;opacity:0;animation:fadeIn .8s ease 1.2s forwards;position:relative;overflow:hidden;margin-top:10px;-webkit-tap-highlight-color:transparent}
        .signup-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.3),transparent);transition:left .5s}
        .signup-btn:hover{transform:translateY(-5px);box-shadow:0 12px 25px rgba(138,43,226,.4);background:linear-gradient(135deg,var(--dark-violet),var(--primary-violet))}
        .signup-btn:hover::before{left:100%}.signup-btn:active{transform:translateY(0)}
        .login-link{text-align:center;color:var(--dark-gray);font-size:15px;margin-top:25px;opacity:0;animation:fadeIn .8s ease 1.4s forwards}
        .login-link a{color:var(--primary-violet);text-decoration:none;font-weight:700;transition:all .3s;position:relative}
        .login-link a::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:2px;background:linear-gradient(90deg,var(--primary-violet),var(--yellow));transition:width .3s ease}
        .login-link a:hover{color:var(--dark-violet)}.login-link a:hover::after{width:100%}
        .footer{background:#8259E2;padding:35px 20px 20px;text-align:center;color:white;position:relative;width:100%;margin-top:auto}
        .footer::before{content:'';position:absolute;top:0;left:0;width:100%;height:3px;background:var(--yellow)}
        .footer-content{max-width:800px;margin:0 auto}
        .footer-logo{font-size:1.6rem;font-weight:700;color:white;margin-bottom:15px;font-family:'Quicksand',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px}
        .footer-logo-img{width:30px;height:30px;object-fit:contain}
        .particles{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:-1}
        .particle{position:absolute;border-radius:50%;animation:particleFloat 8s linear infinite}
        .yellow-particle{background-color:rgba(249,223,113,.6)}
        @keyframes particleFloat{0%{transform:translateY(100vh) rotate(0);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-100px) rotate(360deg);opacity:0}}
        .mobile-bottom-nav{display:none}
        @media (max-width:768px){body{padding-bottom:70px}.main-content{padding:80px 15px 15px}.signup-container{padding:30px 25px;border-radius:20px;max-width:100%}.logo{margin-bottom:25px}.logo h1{font-size:34px}.logo p{font-size:14px;margin-top:10px}.pet-icons{gap:15px;margin-bottom:25px}.pet-icon{width:50px;height:50px;font-size:20px}.name-group{flex-direction:column;gap:0;margin-bottom:20px}.input-group{margin-bottom:20px}.input-field{padding:16px 45px 16px 16px;font-size:16px;border-radius:14px}.input-label{font-size:15px;top:16px;left:16px}.input-field:focus + .input-label,.input-field:not(:placeholder-shown) + .input-label{font-size:12px;left:12px;top:-9px}.password-toggle{padding:6px;width:36px;height:36px;font-size:16px;right:10px}.password-requirements{padding:12px;font-size:12px;margin-top:8px}.requirement{font-size:11px;margin-bottom:6px}.requirement i{font-size:11px;margin-right:6px}.password-strength{font-size:12px;margin-top:8px}.signup-btn{padding:16px;font-size:16px;border-radius:14px;margin-top:8px}.login-link{font-size:14px;margin-top:20px}.floating-pet{display:none}.mobile-bottom-nav{position:fixed;bottom:0;left:0;width:100%;background:rgba(255,255,255,.98);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px);display:flex;justify-content:space-around;padding:10px 0;box-shadow:0 -2px 20px rgba(0,0,0,.08);border-top:1px solid rgba(0,0,0,.05);z-index:1000}.mobile-nav-item{display:flex;flex-direction:column;align-items:center;text-decoration:none;color:var(--dark-gray);font-size:.7rem;padding:5px 10px;border-radius:10px;transition:all .3s ease}.mobile-nav-item i{font-size:1.2rem;margin-bottom:3px;transition:all .3s ease}.mobile-nav-item.active{color:var(--primary-violet);background:rgba(138,43,226,.08)}.mobile-nav-item.active i{color:var(--primary-violet)}.mobile-nav-item:hover{color:var(--primary-violet)}}
        @media (max-width:480px){.signup-container{padding:25px 20px}.logo h1{font-size:30px}.logo p{font-size:13px}.pet-icons{gap:10px}.pet-icon{width:45px;height:45px;font-size:18px}.input-field{padding:14px 40px 14px 14px}.password-requirements{padding:10px}.requirement{font-size:10px}}
        @media (max-height:600px) and (orientation:landscape){body{align-items:flex-start}.main-content{padding:80px 10px 10px}.signup-container{margin:5px 0;max-height:95vh;overflow-y:auto}.logo{margin-bottom:20px}.pet-icons{margin-bottom:20px}.input-group{margin-bottom:15px}.password-requirements{padding:8px}}
        html,body{max-width:100%;overflow-x:hidden}
        button,.password-toggle{min-height:44px;min-width:44px}
        .input-field:focus,.signup-btn:focus,.password-toggle:focus{outline:2px solid var(--primary-violet);outline-offset:2px}
        input[type="password"]::-webkit-credentials-auto-fill-button{display:none!important;visibility:hidden!important;pointer-events:none!important;position:absolute!important;right:0!important}
        input[type="password"]::-moz-reveal{display:none!important}
        input[type="password"]::-ms-reveal{display:none!important}
    </style>
</head>
<body>
   
    <nav class="glass-navbar">
        <div class="nav-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Pawsitive Vibes Logo" class="logo-img">
            <span>Pawsitive Vibes</span>
        </div>
    </nav>

    <div class="floating-pet"><i class="fas fa-paw"></i></div>
    <div class="floating-pet"><i class="fas fa-dog"></i></div>
    <div class="floating-pet"><i class="fas fa-cat"></i></div>
    <div class="floating-pet"><i class="fas fa-bone"></i></div>
    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="signup-container">
            <div class="logo">
                <h1>Pawsitive Vibes</h1>
                <p>Your Pet's Happy Place</p>
            </div>

            <div class="pet-icons">
                <div class="pet-icon" data-pet="paw"><i class="fas fa-paw"></i></div>
                <div class="pet-icon" data-pet="dog"><i class="fas fa-dog"></i></div>
                <div class="pet-icon" data-pet="cat"><i class="fas fa-cat"></i></div>
                <div class="pet-icon" data-pet="bone"><i class="fas fa-bone"></i></div>
            </div>

    

            <form id="signupForm" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Hidden field for Breeze/Fortify 'name' -->
                <input type="hidden" id="name" name="name" value="{{ old('name') }}"/>

                <div class="name-group">
                    <div class="input-group" style="flex:1;">
                        <input type="text" id="first_name" name="first_name"
                               class="input-field @error('first_name') error @enderror"
                               placeholder=" " value="{{ old('first_name') }}" required>
                        <label for="first_name" class="input-label">First Name</label>
                        @error('first_name') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group" style="flex:1;">
                        <input type="text" id="last_name" name="last_name"
                               class="input-field @error('last_name') error @enderror"
                               placeholder=" " value="{{ old('last_name') }}" required>
                        <label for="last_name" class="input-label">Last Name</label>
                        @error('last_name') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="input-group">
                    <input type="text" id="username" name="username"
                           class="input-field @error('username') error @enderror"
                           placeholder=" " value="{{ old('username') }}" required autocomplete="username">
                    <label for="username" class="input-label">Username</label>
                    @error('username') <div class="error-message show">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <input type="email" id="email" name="email"
                           class="input-field @error('email') error @enderror"
                           placeholder=" " value="{{ old('email') }}" required autocomplete="email">
                    <label for="email" class="input-label">Email</label>
                    @error('email') <div class="error-message show">{{ $message }}</div> @enderror
                </div>

                <!-- Password -->
                <div class="input-group" style="margin-bottom:16px">
                <input type="password" id="password" name="password"
                        class="input-field @error('password') error @enderror"
                        placeholder=" " required autocomplete="new-password">
                <label for="password" class="input-label">Password</label>

                <!-- eye button -->
                <button type="button" class="password-toggle" id="togglePassword">
                    <i class="far fa-eye"></i>
                </button>

                @error('password') 
                    <div class="error-message show">{{ $message }}</div>
                @enderror

                <div class="password-requirements">
                    <div class="requirement" id="length-req">
                    <i class="far fa-circle"></i><span>Minimum 8 characters</span>
                    </div>
                    <div class="requirement" id="symbol-req">
                    <i class="far fa-circle"></i><span>Contains a symbol or number</span>
                    </div>
                    <div class="requirement" id="unique-req">
                    <i class="far fa-circle"></i><span>Not similar to your name or username</span>
                    </div>
                </div>

                <div class="password-strength" id="password-strength">
                    Please choose a stronger password.
                </div>
                </div>


                <!-- Confirm Password -->
                <div class="input-group">
                <input type="password" id="confirmPassword" name="password_confirmation"
                        class="input-field @error('password_confirmation') error @enderror"
                        placeholder=" " required autocomplete="new-password">
                <label for="confirmPassword" class="input-label">Confirm Password</label>

                <!-- eye button -->
                <button type="button" class="password-toggle" id="toggleConfirmPassword">
                    <i class="far fa-eye"></i>
                </button>

                @error('password_confirmation') 
                    <div class="error-message show">{{ $message }}</div>
                @enderror

                <div class="error-message" id="confirm-password-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Password mismatch.</span>
                </div>
                </div>


                <button type="submit" class="signup-btn" id="submitBtn">Create Account</button>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Log in now</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const form      = document.getElementById('signupForm');
        const submitBtn = document.getElementById('submitBtn');

        const firstEl = document.getElementById('first_name');
        const lastEl  = document.getElementById('last_name');
        const nameEl  = document.getElementById('name');
        const userEl  = document.getElementById('username');
        const passEl  = document.getElementById('password');
        const pass2El = document.getElementById('confirmPassword'); // ✅ correct id

        const lengthReq  = document.getElementById('length-req');
        const symbolReq  = document.getElementById('symbol-req');
        const uniqueReq  = document.getElementById('unique-req');
        const strengthEl = document.getElementById('password-strength');
        const confirmErr = document.getElementById('confirm-password-error');

        // Eye toggles
        const togglePassword        = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

        function wireToggle(btn, input) {
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
            const isHidden = input.getAttribute('type') === 'password';
            input.setAttribute('type', isHidden ? 'text' : 'password');
            const icon = this.querySelector('i');
            if (!icon) return;
            icon.classList.toggle('fa-eye', !isHidden);
            icon.classList.toggle('fa-eye-slash', isHidden);
            });
        }
        wireToggle(togglePassword, passEl);
        wireToggle(toggleConfirmPassword, pass2El);

        function updateFullName() {
            const first = (firstEl?.value || '').trim();
            const last  = (lastEl?.value || '').trim();
            if (nameEl) nameEl.value = [first, last].filter(Boolean).join(' ');
        }

        function setReq(el, ok) {
            if (!el) return;
            el.classList.toggle('valid', ok);
            el.classList.toggle('invalid', !ok);
            const icon = el.querySelector('i');
            if (icon) icon.className = ok ? 'fas fa-check-circle' : 'fas fa-times-circle';
        }

        function evaluatePassword() {
            const pwd   = passEl?.value || '';
            const first = (firstEl?.value || '').toLowerCase();
            const last  = (lastEl?.value || '').toLowerCase();
            const uname = (userEl?.value || '').toLowerCase();

            const hasLen    = pwd.length >= 8;
            const hasSymbol = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(pwd);
            const hasNum    = /\d/.test(pwd);
            const similar   = !!pwd && (
            (first && pwd.toLowerCase().includes(first)) ||
            (last  && pwd.toLowerCase().includes(last))  ||
            (uname && pwd.toLowerCase().includes(uname))
            );

            setReq(lengthReq, hasLen);
            setReq(symbolReq, hasSymbol || hasNum);
            setReq(uniqueReq, !similar);

            if (!strengthEl) return;
            if (!pwd) {
            strengthEl.textContent = 'Please choose a stronger password.';
            strengthEl.className = 'password-strength';
            } else if (!hasLen || !(hasSymbol || hasNum) || similar) {
            strengthEl.textContent = 'Weak password';
            strengthEl.className = 'password-strength weak';
            } else if (pwd.length >= 10 && hasSymbol && hasNum && !similar) {
            strengthEl.textContent = 'Strong password';
            strengthEl.className = 'password-strength strong';
            } else {
            strengthEl.textContent = 'Medium password';
            strengthEl.className = 'password-strength medium';
            }

            checkMatch(); // keep live sync with confirm field
        }

        function checkMatch() {
            if (!pass2El || !confirmErr) return true;
            const mismatch = !!pass2El.value && passEl.value !== pass2El.value;
            confirmErr.classList.toggle('show', mismatch);
            pass2El.classList.toggle('error', mismatch);
            return !mismatch;
        }

        // Bind events (with guards)
        [passEl, firstEl, lastEl, userEl].forEach(el => {
            if (!el) return;
            el.addEventListener('input', evaluatePassword);
            el.addEventListener('blur', evaluatePassword);
        });

        if (pass2El) {
            pass2El.addEventListener('input', checkMatch);
            pass2El.addEventListener('blur', checkMatch);
        }

        // Submit
        if (form) {
            form.addEventListener('submit', function (e) {
            updateFullName();
            evaluatePassword();
            const ok = checkMatch();
            if (!ok) {
                e.preventDefault();
                pass2El && pass2El.focus();
                return;
            }
            submitBtn && (submitBtn.disabled = true);
            submitBtn && (submitBtn.style.opacity = '0.8');
            });
        }

        // Decorative particles (kept)
        const particlesContainer = document.getElementById('particles');
        if (particlesContainer) {
            const count = window.innerWidth < 480 ? 15 : 25;
            for (let i = 0; i < count; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            if (Math.random() > 0.7) {
                p.classList.add('yellow-particle');
                p.style.width = '6px'; p.style.height = '6px';
                p.style.backgroundColor = 'rgba(249,223,113,0.6)';
            } else {
                p.style.width = '4px'; p.style.height = '4px';
                p.style.backgroundColor = 'rgba(138,43,226,0.4)';
            }
            p.style.left = (Math.random() * 100) + '%';
            p.style.animationDuration = (Math.random() * 10 + 5) + 's';
            p.style.animationDelay = (Math.random() * 5) + 's';
            particlesContainer.appendChild(p);
            }
        }
        });
        </script>


</body>
</html>

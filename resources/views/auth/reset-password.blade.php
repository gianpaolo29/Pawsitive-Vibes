<x-guest-layout>
    <style>
        * { margin:0; padding:0; box-sizing:border-box }
        :root {
            --primary-violet:#8a2be2;--light-violet:#b19cd9;--dark-violet:#6a0dad;
            --violet-blue:#6c63ff;--light-violet-blue:#a5a1ff;--dark-violet-blue:#5651d4;
            --vibrant-violet:#7b68ee;--bright-violet:#9370db;--yellow:#F9DF71;--light-yellow:#fff9e6;
            --soft-white:#fefefe;--light-gray:#f8f7ff;--medium-gray:#e0ddf5;--text-gray:#666;--dark-gray:#444;
            --card-shadow:0 5px 15px rgba(138,43,226,.08);--hover-shadow:0 8px 25px rgba(138,43,226,.15)
        }
        body {
            background: linear-gradient(135deg, #f8f7ff 0%, #fff9e6 50%, #f0ebff 100%);
            min-height:100vh;
            font-family:'Poppins',sans-serif;
            color:var(--dark-gray);
            line-height:1.5;
            display:flex;
            flex-direction:column;
            position:relative;
            overflow-x:hidden
        }

        .glass-navbar {
            width:100%;
            background:rgba(255,255,255,.98);
            backdrop-filter:blur(15px);
            -webkit-backdrop-filter:blur(15px);
            padding:12px 20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            position:fixed;
            top:0;
            z-index:100;
            box-shadow:0 2px 20px rgba(0,0,0,.04);
            border-bottom:1px solid rgba(0,0,0,.03)
        }
        .nav-logo {
            display:flex;
            align-items:center;
            color:var(--primary-violet);
            font-weight:700;
            font-size:1.3rem;
            font-family:'Quicksand',sans-serif
        }
        .logo-img {
            width:35px;
            height:35px;
            margin-right:10px;
            object-fit:contain
        }
        .nav-logo::after {
            content:'';
            display:inline-block;
            width:6px;
            height:6px;
            background:var(--yellow);
            border-radius:50%;
            margin-left:6px;
            animation:pulse 2s infinite
        }
        @keyframes pulse {
            0% { transform:scale(1); opacity:1 }
            50% { transform:scale(1.2); opacity:.7 }
            100% { transform:scale(1); opacity:1 }
        }

        .main-content {
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:80px 20px 20px;
            width:100%
        }

        .login-container {
            background:rgba(255,255,255,.95);
            backdrop-filter:blur(20px);
            border-radius:24px;
            box-shadow:var(--card-shadow), 0 0 0 1px rgba(255,255,255,0.8);
            width:100%;
            max-width:460px;
            padding:50px 40px;
            position:relative;
            overflow:hidden;
            opacity:0;
            transform:translateY(30px) scale(.95);
            animation:fadeInUp .8s ease forwards;
            border:1px solid rgba(255,255,255,0.5);
            transition:all .4s ease
        }
        .login-container:hover {
            box-shadow:var(--hover-shadow), 0 0 0 1px rgba(255,255,255,0.9);
            transform:translateY(-5px)
        }
        @keyframes fadeInUp {
            to {
                opacity:1;
                transform:translateY(0) scale(1)
            }
        }
        .login-container::before {
            content:'';
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:6px;
            background:linear-gradient(90deg,var(--primary-violet),var(--yellow),var(--primary-violet));
            transform:scaleX(0);
            transform-origin:left;
            animation:expandLine 1.2s ease .5s forwards
        }
        @keyframes expandLine {
            to {
                transform:scaleX(1)
            }
        }

        .logo {
            text-align:center;
            margin-bottom:35px;
            opacity:0;
            animation:fadeIn 1s ease .3s forwards
        }
        @keyframes fadeIn {
            to {
                opacity:1
            }
        }
        .logo h1 {
            color:var(--primary-violet);
            font-size:32px;
            font-weight:700;
            letter-spacing:1.5px;
            font-family:'Quicksand',sans-serif;
            margin-bottom:8px;
            position:relative;
            display:inline-block;
            text-shadow:2px 2px 4px rgba(138,43,226,.2)
        }
        .logo p {
            color:var(--text-gray);
            font-size:14px;
            margin-top:5px;
            letter-spacing:1px;
            font-weight:500
        }

        .field-error {
            color:#c0392b;
            font-size:.85rem;
            margin-top:.5rem;
            padding:8px 12px;
            background:rgba(192,57,43,0.1);
            border-radius:8px;
            border-left:3px solid #c0392b
        }

        .reset-text {
            color: var(--text-gray);
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
            opacity: 0;
            animation: fadeIn 0.8s ease 0.6s forwards;
            text-align: center;
            background: rgba(138,43,226,0.05);
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid var(--primary-violet)
        }

        .input-group {
            position:relative;
            margin-bottom:25px;
            opacity:0;
            transform:translateX(-30px);
            animation:slideInLeft .6s ease forwards
        }
        .input-group:nth-child(1){ animation-delay:.6s }
        .input-group:nth-child(2){ animation-delay:.8s }
        .input-group:nth-child(3){ animation-delay:1s }
        @keyframes slideInLeft {
            to {
                opacity:1;
                transform:translateX(0)
            }
        }

        .input-field {
            width:100%;
            padding:18px 50px 18px 20px;
            border:2px solid var(--medium-gray);
            border-radius:16px;
            font-size:16px;
            background-color:var(--light-gray);
            transition:all .4s ease;
            outline:none;
            font-family:'Poppins',sans-serif;
            letter-spacing:.5px;
            -webkit-appearance:none;
            box-shadow:inset 0 2px 4px rgba(0,0,0,.05)
        }
        .input-field:focus {
            border-color:var(--primary-violet);
            background-color:var(--soft-white);
            box-shadow:0 0 0 4px rgba(138,43,226,.15), inset 0 2px 4px rgba(0,0,0,.05);
            transform:translateY(-2px)
        }

        .input-label {
            position:absolute;
            top:18px;
            left:20px;
            font-size:16px;
            color:var(--text-gray);
            pointer-events:none;
            transition:all .4s ease;
            background-color:var(--light-gray);
            padding:0 8px;
            font-family:'Poppins',sans-serif;
            font-weight:500
        }
        .input-field:focus + .input-label,
        .input-field:not(:placeholder-shown) + .input-label {
            top:-10px;
            left:12px;
            font-size:13px;
            color:var(--primary-violet);
            background-color:var(--soft-white);
            font-weight:600
        }

        .password-toggle {
            position:absolute;
            right:12px;
            top:50%;
            transform:translateY(-50%);
            background:none;
            border:none;
            color:var(--text-gray);
            cursor:pointer;
            font-size:18px;
            transition:all .3s ease;
            padding:8px;
            border-radius:50%;
            width:40px;
            height:40px;
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:10
        }
        .password-toggle:hover {
            color:var(--yellow);
            background-color:rgba(249,223,113,.1);
            transform:translateY(-50%) scale(1.1)
        }

        /* Password Strength */
        .password-requirements {
            margin-top: 10px;
            padding: 12px;
            background: rgba(138,43,226,0.03);
            border-radius: 10px;
        }
        .requirement {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-gray);
            padding: 3px 0;
            transition: all 0.3s ease;
        }
        .requirement i {
            font-size: 14px;
            width: 16px;
            text-align: center;
        }
        .requirement.valid {
            color: #10b981;
        }
        .requirement.valid i {
            color: #10b981;
        }
        .requirement.invalid {
            color: #ef4444;
        }
        .requirement.invalid i {
            color: #ef4444;
        }
        .password-strength {
            font-size: 13px;
            font-weight: 600;
            margin-top: 8px;
            padding: 6px 12px;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .password-strength.weak {
            color: #ef4444;
            background: rgba(239,68,68,0.1);
        }
        .password-strength.medium {
            color: #f59e0b;
            background: rgba(245,158,11,0.1);
        }
        .password-strength.strong {
            color: #10b981;
            background: rgba(16,185,129,0.1);
        }
        .confirm-error {
            display: none;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #ef4444;
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(239,68,68,0.08);
            border-radius: 8px;
        }
        .confirm-error.show {
            display: flex;
        }

        .login-btn {
            width:100%;
            padding:18px;
            background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));
            border:none;
            border-radius:16px;
            color:#fff;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:all .4s ease;
            box-shadow:0 8px 20px rgba(138,43,226,.3);
            font-family:'Poppins',sans-serif;
            letter-spacing:1px;
            opacity:0;
            animation:fadeIn .8s ease 1.2s forwards;
            position:relative;
            overflow:hidden;
            -webkit-tap-highlight-color:transparent
        }
        .login-btn::before {
            content:'';
            position:absolute;
            top:0;
            left:-100%;
            width:100%;
            height:100%;
            background:linear-gradient(90deg,transparent,rgba(255,255,255,.3),transparent);
            transition:left .5s
        }
        .login-btn:hover {
            transform:translateY(-5px);
            box-shadow:0 12px 25px rgba(138,43,226,.4);
            background:linear-gradient(135deg,var(--dark-violet),var(--primary-violet))
        }
        .login-btn:hover::before {
            left:100%
        }
        .login-btn:active {
            transform:translateY(0)
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
            opacity: 0;
            animation: fadeIn 0.8s ease 1.4s forwards;
        }

        .forgot-password {
            color: var(--primary-violet);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 12px;
            background: rgba(138,43,226,0.05);
        }

        .forgot-password:hover {
            color: var(--dark-violet);
            background: rgba(138,43,226,0.1);
            transform: translateX(-4px);
        }

        .floating-pet {
            position:absolute;
            z-index:-1;
            opacity:.7;
            animation:floatAround 15s linear infinite;
            font-size: 0;
        }
        .floating-pet::before {
            font-size: 40px;
        }
        .floating-pet:nth-child(1){
            top:10%;
            left:5%;
            animation-delay:0s
        }
        .floating-pet:nth-child(1)::before {
            content: '\1F43E';
            color: var(--primary-violet);
        }
        .floating-pet:nth-child(2){
            top:70%;
            right:8%;
            animation-delay:3s
        }
        .floating-pet:nth-child(2)::before {
            content: '\1F415';
            color: var(--yellow);
        }
        .floating-pet:nth-child(3){
            bottom:20%;
            left:15%;
            animation-delay:6s
        }
        .floating-pet:nth-child(3)::before {
            content: '\1F408';
            color: var(--light-violet);
        }
        .floating-pet:nth-child(4){
            top:20%;
            right:15%;
            animation-delay:9s
        }
        .floating-pet:nth-child(4)::before {
            content: '\1F9B4';
            color: var(--primary-violet);
        }

        @keyframes floatAround{
            0%{transform:translate(0,0) rotate(0)}
            25%{transform:translate(20px,-20px) rotate(5deg)}
            50%{transform:translate(0,-40px) rotate(0)}
            75%{transform:translate(-20px,-20px) rotate(-5deg)}
            100%{transform:translate(0,0) rotate(0)}
        }

        .particles {
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            pointer-events:none;
            z-index:-1
        }
        .particle {
            position:absolute;
            border-radius:50%;
            animation:particleFloat 8s linear infinite
        }
        @keyframes particleFloat{
            0%{transform:translateY(100vh) rotate(0);opacity:0}
            10%{opacity:1}
            90%{opacity:1}
            100%{transform:translateY(-100px) rotate(360deg);opacity:0}
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
                margin: 0 10px;
                border-radius: 20px;
            }
            .logo h1 {
                font-size: 28px;
            }
            .reset-text {
                font-size: 14px;
                padding: 16px;
            }
            .input-field {
                padding: 16px 45px 16px 16px;
            }
        }

        @media (max-width: 380px) {
            .login-container {
                padding: 25px 16px;
            }
            .logo h1 {
                font-size: 24px;
            }
        }
    </style>

    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="login-container">

            <div class="logo">
                <h1>{{ config('app.name') }}</h1>
                <p>Create New Password</p>
            </div>

            <div class="reset-text">
                Choose a new password to regain access to your account.
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                @error('email')
                    <div class="field-error" style="margin-bottom: 20px;">{{ $message }}</div>
                @enderror

                <div class="input-group" style="margin-bottom:16px">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="input-field"
                        placeholder=" "
                        required
                        autofocus
                        autocomplete="new-password"
                    >
                    <label for="password" class="input-label">New Password</label>
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                        <i class="far fa-eye"></i>
                    </button>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <div class="password-requirements">
                        <div class="requirement" id="length-req">
                            <i class="far fa-circle"></i><span>Minimum 8 characters</span>
                        </div>
                        <div class="requirement" id="uppercase-req">
                            <i class="far fa-circle"></i><span>Contains an uppercase letter</span>
                        </div>
                        <div class="requirement" id="lowercase-req">
                            <i class="far fa-circle"></i><span>Contains a lowercase letter</span>
                        </div>
                        <div class="requirement" id="number-req">
                            <i class="far fa-circle"></i><span>Contains a number</span>
                        </div>
                        <div class="requirement" id="symbol-req">
                            <i class="far fa-circle"></i><span>Contains a symbol</span>
                        </div>
                    </div>

                    <div class="password-strength" id="password-strength">
                        Please choose a strong password.
                    </div>
                </div>

                <div class="input-group">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="input-field"
                        placeholder=" "
                        required
                        autocomplete="new-password"
                    >
                    <label for="password_confirmation" class="input-label">Confirm Password</label>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" aria-label="Toggle password visibility">
                        <i class="far fa-eye"></i>
                    </button>
                    @error('password_confirmation')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <div class="confirm-error" id="confirm-password-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Passwords do not match.</span>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="login-btn">
                        Reset Password
                    </button>
                </div>

                <div class="signup-link">
                    <a href="{{ route('login') }}" class="forgot-password">
                        &larr; Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            initializeInputFields();

            const passEl = document.getElementById('password');
            const pass2El = document.getElementById('password_confirmation');
            const lengthReq = document.getElementById('length-req');
            const uppercaseReq = document.getElementById('uppercase-req');
            const lowercaseReq = document.getElementById('lowercase-req');
            const numberReq = document.getElementById('number-req');
            const symbolReq = document.getElementById('symbol-req');
            const strengthEl = document.getElementById('password-strength');
            const confirmErr = document.getElementById('confirm-password-error');
            const form = passEl ? passEl.closest('form') : null;

            function setReq(el, ok) {
                if (!el) return;
                el.classList.toggle('valid', ok);
                el.classList.toggle('invalid', !ok);
                const icon = el.querySelector('i');
                if (icon) icon.className = ok ? 'fas fa-check-circle' : 'fas fa-times-circle';
            }

            function evaluatePassword() {
                const pwd = passEl ? passEl.value : '';

                const hasLen = pwd.length >= 8;
                const hasUpper = /[A-Z]/.test(pwd);
                const hasLower = /[a-z]/.test(pwd);
                const hasNum = /\d/.test(pwd);
                const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~]/.test(pwd);

                setReq(lengthReq, hasLen);
                setReq(uppercaseReq, hasUpper);
                setReq(lowercaseReq, hasLower);
                setReq(numberReq, hasNum);
                setReq(symbolReq, hasSymbol);

                if (!strengthEl) return;

                const score = [hasLen, hasUpper, hasLower, hasNum, hasSymbol].filter(Boolean).length;

                if (!pwd) {
                    strengthEl.textContent = 'Please choose a strong password.';
                    strengthEl.className = 'password-strength';
                } else if (score <= 2) {
                    strengthEl.textContent = 'Weak password';
                    strengthEl.className = 'password-strength weak';
                } else if (score <= 4) {
                    strengthEl.textContent = 'Medium password';
                    strengthEl.className = 'password-strength medium';
                } else {
                    strengthEl.textContent = 'Strong password';
                    strengthEl.className = 'password-strength strong';
                }

                checkMatch();
            }

            function checkMatch() {
                if (!pass2El || !confirmErr) return true;
                const mismatch = !!pass2El.value && passEl.value !== pass2El.value;
                confirmErr.classList.toggle('show', mismatch);
                return !mismatch;
            }

            if (passEl) {
                passEl.addEventListener('input', evaluatePassword);
                passEl.addEventListener('blur', evaluatePassword);
            }
            if (pass2El) {
                pass2El.addEventListener('input', checkMatch);
                pass2El.addEventListener('blur', checkMatch);
            }

            if (form) {
                form.addEventListener('submit', function(e) {
                    evaluatePassword();
                    if (!checkMatch()) {
                        e.preventDefault();
                        pass2El.focus();
                    }
                });
            }

            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = window.innerWidth < 480 ? 15 : 25;

                for (let i = 0; i < particleCount; i++) {
                    const p = document.createElement('div');
                    p.classList.add('particle');

                    if (Math.random() > 0.7) {
                        p.style.width = '6px';
                        p.style.height = '6px';
                        p.style.backgroundColor = 'rgba(249, 223, 113, 0.6)';
                    } else {
                        p.style.width = '4px';
                        p.style.height = '4px';
                        p.style.backgroundColor = 'rgba(138, 43, 226, 0.4)';
                    }

                    p.style.left = `${Math.random() * 100}%`;
                    p.style.animationDuration = `${Math.random() * 10 + 5}s`;
                    p.style.animationDelay = `${Math.random() * 5}s`;
                    particlesContainer.appendChild(p);
                }
            }

            function initializeInputFields() {
                document.querySelectorAll('.input-field').forEach(field => {
                    if (field.value) {
                        updateLabelState(field, true);
                    }
                    field.addEventListener('input', function() {
                        updateLabelState(this, this.value.length > 0);
                    });
                    field.addEventListener('focus', function() {
                        updateLabelState(this, true);
                    });
                    field.addEventListener('blur', function() {
                        updateLabelState(this, this.value.length > 0);
                    });
                });
            }

            function updateLabelState(field, hasValue) {
                const label = field.parentNode.querySelector('.input-label');
                if (label) {
                    if (hasValue || document.activeElement === field) {
                        label.style.top = '-10px';
                        label.style.left = '12px';
                        label.style.fontSize = '13px';
                        label.style.color = 'var(--primary-violet)';
                        label.style.backgroundColor = 'var(--soft-white)';
                        label.style.fontWeight = '600';
                    } else {
                        label.style.top = '18px';
                        label.style.left = '20px';
                        label.style.fontSize = '16px';
                        label.style.color = 'var(--text-gray)';
                        label.style.backgroundColor = 'var(--light-gray)';
                        label.style.fontWeight = '500';
                    }
                }
            }
        });

        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            const icon = btn.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
</x-guest-layout>

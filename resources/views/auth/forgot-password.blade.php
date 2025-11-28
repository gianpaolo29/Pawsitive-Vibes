<x-guest-layout>
    {{-- Custom styles from the reference design --}}
    <style>
        /* BASE STYLES AND VARIABLES */
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

        /* NAV & CONTAINERS */
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

        /* TYPOGRAPHY & MESSAGES */
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

        /* INPUTS */
        .input-group { 
            position:relative; 
            margin-bottom:30px; 
            opacity:0; 
            transform:translateX(-30px); 
            animation:slideInLeft .6s ease forwards 
        }
        .input-group:nth-child(1){ animation-delay:.6s }
        .input-group:nth-child(2){ animation-delay:.8s }
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
        
        /* BUTTONS */
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
            animation:fadeIn .8s ease 1s forwards; 
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

        /* SUCCESS MESSAGE */
        .success-message {
            background: linear-gradient(135deg, rgba(52,211,153,0.1), rgba(16,185,129,0.1));
            border: 1px solid rgba(16,185,129,0.2);
            border-left: 4px solid #10b981;
            color: #065f46;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 500;
            opacity: 0;
            animation: fadeIn 0.8s ease 0.4s forwards;
        }

        /* BACK LINK */
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

        /* BACKGROUND ELEMENTS */
        .floating-pet { 
            position:absolute; 
            z-index:-1; 
            opacity:.7; 
            animation:floatAround 15s linear infinite;
            font-size: 0;
        }
        .floating-pet::before {
            font-size: 40px;
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }
        .floating-pet:nth-child(1){
            top:10%;
            left:5%;
            animation-delay:0s
        }
        .floating-pet:nth-child(1)::before {
            content: '🐾';
            color: var(--primary-violet);
        }
        .floating-pet:nth-child(2){
            top:70%;
            right:8%;
            animation-delay:3s
        }
        .floating-pet:nth-child(2)::before {
            content: '🐕';
            color: var(--yellow);
        }
        .floating-pet:nth-child(3){
            bottom:20%;
            left:15%;
            animation-delay:6s
        }
        .floating-pet:nth-child(3)::before {
            content: '🐈';
            color: var(--light-violet);
        }
        .floating-pet:nth-child(4){
            top:20%;
            right:15%;
            animation-delay:9s
        }
        .floating-pet:nth-child(4)::before {
            content: '🦴';
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

        /* Responsive adjustments */
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



    {{-- FLOATING/PARTICLE ELEMENTS --}}
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="login-container">
            
            {{-- HEADER / LOGO --}}
            <div class="logo">
                <h1>Pawsitive Vibes</h1>
                <p>Reset Your Password</p>
            </div>

            {{-- STATUS MESSAGE --}}
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @else
                {{-- INSTRUCTION TEXT --}}
                <div class="reset-text">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="input-field @error('email') error-field @enderror"
                        placeholder=" "
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                    >
                    <label for="email" class="input-label">Email Address</label>
                    
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="login-btn">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
                
                {{-- Link back to login --}}
                <div class="signup-link">
                    <a href="{{ route('login') }}" class="forgot-password">
                        ← Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            initializeInputFields();

            // Function to handle the floating background particles
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = window.innerWidth < 480 ? 15 : 25;

                for (let i = 0; i < particleCount; i++) {
                    const p = document.createElement('div');
                    p.classList.add('particle');
                    
                    // Randomly assign color and size based on reference
                    if (Math.random() > 0.7) {
                        // Yellow particle
                        p.style.width = '6px'; 
                        p.style.height = '6px';
                        p.style.backgroundColor = 'rgba(249, 223, 113, 0.6)';
                    } else {
                        // Violet particle
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

            // Initialize input fields with proper state
            function initializeInputFields() {
                document.querySelectorAll('.input-field').forEach(field => {
                    // Check if the field has an initial value
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
    </script>
</x-guest-layout>
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

        /* ── Fonts ── */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap');

        /* ── Navbar ── */
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
            0%   { transform:scale(1);   opacity:1 }
            50%  { transform:scale(1.2); opacity:.7 }
            100% { transform:scale(1);   opacity:1 }
        }

        /* ── Layout ── */
        .main-content {
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:80px 20px 40px;
            width:100%
        }

        /* ── Card ── */
        .recovery-container {
            background:rgba(255,255,255,.95);
            backdrop-filter:blur(20px);
            border-radius:24px;
            box-shadow:var(--card-shadow), 0 0 0 1px rgba(255,255,255,0.8);
            width:100%;
            max-width:500px;
            padding:50px 40px 40px;
            position:relative;
            overflow:hidden;
            opacity:0;
            transform:translateY(30px) scale(.95);
            animation:fadeInUp .8s ease forwards;
            border:1px solid rgba(255,255,255,0.5);
            transition:all .4s ease
        }
        .recovery-container:hover {
            box-shadow:var(--hover-shadow), 0 0 0 1px rgba(255,255,255,0.9);
            transform:translateY(-5px)
        }
        @keyframes fadeInUp {
            to { opacity:1; transform:translateY(0) scale(1) }
        }
        .recovery-container::before {
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
            to { transform:scaleX(1) }
        }
        @keyframes fadeIn {
            to { opacity:1 }
        }

        /* ── Logo / header ── */
        .logo {
            text-align:center;
            margin-bottom:28px;
            opacity:0;
            animation:fadeIn 1s ease .3s forwards
        }
        .logo h1 {
            color:var(--primary-violet);
            font-size:32px;
            font-weight:700;
            letter-spacing:1.5px;
            font-family:'Quicksand',sans-serif;
            margin-bottom:6px;
            position:relative;
            display:inline-block;
            text-shadow:2px 2px 4px rgba(138,43,226,.2)
        }
        .logo h1::after {
            content:'';
            position:absolute;
            bottom:-8px;
            left:10%;
            width:80%;
            height:3px;
            background:linear-gradient(90deg,transparent,var(--yellow),transparent);
            transform:scaleX(0);
            transform-origin:center;
            animation:expandLine 1s ease 1s forwards
        }
        .logo p {
            color:var(--text-gray);
            font-size:14px;
            margin-top:14px;
            letter-spacing:1px;
            font-weight:500
        }

        /* ── Warning box ── */
        .warning-box {
            display:flex;
            align-items:flex-start;
            gap:14px;
            background:rgba(249,223,113,.18);
            border:1.5px solid rgba(249,223,113,.7);
            border-left:4px solid #e6a817;
            border-radius:14px;
            padding:18px 20px;
            margin-bottom:32px;
            opacity:0;
            animation:fadeIn .8s ease .6s forwards
        }
        .warning-box .warning-icon {
            font-size:22px;
            color:#c87f00;
            flex-shrink:0;
            margin-top:2px
        }
        .warning-box p {
            font-size:14px;
            color:#7a5200;
            font-weight:500;
            line-height:1.6
        }

        /* ── Recovery option cards ── */
        .recovery-options {
            display:flex;
            flex-direction:column;
            gap:16px;
            margin-bottom:32px
        }
        .option-card {
            display:flex;
            align-items:center;
            gap:20px;
            padding:22px 24px;
            border-radius:18px;
            border:2px solid var(--medium-gray);
            background:var(--light-gray);
            text-decoration:none;
            color:var(--dark-gray);
            transition:all .35s ease;
            position:relative;
            overflow:hidden;
            opacity:0;
            transform:translateX(-30px)
        }
        .option-card:nth-child(1) { animation:slideInLeft .6s ease .8s forwards }
        .option-card:nth-child(2) { animation:slideInLeft .6s ease 1s forwards }
        @keyframes slideInLeft {
            to { opacity:1; transform:translateX(0) }
        }
        .option-card::before {
            content:'';
            position:absolute;
            top:0;
            left:-100%;
            width:100%;
            height:100%;
            background:linear-gradient(90deg,transparent,rgba(255,255,255,.5),transparent);
            transition:left .5s ease
        }
        .option-card:hover {
            border-color:var(--primary-violet);
            background:var(--soft-white);
            box-shadow:var(--hover-shadow);
            transform:translateY(-4px) scale(1.01)
        }
        .option-card:hover::before {
            left:100%
        }
        .option-card:active {
            transform:translateY(0) scale(.99)
        }
        .option-icon-wrap {
            width:56px;
            height:56px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
            flex-shrink:0;
            transition:all .35s ease;
            background:linear-gradient(135deg,var(--light-yellow),#fff);
            color:var(--primary-violet);
            box-shadow:0 6px 14px rgba(138,43,226,.15)
        }
        .option-card:hover .option-icon-wrap {
            background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));
            color:#fff;
            box-shadow:0 10px 20px rgba(138,43,226,.35);
            transform:scale(1.1) rotate(-5deg)
        }
        .option-text {
            flex:1
        }
        .option-text strong {
            display:block;
            font-size:16px;
            font-weight:700;
            font-family:'Quicksand',sans-serif;
            color:var(--dark-gray);
            margin-bottom:4px;
            transition:color .3s ease
        }
        .option-card:hover .option-text strong {
            color:var(--primary-violet)
        }
        .option-text span {
            font-size:13px;
            color:var(--text-gray);
            font-weight:400
        }
        .option-arrow {
            font-size:18px;
            color:var(--medium-gray);
            transition:all .35s ease;
            flex-shrink:0
        }
        .option-card:hover .option-arrow {
            color:var(--primary-violet);
            transform:translateX(5px)
        }

        /* ── Back to login ── */
        .back-link-wrap {
            text-align:center;
            opacity:0;
            animation:fadeIn .8s ease 1.2s forwards
        }
        .back-link {
            color:var(--primary-violet);
            text-decoration:none;
            font-weight:500;
            font-size:15px;
            transition:all .3s ease;
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 20px;
            border-radius:12px;
            background:rgba(138,43,226,.05)
        }
        .back-link:hover {
            color:var(--dark-violet);
            background:rgba(138,43,226,.12);
            transform:translateX(-4px)
        }

        /* ── Floating pets ── */
        .floating-pet {
            position:absolute;
            z-index:-1;
            opacity:.7;
            animation:floatAround 15s linear infinite;
            font-size:0
        }
        .floating-pet::before { font-size:40px }
        .floating-pet:nth-child(1) { top:10%; left:5%; animation-delay:0s }
        .floating-pet:nth-child(1)::before { content:'\1F43E'; color:var(--primary-violet) }
        .floating-pet:nth-child(2) { top:70%; right:8%; animation-delay:3s }
        .floating-pet:nth-child(2)::before { content:'\1F415'; color:var(--yellow) }
        .floating-pet:nth-child(3) { bottom:20%; left:15%; animation-delay:6s }
        .floating-pet:nth-child(3)::before { content:'\1F408'; color:var(--light-violet) }
        .floating-pet:nth-child(4) { top:20%; right:15%; animation-delay:9s }
        .floating-pet:nth-child(4)::before { content:'\1F9B4'; color:var(--primary-violet) }
        @keyframes floatAround {
            0%   { transform:translate(0,0)     rotate(0) }
            25%  { transform:translate(20px,-20px) rotate(5deg) }
            50%  { transform:translate(0,-40px)  rotate(0) }
            75%  { transform:translate(-20px,-20px) rotate(-5deg) }
            100% { transform:translate(0,0)     rotate(0) }
        }

        /* ── Particles ── */
        .particles {
            position:fixed;
            top:0; left:0;
            width:100%; height:100%;
            pointer-events:none;
            z-index:-1
        }
        .particle {
            position:absolute;
            border-radius:50%;
            animation:particleFloat 8s linear infinite
        }
        @keyframes particleFloat {
            0%   { transform:translateY(100vh) rotate(0);   opacity:0 }
            10%  { opacity:1 }
            90%  { opacity:1 }
            100% { transform:translateY(-100px) rotate(360deg); opacity:0 }
        }

        /* ── Responsive ── */
        @media (max-width: 520px) {
            .recovery-container {
                padding:30px 20px 28px;
                margin:0 10px;
                border-radius:20px
            }
            .logo h1 { font-size:26px }
            .option-card { padding:18px 16px; gap:14px }
            .option-icon-wrap { width:48px; height:48px; font-size:18px }
            .option-text strong { font-size:15px }
        }
        @media (max-width: 380px) {
            .recovery-container { padding:22px 14px 22px }
            .logo h1 { font-size:22px }
        }
    </style>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Navbar --}}
    <nav class="glass-navbar">
        <div class="nav-logo">
            <img src="{{ asset('images/pawsitive-logo.jpg') }}" alt="{{ config('app.name') }} Logo" class="logo-img">
            <span>{{ config('app.name') }}</span>
        </div>
    </nav>

    {{-- Background floating pets --}}
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="floating-pet"></div>
    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="recovery-container">

            {{-- Header --}}
            <div class="logo">
                <h1>{{ config('app.name') }}</h1>
                <p>Account Recovery</p>
            </div>

            {{-- Warning notice --}}
            <div class="warning-box">
                <div class="warning-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <p>
                    Your account has been temporarily locked due to multiple failed login attempts.
                    Please choose a recovery method:
                </p>
            </div>

            {{-- Recovery option cards --}}
            <div class="recovery-options">

                {{-- Option 1: Forgot Password --}}
                <a href="{{ route('password.request') }}" class="option-card">
                    <div class="option-icon-wrap">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="option-text">
                        <strong>Forgot Password</strong>
                        <span>Reset your password via email link</span>
                    </div>
                    <div class="option-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

                {{-- Option 2: Security Questions --}}
                <a href="{{ route('security.questions', ['email' => $email]) }}" class="option-card">
                    <div class="option-icon-wrap">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="option-text">
                        <strong>Answer Security Questions</strong>
                        <span>Verify your identity with your secret answers</span>
                    </div>
                    <div class="option-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

            </div>

            {{-- Back to login --}}
            <div class="back-link-wrap">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            createParticles();

            function createParticles() {
                const container = document.getElementById('particles');
                if (!container) return;
                const count = window.innerWidth < 480 ? 15 : 25;

                for (let i = 0; i < count; i++) {
                    const p = document.createElement('div');
                    p.classList.add('particle');

                    if (Math.random() > 0.7) {
                        p.style.width  = '6px';
                        p.style.height = '6px';
                        p.style.backgroundColor = 'rgba(249, 223, 113, 0.6)';
                    } else {
                        p.style.width  = '4px';
                        p.style.height = '4px';
                        p.style.backgroundColor = 'rgba(138, 43, 226, 0.4)';
                    }

                    p.style.left              = `${Math.random() * 100}%`;
                    p.style.animationDuration = `${Math.random() * 10 + 5}s`;
                    p.style.animationDelay    = `${Math.random() * 5}s`;
                    container.appendChild(p);
                }
            }
        });
    </script>
</x-guest-layout>

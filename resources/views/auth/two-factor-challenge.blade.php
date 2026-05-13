<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Two-Factor Authentication</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{
            --primary-violet:#8a2be2;--light-violet:#b19cd9;--dark-violet:#6a0dad;
            --yellow:#F9DF71;--light-yellow:#fff9e6;
            --soft-white:#fefefe;--light-gray:#f8f7ff;--medium-gray:#e0ddf5;--text-gray:#666;--dark-gray:#444;
            --card-shadow:0 5px 15px rgba(138,43,226,.08);--hover-shadow:0 8px 25px rgba(138,43,226,.15)
        }
        body{background:#ffffff;min-height:100vh;font-family:'Poppins',sans-serif;color:var(--dark-gray);line-height:1.5;display:flex;flex-direction:column;position:relative;overflow-x:hidden}
        .glass-navbar{width:100%;background:rgba(255,255,255,.98);backdrop-filter:blur(15px);padding:12px 20px;display:flex;justify-content:space-between;align-items:center;position:fixed;top:0;z-index:100;box-shadow:0 2px 20px rgba(0,0,0,.04);border-bottom:1px solid rgba(0,0,0,.03)}
        .nav-logo{display:flex;align-items:center;color:var(--primary-violet);font-weight:700;font-size:1.3rem;font-family:'Quicksand',sans-serif}
        .logo-img{width:35px;height:35px;margin-right:10px;object-fit:contain}
        .nav-logo::after{content:'';display:inline-block;width:6px;height:6px;background:var(--yellow);border-radius:50%;margin-left:6px;animation:pulse 2s infinite}
        @keyframes pulse{0%{transform:scale(1);opacity:1}50%{transform:scale(1.2);opacity:.7}100%{transform:scale(1);opacity:1}}
        .main-content{flex:1;display:flex;justify-content:center;align-items:center;padding:80px 20px 20px;width:100%}
        .challenge-container{background:rgba(255,255,255,.98);backdrop-filter:blur(15px);border-radius:20px;box-shadow:var(--card-shadow);width:100%;max-width:460px;padding:45px 40px;position:relative;overflow:hidden;opacity:0;transform:translateY(30px) scale(.95);animation:fadeInUp .8s ease forwards;border:1px solid rgba(0,0,0,.03);transition:all .4s ease}
        .challenge-container:hover{box-shadow:var(--hover-shadow);transform:translateY(-5px) scale(1)}
        @keyframes fadeInUp{to{opacity:1;transform:translateY(0) scale(1)}}
        .challenge-container::before{content:'';position:absolute;top:0;left:0;width:100%;height:6px;background:linear-gradient(90deg,var(--primary-violet),var(--yellow),var(--primary-violet));transform:scaleX(0);transform-origin:left;animation:expandLine 1.2s ease .5s forwards}
        @keyframes expandLine{to{transform:scaleX(1)}}
        .shield-icon{text-align:center;margin-bottom:20px;opacity:0;animation:fadeIn 1s ease .3s forwards}
        .shield-icon i{font-size:48px;color:var(--primary-violet);filter:drop-shadow(0 4px 8px rgba(138,43,226,.3))}
        @keyframes fadeIn{to{opacity:1}}
        .title{text-align:center;margin-bottom:8px;color:var(--primary-violet);font-size:24px;font-weight:700;font-family:'Quicksand',sans-serif;opacity:0;animation:fadeIn 1s ease .3s forwards}
        .subtitle{text-align:center;color:var(--text-gray);font-size:14px;margin-bottom:30px;opacity:0;animation:fadeIn 1s ease .5s forwards}
        .input-group{position:relative;margin-bottom:24px;opacity:0;transform:translateX(-30px);animation:slideInLeft .6s ease .6s forwards}
        @keyframes slideInLeft{to{opacity:1;transform:translateX(0)}}
        .otp-inputs{display:flex;gap:10px;justify-content:center;margin-bottom:24px}
        .otp-inputs input{width:48px;height:56px;text-align:center;font-size:22px;font-weight:600;border:2px solid var(--medium-gray);border-radius:12px;background:var(--light-gray);transition:all .3s;outline:none;font-family:'Poppins',sans-serif;color:var(--dark-gray)}
        .otp-inputs input:focus{border-color:var(--primary-violet);background:var(--soft-white);box-shadow:0 0 0 4px rgba(138,43,226,.15);transform:translateY(-2px)}
        .verify-btn{width:100%;padding:16px;background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));border:none;border-radius:16px;color:#fff;font-size:16px;font-weight:600;cursor:pointer;transition:all .4s ease;box-shadow:0 8px 20px rgba(138,43,226,.3);font-family:'Poppins',sans-serif;letter-spacing:1px;position:relative;overflow:hidden}
        .verify-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.3),transparent);transition:left .5s}
        .verify-btn:hover{transform:translateY(-3px);box-shadow:0 12px 25px rgba(138,43,226,.4)}
        .verify-btn:hover::before{left:100%}
        .recovery-link{text-align:center;margin-top:20px;font-size:13px;color:var(--text-gray)}
        .recovery-link a{color:var(--primary-violet);text-decoration:none;font-weight:600;transition:color .3s}
        .recovery-link a:hover{color:var(--dark-violet)}
        .error-msg{text-align:center;color:#c0392b;font-size:.85rem;margin-bottom:16px;padding:10px;background:rgba(192,57,43,.08);border-radius:10px}
        .particles{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:-1}
        .particle{position:absolute;border-radius:50%;animation:particleFloat 8s linear infinite}
        @keyframes particleFloat{0%{transform:translateY(100vh) rotate(0);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-100px) rotate(360deg);opacity:0}}
        .floating-pet{position:absolute;z-index:-1;opacity:.7;animation:floatAround 15s linear infinite}
        .floating-pet:nth-child(1){top:10%;left:5%;font-size:40px;color:var(--primary-violet)}
        .floating-pet:nth-child(2){top:70%;right:8%;font-size:35px;color:var(--yellow);animation-delay:3s}
        @keyframes floatAround{0%{transform:translate(0,0) rotate(0)}25%{transform:translate(20px,-20px) rotate(5deg)}50%{transform:translate(0,-40px) rotate(0)}75%{transform:translate(-20px,-20px) rotate(-5deg)}100%{transform:translate(0,0) rotate(0)}}
        .hidden-code-input{position:absolute;opacity:0;pointer-events:none}
        .toggle-mode{text-align:center;margin-top:16px}
        .toggle-mode button{background:none;border:none;color:var(--primary-violet);font-weight:600;font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif;transition:color .3s}
        .toggle-mode button:hover{color:var(--dark-violet)}
    </style>
</head>
<body>
    <nav class="glass-navbar">
        <div class="nav-logo">
            <img src="{{ asset('images/pawsitive-logo.jpg') }}" alt="{{ config('app.name') }} Logo" class="logo-img">
            <span>{{ config('app.name') }}</span>
        </div>
    </nav>

    <div class="floating-pet"><i class="fas fa-paw"></i></div>
    <div class="floating-pet"><i class="fas fa-shield-alt"></i></div>
    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="challenge-container" x-data="otpChallenge()">
            <div class="shield-icon">
                <i class="fas fa-shield-alt"></i>
            </div>

            <h1 class="title" x-text="useRecovery ? 'Recovery Code' : 'Two-Factor Authentication'"></h1>
            <p class="subtitle" x-text="useRecovery ? 'Enter one of your recovery codes to access your account.' : 'Enter the 6-digit code from your authenticator app to continue.'"></p>

            @if($errors->has('code'))
                <div class="error-msg">
                    <i class="fas fa-exclamation-circle"></i>
                    The code you entered is invalid. Please try again.
                </div>
            @endif

            <form method="POST" action="{{ route('customer.two-factor.verify') }}" id="otpForm" @submit="document.getElementById('codeInput').value = code">
                @csrf

                {{-- Hidden input that holds the combined code --}}
                <input type="hidden" name="code" :value="code" id="codeInput">

                {{-- OTP digit inputs --}}
                <div x-show="!useRecovery" class="input-group" style="opacity:1;transform:none">
                    <div class="otp-inputs">
                        <template x-for="(digit, index) in digits" :key="index">
                            <input
                                type="text"
                                maxlength="1"
                                inputmode="numeric"
                                x-model="digits[index]"
                                @input="handleInput($event, index)"
                                @keydown.backspace="handleBackspace($event, index)"
                                @paste.prevent="handlePaste($event)"
                                @focus="$event.target.select()"
                                :id="'otp-' + index"
                                autocomplete="off"
                            >
                        </template>
                    </div>
                </div>

                {{-- Recovery code input --}}
                <div x-show="useRecovery" class="input-group" style="opacity:1;transform:none">
                    <input
                        type="text"
                        x-model="recoveryCode"
                        @input="code = recoveryCode"
                        placeholder="Enter recovery code"
                        style="width:100%;padding:16px 20px;border:2px solid var(--medium-gray);border-radius:14px;font-size:16px;background:var(--light-gray);transition:all .3s;outline:none;font-family:'Poppins',sans-serif;text-align:center;letter-spacing:2px"
                        autocomplete="off"
                    >
                </div>

                <button type="submit" class="verify-btn">
                    <i class="fas fa-check-circle" style="margin-right:8px"></i>
                    Verify
                </button>
            </form>

            <div class="toggle-mode">
                <button type="button" @click="toggleMode()" x-text="useRecovery ? 'Use authenticator code instead' : 'Use a recovery code instead'"></button>
            </div>

            <div class="recovery-link" style="margin-top:24px">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:var(--text-gray);font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif">
                        <i class="fas fa-arrow-left" style="margin-right:4px"></i> Back to Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function otpChallenge() {
            return {
                digits: ['', '', '', '', '', ''],
                code: '',
                recoveryCode: '',
                useRecovery: false,

                handleInput(event, index) {
                    const val = event.target.value.replace(/\D/g, '');
                    this.digits[index] = val.charAt(0) || '';
                    event.target.value = this.digits[index];

                    this.code = this.digits.join('');

                    if (val && index < 5) {
                        document.getElementById('otp-' + (index + 1)).focus();
                    }

                    if (this.digits.every(d => d !== '')) {
                        document.getElementById('codeInput').value = this.code;
                        this.$nextTick(() => {
                            document.getElementById('otpForm').submit();
                        });
                    }
                },

                handleBackspace(event, index) {
                    if (!this.digits[index] && index > 0) {
                        document.getElementById('otp-' + (index - 1)).focus();
                    }
                },

                handlePaste(event) {
                    const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
                    for (let i = 0; i < 6; i++) {
                        this.digits[i] = paste[i] || '';
                    }
                    this.code = this.digits.join('');
                    if (paste.length === 6) {
                        document.getElementById('codeInput').value = this.code;
                        this.$nextTick(() => {
                            document.getElementById('otpForm').submit();
                        });
                    }
                },

                toggleMode() {
                    this.useRecovery = !this.useRecovery;
                    this.code = '';
                    this.recoveryCode = '';
                    this.digits = ['', '', '', '', '', ''];
                }
            }
        }

        // Particles
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('particles');
            const count = window.innerWidth < 480 ? 15 : 25;
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.classList.add('particle');
                if (Math.random() > 0.7) {
                    p.style.width = '6px'; p.style.height = '6px';
                    p.style.backgroundColor = 'rgba(249, 223, 113, 0.6)';
                } else {
                    p.style.width = '4px'; p.style.height = '4px';
                    p.style.backgroundColor = 'rgba(138, 43, 226, 0.4)';
                }
                p.style.left = `${Math.random() * 100}%`;
                p.style.animationDuration = `${Math.random() * 10 + 5}s`;
                p.style.animationDelay = `${Math.random() * 5}s`;
                container.appendChild(p);
            }
        });
    </script>
</body>
</html>

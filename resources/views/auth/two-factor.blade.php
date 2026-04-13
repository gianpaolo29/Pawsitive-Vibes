<x-guest-layout>
    <style>
        * { margin:0; padding:0; box-sizing:border-box }
        :root {
            --primary-violet:#8a2be2;--dark-violet:#6a0dad;
            --yellow:#F9DF71;--soft-white:#fefefe;--light-gray:#f8f7ff;
            --medium-gray:#e0ddf5;--text-gray:#666;--dark-gray:#444;
            --card-shadow:0 5px 15px rgba(138,43,226,.08)
        }
        body {
            background: linear-gradient(135deg, #f8f7ff 0%, #fff9e6 50%, #f0ebff 100%);
            min-height:100vh; font-family:'Poppins',sans-serif; color:var(--dark-gray);
            line-height:1.5; display:flex; flex-direction:column; overflow-x:hidden
        }
        .main-content { flex:1; display:flex; justify-content:center; align-items:center; padding:40px 20px }
        .verify-container {
            background:rgba(255,255,255,.95); backdrop-filter:blur(20px);
            border-radius:24px; box-shadow:var(--card-shadow);
            width:100%; max-width:440px; padding:50px 40px; position:relative; overflow:hidden;
            opacity:0; transform:translateY(30px); animation:fadeInUp .8s ease forwards
        }
        .verify-container::before {
            content:''; position:absolute; top:0; left:0; width:100%; height:6px;
            background:linear-gradient(90deg,var(--primary-violet),var(--yellow),var(--primary-violet));
            transform:scaleX(0); transform-origin:left; animation:expandLine 1.2s ease .5s forwards
        }
        @keyframes fadeInUp { to { opacity:1; transform:translateY(0) } }
        @keyframes expandLine { to { transform:scaleX(1) } }
        @keyframes fadeIn { to { opacity:1 } }

        .logo { text-align:center; margin-bottom:28px; opacity:0; animation:fadeIn 1s ease .3s forwards }
        .logo-icon { font-size:50px; margin-bottom:10px }
        .logo h1 { color:var(--primary-violet); font-size:26px; font-weight:700; font-family:'Quicksand',sans-serif }
        .logo p { color:var(--text-gray); font-size:13px; margin-top:4px; font-weight:500 }

        .info-text {
            color:var(--text-gray); font-size:14px; margin-bottom:24px; text-align:center;
            background:rgba(138,43,226,0.05); padding:14px; border-radius:12px;
            border-left:4px solid var(--primary-violet); opacity:0; animation:fadeIn .8s ease .6s forwards
        }

        .code-inputs { display:flex; gap:8px; justify-content:center; margin-bottom:20px; opacity:0; animation:fadeIn .8s ease .8s forwards }
        .code-input {
            width:50px; height:58px; text-align:center; font-size:22px; font-weight:700;
            border:2px solid var(--medium-gray); border-radius:14px; background:var(--light-gray);
            color:var(--primary-violet); font-family:'Poppins',sans-serif;
            transition:all .3s ease; outline:none
        }
        .code-input:focus { border-color:var(--primary-violet); background:var(--soft-white); box-shadow:0 0 0 4px rgba(138,43,226,.15); transform:translateY(-2px) }
        .code-input.filled { border-color:var(--primary-violet); background:rgba(138,43,226,0.05) }

        .field-error {
            color:#c0392b; font-size:.85rem; margin-bottom:14px; padding:10px 14px;
            background:rgba(192,57,43,0.1); border-radius:10px; border-left:3px solid #c0392b; text-align:center
        }

        .verify-btn {
            width:100%; padding:16px; background:linear-gradient(135deg,var(--primary-violet),var(--dark-violet));
            border:none; border-radius:14px; color:#fff; font-size:15px; font-weight:600;
            cursor:pointer; transition:all .4s ease; box-shadow:0 8px 20px rgba(138,43,226,.3);
            font-family:'Poppins',sans-serif; opacity:0; animation:fadeIn .8s ease 1s forwards
        }
        .verify-btn:hover { transform:translateY(-3px); box-shadow:0 12px 25px rgba(138,43,226,.4) }
        .verify-btn:disabled { opacity:0.5; cursor:not-allowed; transform:none }

        .actions { text-align:center; margin-top:18px; opacity:0; animation:fadeIn .8s ease 1.2s forwards }
        .back-link {
            display:inline-flex; align-items:center; gap:6px; color:var(--primary-violet);
            text-decoration:none; font-weight:500; font-size:14px; padding:8px 16px;
            border-radius:10px; transition:all .3s ease
        }
        .back-link:hover { background:rgba(138,43,226,0.08); transform:translateX(-3px) }

        .recovery-toggle {
            background:none; border:none; color:var(--text-gray); font-size:12px;
            cursor:pointer; margin-top:12px; text-decoration:underline; font-family:'Poppins',sans-serif
        }

        .particles { position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:-1 }
        .particle { position:absolute; border-radius:50%; animation:particleFloat 8s linear infinite }
        @keyframes particleFloat{
            0%{transform:translateY(100vh);opacity:0} 10%{opacity:1}
            90%{opacity:1} 100%{transform:translateY(-100px);opacity:0}
        }
        @media (max-width:500px) { .verify-container{padding:30px 20px} .code-input{width:42px;height:50px;font-size:18px} }
    </style>

    <div class="particles" id="particles"></div>

    <div class="main-content">
        <div class="verify-container">
            <div class="logo">
                <div class="logo-icon">🔐</div>
                <h1>{{ config('app.name') }}</h1>
                <p>Two-Factor Authentication</p>
            </div>

            <div class="info-text">
                Open your <strong>Google Authenticator</strong> app and enter the 6-digit code for your account.
            </div>

            @error('code')
                <div class="field-error">
                    @if($message === 'invalid')
                        Invalid code. Please check your authenticator app and try again.
                    @else
                        {{ $message }}
                    @endif
                </div>
            @enderror

            <form method="POST" action="{{ route('two-factor.login') }}" id="twoFactorForm">
                @csrf
                <input type="hidden" name="code" id="codeHidden">

                <div class="code-inputs">
                    <input type="text" maxlength="1" class="code-input" data-index="0" inputmode="numeric" autofocus>
                    <input type="text" maxlength="1" class="code-input" data-index="1" inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="2" inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="3" inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="4" inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="5" inputmode="numeric">
                </div>

                <button type="submit" class="verify-btn" id="verifyBtn" disabled>Verify Code</button>
            </form>

            <div class="actions">
                <button class="recovery-toggle" onclick="document.getElementById('recoverySection').style.display='block'; this.style.display='none';">
                    Use a recovery code instead
                </button>
                <div id="recoverySection" style="display:none; margin-top:12px;">
                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf
                        <input type="text" name="code" placeholder="Enter recovery code"
                            style="width:100%; padding:12px; border:2px solid var(--medium-gray); border-radius:12px; font-size:14px; text-align:center; font-family:'Poppins',sans-serif; margin-bottom:10px; outline:none;"
                            maxlength="10">
                        <button type="submit" class="verify-btn" style="opacity:1; animation:none; font-size:14px; padding:12px;">Use Recovery Code</button>
                    </form>
                </div>
                <br>
                <a href="{{ route('login') }}" class="back-link">&larr; Back to Login</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.code-input');
            const hidden = document.getElementById('codeHidden');
            const btn = document.getElementById('verifyBtn');
            const form = document.getElementById('twoFactorForm');

            function updateCode() {
                let code = '';
                inputs.forEach(i => { code += i.value; i.classList.toggle('filled', i.value !== ''); });
                hidden.value = code;
                btn.disabled = code.length !== 6;
                if (code.length === 6) form.submit();
            }

            inputs.forEach((input, idx) => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value && idx < inputs.length - 1) inputs[idx + 1].focus();
                    updateCode();
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && idx > 0) {
                        inputs[idx - 1].focus();
                        inputs[idx - 1].value = '';
                        updateCode();
                    }
                });
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasted = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, 6);
                    if (pasted.length === 6) {
                        pasted.split('').forEach((ch, i) => { if (inputs[i]) inputs[i].value = ch; });
                        inputs[5].focus();
                        updateCode();
                    }
                });
            });

            const pc = document.getElementById('particles');
            for (let i = 0; i < 20; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.width = p.style.height = (Math.random() > 0.7 ? 6 : 4) + 'px';
                p.style.backgroundColor = Math.random() > 0.7 ? 'rgba(249,223,113,0.6)' : 'rgba(138,43,226,0.4)';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = (Math.random() * 10 + 5) + 's';
                p.style.animationDelay = (Math.random() * 5) + 's';
                pc.appendChild(p);
            }
        });
    </script>
</x-guest-layout>

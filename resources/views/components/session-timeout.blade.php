@auth
<script>
(function() {
    const TIMEOUT_MS = 15 * 60 * 1000;       // 15 minutes
    const WARNING_MS = 2 * 60 * 1000;         // Show warning at 2 minutes remaining
    const WARNING_AT = TIMEOUT_MS - WARNING_MS; // 13 minutes of idle = show warning

    let idleTimer = null;
    let warningTimer = null;
    let countdownInterval = null;
    let warningShown = false;

    function resetTimers() {
        if (warningShown) return; // Don't reset if warning is active

        clearTimeout(idleTimer);
        clearTimeout(warningTimer);

        // At 13 min idle, show warning
        warningTimer = setTimeout(showWarning, WARNING_AT);

        // At 15 min idle, force logout
        idleTimer = setTimeout(forceLogout, TIMEOUT_MS);
    }

    function showWarning() {
        warningShown = true;
        let secondsLeft = WARNING_MS / 1000;

        Swal.fire({
            icon: 'warning',
            title: 'Session Expiring Soon',
            html: `<p>Your session will expire due to inactivity.</p><p style="margin-top:12px;">You will be logged out in <b id="timeout-countdown">${secondsLeft}</b> seconds.</p>`,
            confirmButtonText: 'Stay Logged In',
            confirmButtonColor: '#8a2be2',
            showCancelButton: true,
            cancelButtonText: 'Logout Now',
            cancelButtonColor: '#6b7280',
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: WARNING_MS,
            timerProgressBar: true,
            didOpen: () => {
                const countdownEl = document.getElementById('timeout-countdown');
                countdownInterval = setInterval(() => {
                    secondsLeft--;
                    if (countdownEl) countdownEl.textContent = Math.max(secondsLeft, 0);
                }, 1000);
            },
            willClose: () => {
                clearInterval(countdownInterval);
            }
        }).then((result) => {
            warningShown = false;
            if (result.isConfirmed) {
                // Ping server to refresh session
                fetch('{{ url("/session-keep-alive") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                }).then(() => {
                    resetTimers();
                }).catch(() => {
                    forceLogout();
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                forceLogout();
            } else {
                // Timer ran out
                forceLogout();
            }
        });
    }

    function forceLogout() {
        clearTimeout(idleTimer);
        clearTimeout(warningTimer);
        clearInterval(countdownInterval);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("logout") }}';
        form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
            <input type="hidden" name="session_timeout" value="1">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    // Activity events that reset the idle timer
    const events = ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart', 'click'];
    events.forEach(event => {
        document.addEventListener(event, resetTimers, { passive: true });
    });

    // Start timers
    resetTimers();
})();
</script>
@endauth

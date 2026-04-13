<x-guest-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="text-center mb-6">
        <a href="/" class="inline-block">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 rounded-full mx-auto mb-3">
        </a>
        <h2 class="text-xl font-bold text-gray-800">Account Reactivation</h2>
        <p class="text-sm text-gray-500 mt-1">Submit a ticket to request account reactivation</p>
    </div>

    @if(session('existing_ticket'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Ticket Already Exists',
                    html: 'You already have an open ticket: <strong>{{ session('existing_ticket') }}</strong><br><br>Please wait for the admin to review it.',
                    confirmButtonColor: '#8b5cf6',
                    confirmButtonText: 'Track My Ticket',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("support.ticket.track") }}?ticket={{ session("existing_ticket") }}';
                    }
                });
            });
        </script>
    @endif

    <form method="POST" action="{{ route('support.ticket.store') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-violet-400 focus:border-transparent"
                   placeholder="Enter your full name">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-violet-400 focus:border-transparent"
                   placeholder="Enter your registered email">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Reason / Message -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Reason for Reactivation</label>
            <textarea id="message" name="message" rows="4" required
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-violet-400 focus:border-transparent resize-none"
                      placeholder="Please explain why you'd like your account reactivated...">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-violet-600 to-purple-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all duration-200">
            Submit Ticket
        </button>

        <!-- Links -->
        <div class="flex items-center justify-between text-sm">
            <a href="{{ route('support.ticket.track') }}" class="text-violet-600 hover:text-violet-800 hover:underline">
                Track existing ticket
            </a>
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 hover:underline">
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>

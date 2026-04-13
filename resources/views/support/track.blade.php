<x-guest-layout>
    <div class="text-center mb-6">
        <a href="/" class="inline-block">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 rounded-full mx-auto mb-3">
        </a>
        <h2 class="text-xl font-bold text-gray-800">Track Your Ticket</h2>
        <p class="text-sm text-gray-500 mt-1">Enter your ticket number to check the status</p>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('support.ticket.track') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="ticket" value="{{ $ticketNumber }}" required
                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-violet-400 focus:border-transparent"
                   placeholder="e.g. TKT-20260413-0001">
            <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all duration-200">
                Search
            </button>
        </div>
    </form>

    @if($ticketNumber && !$ticket)
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-red-600 text-sm font-medium">Ticket not found</p>
            <p class="text-red-400 text-xs mt-1">Please check your ticket number and try again.</p>
        </div>
    @endif

    @if($ticket)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <!-- Ticket Header -->
            <div class="bg-gray-50 px-5 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Ticket</p>
                        <p class="text-lg font-bold text-gray-800">{{ $ticket->ticket_number }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->status_badge['color'] }}">
                        {{ $ticket->status_badge['label'] }}
                    </span>
                </div>
            </div>

            <!-- Ticket Details -->
            <div class="px-5 py-4 space-y-3">
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs">Name</p>
                        <p class="text-gray-800 font-medium">{{ $ticket->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Email</p>
                        <p class="text-gray-800 font-medium">{{ $ticket->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Submitted</p>
                        <p class="text-gray-800 font-medium">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @if($ticket->resolved_at)
                    <div>
                        <p class="text-gray-400 text-xs">Resolved</p>
                        <p class="text-gray-800 font-medium">{{ $ticket->resolved_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif
                </div>

                <div>
                    <p class="text-gray-400 text-xs mb-1">Your Message</p>
                    <p class="text-gray-700 text-sm bg-gray-50 rounded-lg p-3">{{ $ticket->message }}</p>
                </div>

                @if($ticket->admin_remarks)
                <div>
                    <p class="text-gray-400 text-xs mb-1">Admin Response</p>
                    <p class="text-gray-700 text-sm bg-violet-50 border border-violet-100 rounded-lg p-3">{{ $ticket->admin_remarks }}</p>
                </div>
                @endif

                <!-- Status Timeline -->
                <div class="pt-2">
                    <div class="flex items-center gap-3">
                        @php
                            $steps = ['open', 'in_progress', 'resolved'];
                            $isRejected = $ticket->status === 'rejected';
                            $currentIndex = array_search($ticket->status, $steps);
                            if ($isRejected) $currentIndex = 1;
                        @endphp
                        @foreach(['Submitted', 'In Review', $isRejected ? 'Rejected' : 'Resolved'] as $index => $step)
                            <div class="flex-1 text-center">
                                <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center text-xs font-bold
                                    {{ $index <= $currentIndex
                                        ? ($isRejected && $index === 2 ? 'bg-red-500 text-white' : 'bg-violet-600 text-white')
                                        : 'bg-gray-200 text-gray-400' }}">
                                    @if($index < $currentIndex)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                    @elseif($isRejected && $index === 2)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <p class="text-[10px] mt-1 {{ $index <= $currentIndex ? 'text-gray-700 font-medium' : 'text-gray-400' }}">{{ $step }}</p>
                            </div>
                            @if(!$loop->last)
                                <div class="flex-1 h-0.5 {{ $index < $currentIndex ? 'bg-violet-400' : 'bg-gray-200' }} -mt-4"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Links -->
    <div class="flex items-center justify-between text-sm mt-6">
        <a href="{{ route('support.ticket.create') }}" class="text-violet-600 hover:text-violet-800 hover:underline">
            Submit new ticket
        </a>
        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 hover:underline">
            Back to Login
        </a>
    </div>
</x-guest-layout>

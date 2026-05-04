<x-guest-layout>
    <div class="text-center py-4">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-800 mb-2">Ticket Submitted!</h2>
        <p class="text-sm text-gray-500 mb-4">Your reactivation request has been received.</p>

        <div class="bg-violet-50 border border-violet-200 rounded-xl p-4 mb-6">
            <p class="text-xs text-violet-500 font-medium uppercase tracking-wider mb-1">Ticket Number</p>
            <p class="text-2xl font-bold text-violet-700">{{ $ticketNumber }}</p>
            <p class="text-xs text-violet-500 mt-2">Save this number to track your ticket status</p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('support.ticket.track') }}?ticket={{ $ticketNumber }}"
               class="block w-full py-3 bg-gradient-to-r from-violet-600 to-purple-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all duration-200 text-center">
                Track My Ticket
            </a>
            <a href="{{ route('login') }}"
               class="block w-full py-3 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all duration-200 text-center">
                Back to Login
            </a>
        </div>
    </div>
</x-guest-layout>

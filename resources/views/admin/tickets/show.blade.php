<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.tickets.index') }}" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-bold text-gray-800">{{ $ticket->ticket_number }}</h1>
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $ticket->status_badge['color'] }}">
                        {{ $ticket->status_badge['label'] }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-0.5">Submitted {{ $ticket->created_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>

        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session("success") }}',
                        confirmButtonColor: '#8b5cf6',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            </script>
        @endif

        <div class="space-y-6">
            <!-- Customer Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Customer Information</h3>
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($ticket->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-400">Name</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $ticket->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Email</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $ticket->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Account Status</p>
                            @if($ticket->user)
                                <span class="inline-flex items-center gap-1 text-sm font-semibold {{ $ticket->user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    <span class="w-2 h-2 rounded-full {{ $ticket->user->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $ticket->user->is_active ? 'Active' : 'Deactivated' }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500">User not found</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($ticket->user && $ticket->user->blocked_reason)
                    <div class="mt-4 bg-red-50 border border-red-100 rounded-xl p-4">
                        <p class="text-xs text-red-500 font-medium mb-1">Block Reason</p>
                        <p class="text-sm text-red-700">{{ $ticket->user->blocked_reason }}</p>
                        @if($ticket->user->blocked_until)
                            <p class="text-xs text-red-400 mt-1">Blocked until: {{ $ticket->user->blocked_until->format('M d, Y h:i A') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Ticket Message -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ $ticket->subject }}</h3>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $ticket->message }}</p>
                </div>
            </div>

            <!-- Admin Remarks (if already responded) -->
            @if($ticket->admin_remarks)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Admin Response</h3>
                    <div class="bg-violet-50 border border-violet-100 rounded-xl p-4">
                        <p class="text-sm text-violet-800 leading-relaxed whitespace-pre-wrap">{{ $ticket->admin_remarks }}</p>
                    </div>
                    @if($ticket->resolved_at)
                        <p class="text-xs text-gray-400 mt-2">Responded on {{ $ticket->resolved_at->format('M d, Y h:i A') }}</p>
                    @endif
                </div>
            @endif

            <!-- Action Buttons (only for open/in_progress tickets) -->
            @if(in_array($ticket->status, ['open', 'in_progress']))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Take Action</h3>

                    @if($ticket->status === 'open')
                        <form action="{{ route('admin.tickets.markInProgress', $ticket) }}" method="POST" class="mb-4">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-semibold hover:bg-yellow-200 transition-colors">
                                Mark as In Progress
                            </button>
                        </form>
                    @endif

                    <div x-data="{ action: '' }" class="space-y-4">
                        <!-- Action Selection -->
                        <div class="flex gap-3">
                            <button @click="action = 'approve'"
                                    :class="action === 'approve' ? 'bg-green-600 text-white ring-2 ring-green-300' : 'bg-green-50 text-green-700 hover:bg-green-100'"
                                    class="flex-1 py-3 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Approve & Reactivate
                            </button>
                            <button @click="action = 'reject'"
                                    :class="action === 'reject' ? 'bg-red-600 text-white ring-2 ring-red-300' : 'bg-red-50 text-red-700 hover:bg-red-100'"
                                    class="flex-1 py-3 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Reject
                            </button>
                        </div>

                        <!-- Approve Form -->
                        <div x-show="action === 'approve'" x-cloak x-transition>
                            <form action="{{ route('admin.tickets.approve', $ticket) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Remarks (optional)</label>
                                    <textarea name="admin_remarks" rows="3"
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-green-400 focus:border-transparent resize-none"
                                              placeholder="Your account has been reactivated. You may now log in."></textarea>
                                </div>
                                <button type="submit"
                                        class="w-full py-3 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    Approve & Reactivate Account
                                </button>
                            </form>
                        </div>

                        <!-- Reject Form -->
                        <div x-show="action === 'reject'" x-cloak x-transition>
                            <form action="{{ route('admin.tickets.reject', $ticket) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason for rejection <span class="text-red-500">*</span></label>
                                    <textarea name="admin_remarks" rows="3" required
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none"
                                              placeholder="Please provide a reason for rejecting this request..."></textarea>
                                    @error('admin_remarks')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                        class="w-full py-3 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reject Request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

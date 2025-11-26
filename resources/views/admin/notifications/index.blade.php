<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
            <p class="text-sm text-gray-500">
                System alerts for stock, payments, and orders.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-600 hover:text-gray-900">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">Recent Notifications</h2>
            <span class="text-xs text-gray-500">
                Total: {{ $notifications->total() }}
            </span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notif)
                <div class="px-4 py-3 flex items-start gap-3
                    {{ $notif->is_read ? 'bg-white' : 'bg-violet-50/70' }}">
                    <div class="mt-0.5">
                        @if($notif->type === 'low_stock')
                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                LS
                            </span>
                        @elseif($notif->type === 'payment_pending')
                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                Pay
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                !
                            </span>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">
                                {{ $notif->title ?? 'Notification' }}
                            </h3>
                            <span class="text-xs text-gray-400 whitespace-nowrap">
                                {{ $notif->created_at?->diffForHumans() }}
                            </span>
                        </div>

                        @if($notif->body)
                            <p class="mt-1 text-sm text-gray-700">
                                {{ $notif->body }}
                            </p>
                        @endif

                        @if($notif->data && is_array($notif->data))
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $notif->data['meta'] ?? '' }}
                            </p>
                        @endif
                    </div>

                    @if(!$notif->is_read)
                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                            New
                        </span>
                    @endif
                </div>
            @empty
                <div class="px-4 py-8 text-center text-gray-400 text-sm">
                    No notifications yet.
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

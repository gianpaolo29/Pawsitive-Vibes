<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div x-data="{
        // Confirm + submit mark-all-read
        markAllRead(url) {
            Swal.fire({
                title: 'Mark All as Read?',
                text: 'Are you sure you want to mark all notifications as read?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Mark All'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        },

        // Mark single notification as read (AJAX)
        markAsRead(event, readUrl) {
            const row = event.currentTarget;

            // Already marked read? Don't hit backend again.
            if (row.dataset.read === 'true') {
                return;
            }

            fetch(readUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    // Update UI
                    row.dataset.read = 'true';
                    row.classList.remove('bg-violet-50/70', 'hover:bg-violet-100');
                    row.classList.add('bg-white', 'hover:bg-gray-50');

                    const badge = row.querySelector('.notif-badge-new');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        }
    }" class="p-4 sm:p-6 lg:p-8">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifications 🔔</h1>
                <p class="text-sm text-gray-500">
                    System alerts for stock, payments, and orders.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Recent Notifications</h2>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="markAllRead('{{ route('admin.notifications.mark-all-read') }}')"
                        class="text-xs font-medium text-violet-600 hover:text-violet-800 hover:underline disabled:text-gray-400"
                        @disabled($notifications->where('is_read', false)->count() === 0)
                        title="Mark all unread notifications as read.">
                        Mark All as Read
                    </button>
                    <span class="text-sm font-medium text-gray-500">
                        Total: {{ $notifications->total() }}
                    </span>
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notif)
                    @php
                        $markReadUrl = route('admin.notifications.markRead', $notif->id);
                    @endphp

                    <div
                        class="px-4 py-3 flex items-start gap-3 cursor-pointer transition-colors duration-200
                            {{ $notif->is_read ? 'bg-white hover:bg-gray-50' : 'bg-violet-50/70 hover:bg-violet-100' }}"
                        data-read="{{ $notif->is_read ? 'true' : 'false' }}"
                        @click="markAsRead($event, '{{ $markReadUrl }}')"
                    >
                        <div class="mt-0.5 flex-shrink-0">
                            {{-- TYPE ICON/BADGE --}}
                            @if($notif->type === 'low_stock')
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01"/></svg>
                                </span>
                            @elseif($notif->type === 'payment_pending')
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM22 6l-10 7L2 6"/></svg>
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
                                <p class="mt-1 text-sm text-gray-700 line-clamp-2">
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
                            <span class="notif-badge-new mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700 flex-shrink-0">
                                New
                            </span>
                        @endif
                    </div>
                @empty
                    <div class="px-4 py-8 text-center text-gray-400 text-sm">
                        No notifications yet. 🎉
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $notifications->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('ok') || session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('ok') ?? session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                });
            @endif
        });
    </script>
</x-admin-layout>

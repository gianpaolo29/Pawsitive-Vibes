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
                        @disabled($notifications->whereNull('read_at')->count() === 0)
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
                        $isUnread = is_null($notif->read_at);
                        $data = $notif->data ?? [];
                        $title = $data['title'] ?? class_basename($notif->type);
                        $message = $data['message'] ?? ($data['body'] ?? 'You have a new notification.');
                        $notifType = $data['type'] ?? '';
                    @endphp

                    <div
                        class="px-4 py-3 flex items-start gap-3 cursor-pointer transition-colors duration-200
                            {{ $isUnread ? 'bg-violet-50/70 hover:bg-violet-100' : 'bg-white hover:bg-gray-50' }}"
                        data-read="{{ $isUnread ? 'false' : 'true' }}"
                        @click="markAsRead($event, '{{ $markReadUrl }}')"
                    >
                        <div class="mt-0.5 flex-shrink-0">
                            @if($notifType === 'low_stock' || str_contains($notif->type, 'LowStock'))
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01"/></svg>
                                </span>
                            @elseif(str_contains($notif->type, 'GcashPayment'))
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </span>
                            @elseif(str_contains($notif->type, 'NewOrder'))
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                                </span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $title }}
                                </h3>
                                <span class="text-xs text-gray-400 whitespace-nowrap">
                                    {{ $notif->created_at?->diffForHumans() }}
                                </span>
                            </div>

                            <p class="mt-1 text-sm text-gray-700 line-clamp-2">
                                {{ $message }}
                            </p>
                        </div>

                        @if($isUnread)
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

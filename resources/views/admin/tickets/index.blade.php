<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Support Tickets</h1>
                <p class="text-sm text-gray-500 mt-1">Manage account reactivation requests</p>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @foreach([
                ['label' => 'All', 'key' => 'all', 'color' => 'violet', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z'],
                ['label' => 'Open', 'key' => 'open', 'color' => 'blue', 'icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z'],
                ['label' => 'In Progress', 'key' => 'in_progress', 'color' => 'yellow', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Resolved', 'key' => 'resolved', 'color' => 'green', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Rejected', 'key' => 'rejected', 'color' => 'red', 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as $stat)
                <a href="{{ route('admin.tickets.index', ['status' => $stat['key']]) }}"
                   class="bg-white rounded-xl border {{ $status === $stat['key'] ? 'border-'.$stat['color'].'-400 ring-2 ring-'.$stat['color'].'-100' : 'border-gray-100' }} p-4 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-{{ $stat['color'] }}-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-800">{{ $counts[$stat['key']] }}</p>
                            <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Tickets Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($tickets->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-violet-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No tickets found</h3>
                    <p class="text-gray-500 text-sm">There are no support tickets{{ $status !== 'all' ? ' with this status' : '' }}.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ticket</th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Submitted</th>
                                <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-mono font-semibold text-violet-700">{{ $ticket->ticket_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $ticket->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $ticket->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-700 truncate max-w-[200px]">{{ $ticket->subject }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $ticket->status_badge['color'] }}">
                                            {{ $ticket->status_badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-50 text-violet-700 rounded-lg text-xs font-semibold hover:bg-violet-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $tickets->appends(['status' => $status])->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

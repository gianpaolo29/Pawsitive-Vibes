<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="flex flex-col gap-6">

        {{-- PAGE HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Customer Management</h1>
                <p class="text-sm text-gray-500">View, manage, and monitor all registered customers.</p>
            </div>
            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center gap-2 bg-violet-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-violet-700 shadow-sm transition">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                Add Customer
            </a>
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-violet-500">
                <div class="p-3 rounded-xl bg-violet-50 text-violet-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_customers'] ?? 0) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-emerald-500">
                <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">New This Month</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['new_this_month'] ?? 0) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-amber-500">
                <div class="p-3 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Deactivated</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'CUSTOMER')->where('is_active', false)->count() }}</p>
                </div>
            </div>
        </div>

        {{-- SEARCH WITH SUGGESTIONS --}}
        <div x-data="{
                query: '{{ $q }}',
                results: [],
                open: false,
                loading: false,
                selected: -1,
                debounceTimer: null,
                search() {
                    clearTimeout(this.debounceTimer);
                    if (this.query.length < 2) { this.results = []; this.open = false; return; }
                    this.loading = true;
                    this.debounceTimer = setTimeout(() => {
                        fetch('{{ route('admin.search.customers') }}?q=' + encodeURIComponent(this.query), {
                            headers: { 'Accept': 'application/json' }
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.results = data;
                            this.open = data.length > 0;
                            this.selected = -1;
                            this.loading = false;
                        })
                        .catch(() => { this.loading = false; });
                    }, 250);
                },
                navigate(e) {
                    if (!this.open) return;
                    if (e.key === 'ArrowDown') { e.preventDefault(); this.selected = Math.min(this.selected + 1, this.results.length - 1); }
                    if (e.key === 'ArrowUp') { e.preventDefault(); this.selected = Math.max(this.selected - 1, 0); }
                    if (e.key === 'Enter' && this.selected >= 0) { e.preventDefault(); window.location.href = this.results[this.selected].url; }
                    if (e.key === 'Escape') { this.open = false; }
                },
                go(url) { window.location.href = url; }
             }"
             @click.away="open = false"
             @keydown="navigate($event)"
             class="bg-white rounded-xl shadow-sm p-4"
        >
            <form method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full sm:flex-grow">
                    <svg class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 19l-6-6M5 11a6 6 0 1112 0 6 6 0 01-12 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <input type="text" name="q"
                           x-model="query"
                           @input="search()"
                           @focus="if (results.length) open = true"
                           placeholder="Search by name, username, or email..."
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm"
                           autocomplete="off" />

                    {{-- Loading --}}
                    <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-4 w-4 text-violet-400" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>

                    {{-- Suggestions dropdown --}}
                    <div x-show="open" x-transition
                         class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden max-h-[360px] overflow-y-auto">

                        <template x-for="(item, index) in results" :key="item.id">
                            <div @click="go(item.url)"
                                 :class="{ 'bg-violet-50': selected === index }"
                                 class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-violet-50 transition border-b border-gray-100 last:border-0"
                                 @mouseenter="selected = index">

                                <div class="h-9 w-9 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                     :class="item.active ? 'bg-violet-100 text-violet-700' : 'bg-gray-200 text-gray-500'"
                                     x-text="item.initials"></div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-gray-900 truncate" x-text="item.name"></span>
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded-full"
                                              :class="item.active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'"
                                              x-text="item.active ? 'Active' : 'Deactivated'"></span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-0.5">
                                        <span x-text="'@' + item.username"></span>
                                        <span>&middot;</span>
                                        <span x-text="item.email" class="truncate"></span>
                                    </div>
                                </div>

                                <svg class="flex-shrink-0 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </template>

                        <div x-show="results.length === 0 && query.length >= 2 && !loading" class="px-4 py-6 text-center text-sm text-gray-400">
                            No customers found for "<span x-text="query" class="font-medium text-gray-600"></span>"
                        </div>
                    </div>
                </div>

                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-violet-600 text-white text-sm font-semibold hover:bg-violet-700 transition shrink-0">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 19l-6-6M5 11a6 6 0 1112 0 6 6 0 01-12 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Search
                </button>
            </div>

            {{-- Filters row --}}
            <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-gray-100">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Filters:</span>

                {{-- Status --}}
                <div class="flex items-center gap-1.5">
                    <span class="text-xs text-gray-500">Status:</span>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('status', 'page'), ['status' => ''])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ !$status ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('page'), ['status' => 'active'])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ $status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Active
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('page'), ['status' => 'deactivated'])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ $status === 'deactivated' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Deactivated
                    </a>
                </div>

                <span class="text-gray-300">|</span>

                {{-- Date --}}
                <div class="flex items-center gap-1.5">
                    <span class="text-xs text-gray-500">Joined:</span>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('date', 'page'), ['date' => ''])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ !$date ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All Time
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('page'), ['date' => 'today'])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ $date === 'today' ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Today
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('page'), ['date' => '7days'])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ $date === '7days' ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        7 Days
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('page'), ['date' => '30days'])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ $date === '30days' ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        30 Days
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->except('page'), ['date' => 'this_year'])) }}"
                       class="px-2.5 py-1 rounded-full text-xs font-medium transition {{ $date === 'this_year' ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        This Year
                    </a>
                </div>

                @if($q || $status || $date)
                    <a href="{{ route('admin.customers.index') }}"
                       class="ml-auto inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Clear All
                    </a>
                @endif
            </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        @php
                            $arrow = fn($k) => ($sort ?? null) === $k ? (($dir ?? null) === 'asc' ? ' ↑' : ' ↓') : '';
                            $link  = fn($k) => request()->fullUrlWithQuery([
                                'sort' => $k,
                                'dir'  => (($sort ?? null) === $k && ($dir ?? null) === 'asc') ? 'desc' : 'asc',
                                'q'    => $q,
                            ]);
                        @endphp
                        <tr class="text-xs text-gray-500 uppercase tracking-wider">
                            <th class="px-3 sm:px-5 py-3 text-left"><a href="{{ $link('fname') }}" class="hover:text-violet-600">Name{!! $arrow('fname') !!}</a></th>
                            <th class="px-3 sm:px-5 py-3 text-left"><a href="{{ $link('username') }}" class="hover:text-violet-600">Username{!! $arrow('username') !!}</a></th>
                            <th class="px-3 sm:px-5 py-3 text-left"><a href="{{ $link('email') }}" class="hover:text-violet-600">Email{!! $arrow('email') !!}</a></th>
                            <th class="px-3 sm:px-5 py-3 text-center">Status</th>
                            <th class="px-3 sm:px-5 py-3 text-left"><a href="{{ $link('created_at') }}" class="hover:text-violet-600">Joined{!! $arrow('created_at') !!}</a></th>
                            <th class="px-3 sm:px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($customers as $c)
                            <tr class="hover:bg-gray-50/50 transition {{ !$c->is_active ? 'opacity-60' : '' }}">
                                <td class="px-3 py-3 sm:px-5 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full flex items-center justify-center text-sm font-bold {{ $c->is_active ? 'bg-violet-100 text-violet-700' : 'bg-gray-200 text-gray-500' }}">
                                            {{ strtoupper(substr($c->fname, 0, 1)) }}{{ strtoupper(substr($c->lname, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $c->fname }} {{ $c->lname }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-gray-600">{{ $c->username }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-gray-600">{{ $c->email }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    @if($c->is_active)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Deactivated
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 whitespace-nowrap text-gray-500">{{ $c->created_at?->format('M d, Y') }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                        <a href="{{ route('admin.customers.edit', $c) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-violet-700 bg-violet-50 hover:bg-violet-100 transition">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            Edit
                                        </a>

                                        {{-- Toggle Active/Deactivate --}}
                                        <button type="button"
                                            onclick="confirmToggle('{{ route('admin.customers.toggle', $c) }}', '{{ $c->fname }} {{ $c->lname }}', {{ $c->is_active ? 'true' : 'false' }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium transition {{ $c->is_active ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }}">
                                            @if($c->is_active)
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                Deactivate
                                            @else
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                Activate
                                            @endif
                                        </button>

                                        <button type="button"
                                            onclick="confirmDelete('{{ route('admin.customers.destroy', $c) }}', '{{ $c->fname }} {{ $c->lname }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 transition">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <div class="text-gray-400">
                                        <svg class="h-12 w-12 mx-auto mb-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <p class="text-sm font-medium">No customers found.</p>
                                        <p class="text-xs mt-1">Try adjusting your search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($customers->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $customers->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmToggle(url, name, isActive) {
            const action = isActive ? 'deactivate' : 'activate';
            const color = isActive ? '#dc2626' : '#059669';
            const icon = isActive ? 'warning' : 'question';

            Swal.fire({
                title: `${action.charAt(0).toUpperCase() + action.slice(1)} Account?`,
                html: isActive
                    ? `<b>${name}</b> will no longer be able to log in until reactivated.`
                    : `<b>${name}</b> will be able to log in again.`,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: color,
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${action}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PATCH';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmDelete(url, name) {
            Swal.fire({
                title: 'Delete Account?',
                html: `Are you sure you want to permanently delete <b>${name}</b>'s account? This cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
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

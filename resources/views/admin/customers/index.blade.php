<x-admin-layout>
    <div class="flex flex-col gap-6">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-bold text-gray-900">Customers Management</h1>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.customers.create') }}"
                    class="inline-flex items-center gap-2 bg-violet-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-violet-700">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                    Add New Customer
                </a>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4 border-t-4 border-blue-400">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l10 5.5v11L12 22 2 17.5v-11L12 2z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_customers'] ?? 0) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4 border-t-4 border-purple-400">
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7v10h18V7M7 7v10M17 7v10"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">New This Month</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['new_this_month'] ?? 0) }}</p>
                </div>
            </div>
            
        </div>

        <form method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:flex-grow">
                <svg class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 19l-6-6M5 11a6 6 0 1 1 12 0 6 6 0 0 1-12 0z"/></svg>
                <input type="text" name="q" value="{{ $q }}"
                        placeholder="Search by name, username, or email"
                        class="w-full pl-10 pr-4 rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
            </div>

            <a href="{{ route('admin.customers.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap w-full sm:w-auto sm:ml-auto flex items-center justify-center sm:justify-start">
                <svg class="h-4 w-4 inline-block mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 4H8l-7 16h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM12 9v6M9 12h6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Clear Filters
            </a>
        </form>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                    @php
                        // Assuming $sort and $dir are passed from the controller
                        $arrow = fn($k) => ($sort ?? null) === $k ? (($dir ?? null) ==='asc'?' ↑':' ↓') : '';
                        $link  = fn($k) => request()->fullUrlWithQuery([
                            'sort'=>$k,
                            'dir'=> (($sort ?? null) === $k && ($dir ?? null) === 'asc') ? 'desc':'asc',
                            'q' => $q, // Persist search query
                        ]);
                    @endphp
                    <tr>
                        <th class="px-4 py-3 text-left"><a href="{{ $link('fname') }}">Name{!! $arrow('fname') !!}</a></th>
                        <th class="px-4 py-3 text-left"><a href="{{ $link('username') }}">Username{!! $arrow('username') !!}</a></th>
                        <th class="px-4 py-3 text-left"><a href="{{ $link('email') }}">Email{!! $arrow('email') !!}</a></th>
                        <th class="px-4 py-3 text-left"><a href="{{ $link('created_at') }}">Created{!! $arrow('created_at') !!}</a></th>
                        <th class="px-4 py-3 text-right whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($customers as $c)
                        <tr class="text-gray-700 hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $c->fname }} {{ $c->lname }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $c->username }}</td>
                            <td class="px-4 py-3">{{ $c->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $c->created_at?->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.customers.edit', $c) }}" class="text-violet-600 hover:text-violet-700 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.customers.destroy', $c) }}" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">No customers found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
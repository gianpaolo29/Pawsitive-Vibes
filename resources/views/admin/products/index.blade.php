<x-admin-layout>
    {{-- SweetAlert2 CDN (Include this in your <head> or layout file if not already global) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="flex flex-col gap-6">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-bold text-gray-900">Products Management</h1>

            <div class="flex items-center gap-2 flex-shrink-0">

                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center gap-2 bg-violet-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-violet-700">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                    Add New Product
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
            <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4 border-t-4 border-blue-400">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l10 5.5v11L12 22 2 17.5v-11L12 2z"/></svg>
                </div>
                <div>
                <p class="text-sm font-medium text-gray-500">Total Products</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4 border-t-4 border-emerald-400">
                <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 6L9 17l-5-5"/></svg>
                </div>
                <div>
                <p class="text-sm font-medium text-gray-500">Active Products</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_products']) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4 border-t-4 border-amber-400">
                <div class="p-3 rounded-xl bg-amber-50 text-amber-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.29 3.86L1.82 18h20.36L13.71 3.86zM12 9v4M12 17h.01"/></svg>
                </div>
                <div>
                <p class="text-sm font-medium text-gray-500">Low Stock Alerts <span class="text-xs text-gray-400">( < {{ $lowStock }})</span></p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['low_stock']) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4 border-t-4 border-purple-400">
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7v10h18V7M7 7v10M17 7v10"/></svg>
                </div>
                <div>
                <p class="text-sm font-medium text-gray-500">Categories</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['categories']) }}</p>
                </div>
            </div>
        </div>

        <form method="GET" class="flex flex-col sm:flex-row items-center gap-3">
        
            <div class="relative w-full sm:w-auto sm:flex-grow">
                <svg class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 19l-6-6M5 11a6 6 0 1 1 12 0 6 6 0 0 1-12 0z"/></svg>
                <input type="text" name="q" value="{{ $q }}"
                    placeholder="Search products by name"
                    class="w-full pl-10 pr-4 rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500 sm:w-64 md:w-80" />
            </div>

            <select name="category_id" class="w-full sm:w-auto rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500 min-w-[120px]">
                <option value="">All Categories</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected((int)$category_id === $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>

            <select name="status" class="w-full sm:w-auto rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500 min-w-[120px]">
                <option value="">All Status</option>
                <option value="active" @selected($status==='active')>Active</option>
                <option value="inactive" @selected($status==='inactive')>Inactive</option>
            </select>
            
            <select name="stock_status" class="w-full sm:w-auto rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500 min-w-[120px]">
                <option value="">All Stock</option>
                <option value="normal" @selected($stockStatus==='normal')>Normal Stock</option>
                <option value="low" @selected($stockStatus==='low')>Low Stock</option>
                <option value="out" @selected($stockStatus==='out')>Out of Stock</option>
            </select>


            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="dir" value="{{ $dir }}">

            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap w-full sm:w-auto sm:ml-auto">
                <svg class="h-4 w-4 inline-block mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 4H8l-7 16h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM12 9v6M9 12h6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Clear Filters
            </a>
            
        </form>

    
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                    @php
                    $arrow = fn($k) => $sort === $k ? ($dir==='asc'?' ↑':' ↓') : '';
                    $link  = fn($k) => request()->fullUrlWithQuery([
                        'sort'=>$k,
                        'dir'=> ($sort===$k && $dir==='asc') ? 'desc':'asc'
                    ]);
                    @endphp
                    <tr>
                    <th class="px-4 py-3 text-left w-10">
                        <input type="checkbox" class="rounded text-violet-600 border-gray-300 focus:ring-violet-500">
                    </th>
                    <th class="px-4 py-3 text-left w-10"></th>
                    <th class="px-4 py-3 text-left whitespace-nowrap"><a href="{{ $link('name') }}">Product{!! $arrow('name') !!}</a></th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Category</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap"><a href="{{ $link('price') }}">Price{!! $arrow('price') !!}</a></th>
                    <th class="px-4 py-3 text-left whitespace-nowrap"><a href="{{ $link('stock') }}">Stock{!! $arrow('stock') !!}</a></th>
                    <th class="px-4 py-3 text-left whitespace-nowrap"><a href="{{ $link('is_active') }}">Status{!! $arrow('is_active') !!}</a></th>
                    <th class="px-4 py-3 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $p)
                    <tr class="text-gray-700 hover:bg-gray-50">
                        <td class="px-4 py-3 w-10">
                        <input type="checkbox" class="rounded text-violet-600 border-gray-300 focus:ring-violet-500">
                        </td>
                        <td class="px-4 py-3 w-10">
                        <div class="h-10 w-10 rounded-lg bg-gray-100 overflow-hidden grid place-content-center">
                            @if($p->thumb_url)
                            <img src="{{ $p->thumb_url }}" class="h-10 w-10 object-cover" alt="{{ $p->name }}">
                            @else
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M4 5h16v14H4zM4 15l4-4 4 4 4-3 4 3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            @endif
                        </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $p->name }}</div> 
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100">
                            {{ $p->category?->name ?? '—' }}
                        </span>
                        </td>
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">₱{{ number_format($p->price,2) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold
                            @if($p->stock <= 0)
                            bg-rose-100 text-rose-800
                            @elseif($p->stock < 10)
                            bg-amber-100 text-amber-800
                            @else
                            bg-emerald-100 text-emerald-800
                            @endif">
                            {{ $p->stock <= 0 ? 'Out of Stock' : $p->stock }}
                        </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                        <form method="POST" action="{{ route('admin.products.toggle',$p) }}">
                            @csrf @method('PATCH')
                            <button class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold whitespace-nowrap
                            {{ $p->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $p->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-3">
                            <a href="{{ route('admin.products.edit',$p) }}" class="text-violet-600 hover:text-violet-700 font-medium">Edit</a>
                            
                            {{-- MODIFIED: Replaced original form submission with SweetAlert trigger --}}
                            <button 
                                type="button" 
                                onclick="confirmDelete('{{ route('admin.products.destroy', $p) }}', '{{ $p->name }}')" 
                                class="text-rose-600 hover:text-rose-700 font-medium"
                            >Delete</button>
                        </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-10 text-center text-gray-500">No products found.</td></tr>
                    @endforelse
                </tbody>
                </table>
            </div>

        
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------------------------- --}}
    {{-- CLIENT-SIDE JAVASCRIPT FOR SWEETALERT AND FLASH MESSAGES           --}}
    {{-- ---------------------------------------------------------------- --}}
    <script>
        /**
         * Function to confirm deletion using SweetAlert2
         * @param {string} deleteUrl - The Laravel route for the DELETE action.
         * @param {string} productName - The name of the product being deleted.
         */
        function confirmDelete(deleteUrl, productName) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete the product: " + productName + ". This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // rose-600
                cancelButtonColor: '#6b7280', // gray-500
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a temporary form to submit the DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    
                    // Add CSRF token (Use Blade helper to ensure token is available)
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}'; 
                    form.appendChild(csrfInput);

                    // Add DELETE method spoofing
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
        
        // SweetAlert Flash Message Handling for Success/Error/Info (Applies to Create, Update, and Delete)
        document.addEventListener('DOMContentLoaded', function() {
            // Check for success message flash
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            // Check for error message flash
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
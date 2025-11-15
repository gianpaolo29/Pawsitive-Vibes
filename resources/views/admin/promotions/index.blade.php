{{-- resources/views/admin/promotions/index.blade.php --}}
<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Promotions</h1>
            <p class="text-sm text-gray-500">Manage discount codes and promos.</p>
        </div>
        <a href="{{ route('admin.promotions.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-violet-700">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
            </svg>
            New Promotion
        </a>
    </div>

    @if(session('ok'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('ok') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow border border-gray-100 mb-4">
        <form method="get" class="p-4 flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <svg class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 19l-6-6M5 11a6 6 0 1 1 12 0 6 6 0 0 1-12 0z"/>
                </svg>
                <input type="text"
                       name="q"
                       value="{{ $q }}"
                       placeholder="Search by name or code"
                       class="w-full pl-9 pr-3 py-2 border rounded-lg text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500">
            </div>

            <select name="status"
                    class="px-3 py-2 border rounded-lg text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                <option value="">All Status</option>
                <option value="active" @selected($status === 'active')>Active</option>
                <option value="inactive" @selected($status === 'inactive')>Inactive</option>
            </select>

            <button type="submit"
                    class="px-4 py-2 text-sm rounded-lg border border-gray-300 hover:bg-gray-50">
                Filter
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wide">
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Code</th>
                        <th class="px-4 py-2 text-left">Discount</th>
                        <th class="px-4 py-2 text-left">Min Order</th>
                        <th class="px-4 py-2 text-left">Validity</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($promotions as $promo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                <div class="font-medium text-gray-900">{{ $promo->name }}</div>
                                @if($promo->description)
                                    <div class="text-xs text-gray-500 line-clamp-1">{{ $promo->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-violet-50 text-violet-700 border border-violet-200">
                                    {{ $promo->code }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($promo->discount_type === 'percent')
                                    {{ $promo->discount_value }}%
                                @else
                                    ₱{{ number_format($promo->discount_value, 2) }}
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($promo->min_order_amount)
                                    ₱{{ number_format($promo->min_order_amount, 2) }}
                                @else
                                    <span class="text-xs text-gray-400">None</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-xs text-gray-600">
                                @if($promo->starts_at)
                                    {{ $promo->starts_at->format('M j, Y') }}
                                @else
                                    <span class="text-gray-400">No start</span>
                                @endif
                                –
                                @if($promo->ends_at)
                                    {{ $promo->ends_at->format('M j, Y') }}
                                @else
                                    <span class="text-gray-400">No end</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                    @class([
                                        'bg-green-100 text-green-800' => $promo->is_active && $promo->is_currently_valid,
                                        'bg-yellow-100 text-yellow-800' => $promo->is_active && ! $promo->is_currently_valid,
                                        'bg-gray-100 text-gray-700' => ! $promo->is_active,
                                    ])
                                ">
                                    @if(!$promo->is_active)
                                        Inactive
                                    @elseif($promo->is_currently_valid)
                                        Active
                                    @else
                                        Scheduled/Expired
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex justify-end items-center gap-2">
                                    <form method="POST"
                                          action="{{ route('admin.promotions.toggle', $promo) }}"
                                          onsubmit="return confirm('Toggle status?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">
                                            {{ $promo->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.promotions.edit', $promo) }}"
                                       class="text-xs px-2 py-1 rounded border border-blue-300 text-blue-700 hover:bg-blue-50">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.promotions.destroy', $promo) }}"
                                          onsubmit="return confirm('Delete this promotion?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border border-red-300 text-red-700 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">
                                No promotions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-100">
            {{ $promotions->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>

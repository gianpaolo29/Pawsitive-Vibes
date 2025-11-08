<style>[x-cloak]{ display:none !important; }</style>

    <div x-cloak x-show="$parent.showProductModal" x-transition.opacity
        @keydown.escape.window="$parent.showProductModal = false"
        class="fixed inset-0 z-[100] flex items-center justify-center">

    <div class="absolute inset-0 bg-black/40" @click="$parent.showProductModal = false"></div>

    <div class="relative bg-white w-full max-w-3xl rounded-2xl shadow-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Select Product</h3>
        <button type="button" class="p-2 rounded-lg hover:bg-gray-100"
                @click="$parent.showProductModal = false">✕</button>
        </div>

        <div class="mb-3">
        <input type="text" placeholder="Search products…"
                class="w-full rounded-lg border-gray-300">
        </div>

        <div class="max-h-[60vh] overflow-y-auto divide-y divide-gray-100">
        @forelse(($products ?? []) as $p)
            @php
            $payload = [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => (float) $p->price,
                'unit'      => $p->unit ?? '',
                'image_url' => $p->image_url ?? null,
            ];
            @endphp
            <div class="py-3 flex items-center gap-3">
            <img src="{{ $p->image_url ?? 'https://via.placeholder.com/48' }}"
                class="w-12 h-12 rounded-md object-cover" alt="">
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                <p class="font-medium text-gray-900 truncate">{{ $p->name }}</p>
                <span class="text-sm text-gray-700">₱{{ number_format($p->price, 2) }}</span>
                </div>
                <p class="text-xs text-gray-500">Unit: {{ $p->unit ?? '—' }}</p>
            </div>

            <button type="button"
                    class="px-3 py-1.5 text-sm rounded-lg bg-violet-600 text-white hover:bg-violet-700"
                    @click="$parent.addItem(@json($payload)); $parent.showProductModal = false;">
                Add
            </button>
            </div>
        @empty
            <div class="py-10 text-center text-gray-500">
            No products found. Make sure you pass <code>$products</code> to the view.
            </div>
        @endforelse
        </div>

        <div class="mt-5 flex justify-end">
        <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50"
                @click="$parent.showProductModal = false">Close</button>

        </div>
    </div>
    </div>
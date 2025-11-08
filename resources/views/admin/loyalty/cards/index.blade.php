<x-admin-layout>
    <!-- @php
        // Hardcoded data example for UI testing
        $cardsData = [
            (object)['customer_name' => 'Alice Johnson', 'email' => 'alice@example.com', 'stickers_balance' => 7, 'id' => 1],
            (object)['customer_name' => 'Bob Smith', 'email' => 'bob@example.com', 'stickers_balance' => 10, 'id' => 2],
            (object)['customer_name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'stickers_balance' => 3, 'id' => 3],
            (object)['customer_name' => 'Diana Prince', 'email' => 'diana@example.com', 'stickers_balance' => 9, 'id' => 4],
            (object)['customer_name' => 'Ethan Hunt', 'email' => 'ethan@example.com', 'stickers_balance' => 1, 'id' => 5],
        ];

        $q = null; 

        $paginationMessage = "";
    @endphp
    <div class="flex flex-col gap-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Loyalty Cards</h1>
            <form method="GET" class="relative">
                <input type="text" name="q" value="{{ $q }}" placeholder="Search customer..."
                       class="pl-10 pr-3 py-2 rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                <svg class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 19l-6-6M5 11a6 6 0 1 1 12 0z"/></svg>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Stickers</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($cardsData as $card)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $card->customer_name }}</td>
                            <td class="px-4 py-3">{{ $card->email }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $card->stickers_balance }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.loyalty.cards.show', $card->id) }}" class="text-violet-600 font-medium">View</a>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($cardsData) === 0)
                         <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">No records.</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100 text-sm text-gray-600">
                {{ $paginationMessage }}
            </div>
        </div>
    </div> -->
</x-admin-layout>
<x-admin-layout>
    <!-- @php
        $card = (object)[
            'stickers_balance' => 8,
            'id' => 101, // Mock ID for routing
            'user' => (object)[
                'fname' => 'Clark',
                'lname' => 'Kent',
                'email' => 'clark.kent@dailyplanet.com',
            ],
        ];

        $eventsData = [
            (object)[
                'created_at' => new DateTime('2025-10-27 16:15:00'),
                'type' => 'purchase',
                'transaction_id' => 'TX1002',
                'stickers' => 10,
            ],
            (object)[
                'created_at' => new DateTime('2025-10-27 09:00:00'),
                'type' => 'redemption',
                'transaction_id' => 'RED345',
                'stickers' => -5,
            ],
            (object)[
                'created_at' => new DateTime('2025-10-26 14:45:00'),
                'type' => 'adjustment',
                'transaction_id' => null, // Manual adjustment
                'stickers' => -2,
            ],
            (object)[
                'created_at' => new DateTime('2025-10-25 10:30:00'),
                'type' => 'purchase',
                'transaction_id' => 'TX1001',
                'stickers' => 5,
            ],
        ];

        $card->events = $eventsData;

        $errors = (object)['has' => fn($key) => false, 'first' => fn($key) => null];
        $message = null; // Used in @error block
    @endphp

    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $card->user->fname }} {{ $card->user->lname }}
                </h1>
                <p class="text-gray-500">{{ $card->user->email }}</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Stickers Balance</div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $card->stickers_balance }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <form method="POST" action="/admin/loyalty/cards/{{ $card->id }}/adjust" class="flex items-end gap-3">
                @csrf
                <div>
                    <label for="stickers" class="text-sm text-gray-700">Adjust Stickers (+/-)</label>
                    <input type="number" name="stickers" id="stickers" step="1" class="mt-1 w-40 rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" placeholder="+1 or -1">
                    
                    @if($errors->has('stickers'))<div class="text-rose-600 text-sm">{{ $errors->first('stickers') }}</div>@endif
                </div>
                <button type="submit" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">Apply</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">When</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Tx</th>
                        <th class="px-4 py-3 text-left">Δ Stickers</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($card->events as $e)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $e->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3">{{ ucfirst($e->type) }}</td>
                            <td class="px-4 py-3">{{ $e->transaction_id ?? '—' }}</td>
                            <td class="px-4 py-3 font-semibold {{ $e->stickers >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $e->stickers >= 0 ? '+' : '' }}{{ $e->stickers }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">No events yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> -->
</x-admin-layout>
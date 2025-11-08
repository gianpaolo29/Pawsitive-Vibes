<x-admin-layout>
    @php
        $status = request('status', '');

        // Mock objects for nesting
        $mockUser1 = (object)['fname' => 'Lois', 'lname' => 'Lane'];
        $mockUser2 = (object)['fname' => 'Bruce', 'lname' => 'Wayne'];
        
        // --- UPDATED MOCK REWARDS (Treats and Accessories Only) ---
        $mockReward1 = (object)['name' => 'Bag of Premium Treats'];
        $mockReward2 = (object)['name' => 'Dog Leash/Collar Set']; 

        // Hardcoded Redemptions Data for UI testing
        $redemptionsData = [
            (object)[
                'id' => 1,
                'stickers_spent' => 9,
                'status' => 'pending',
                'card' => (object)['user' => $mockUser1],
                'reward' => $mockReward1,
            ],
            (object)[
                'id' => 2,
                'stickers_spent' => 18,
                'status' => 'approved',
                'card' => (object)['user' => $mockUser2],
                'reward' => $mockReward2,
            ],
            (object)[
                'id' => 3,
                'stickers_spent' => 9,
                'status' => 'rejected',
                'card' => (object)['user' => $mockUser1],
                'reward' => $mockReward2,
            ],
            (object)[
                'id' => 4,
                'stickers_spent' => 9,
                'status' => 'cancelled',
                'card' => (object)['user' => $mockUser2],
                'reward' => $mockReward1,
            ],
            (object)[
                'id' => 5,
                'stickers_spent' => 9,
                'status' => 'pending',
                'card' => (object)['user' => $mockUser1],
                'reward' => $mockReward1,
            ],
        ];

        $redemptions = collect($redemptionsData)->filter(function ($r) use ($status) {
            return empty($status) || $r->status === $status;
        });

        $paginationMessage = "";
    @endphp

    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Loyalty Redemptions</h1>
            <form method="GET">
                <select name="status" onchange="this.form.submit()" class="rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                    <option value="">All Status</option>
                    @foreach(['pending','approved','rejected','cancelled'] as $s)
                        <option value="{{ $s }}" @selected($status===$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Reward</th>
                        <th class="px-4 py-3 text-left">Stickers</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($redemptions as $r)
                        <tr>
                            <td class="px-4 py-3">{{ $r->card->user->fname }} {{ $r->card->user->lname }}</td>
                            <td class="px-4 py-3">{{ $r->reward->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-rose-600 font-semibold">-{{ $r->stickers_spent }}</td>
                            <td class="px-4 py-3 capitalize">
                                @if($r->status === 'approved')
                                    <span class="text-emerald-700 font-medium">{{ $r->status }}</span>
                                @elseif($r->status === 'pending')
                                    <span class="text-yellow-600 font-medium">{{ $r->status }}</span>
                                @else
                                    <span class="text-gray-500 font-medium">{{ $r->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if($r->status==='pending')
                                    <form method="POST" action="/admin/loyalty/redemptions/{{ $r->id }}/approve" class="inline" onsubmit="return false;">
                                        @csrf <button class="text-emerald-600 font-medium hover:text-emerald-700">Approve</button>
                                    </form>
                                    <form method="POST" action="/admin/loyalty/redemptions/{{ $r->id }}/reject" class="inline ml-3" onsubmit="return false;">
                                        @csrf <button class="text-rose-600 font-medium hover:text-rose-700">Reject</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">No redemptions found for the current filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100 text-sm text-gray-600">
                {{ $paginationMessage }}
            </div>
        </div>
    </div>
</x-admin-layout>
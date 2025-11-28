<x-admin-layout>
    <div class="max-w-7xl mx-auto">
        <table>
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email Address</th>
                    <th class="px-4 py-3 text-left">Phone Number</th>
                    <th class="px-4 py-3 text-left">Donation Amount</th>
                    <th class="px-4 py-3 text-left">Receipt</th>
                    <th class="px-4 py-3 text-left">Details</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($donations as $donation)
                    <tr class="text-gray-700 hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap">{{$donation->name}}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{$donation->email}}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{$donation->phone}}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{$donation->total_amount}}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a target="_blank" href="{{asset($donation->receipt_url)}}">View Receipt</a>
                        </td>

                        @if($donation->type === 'cash')
                            <td class="px-4 py-3 whitespace-nowrap">
                                
                            </td>
                        @else
                            <td class="px-4 py-3 whitespace-nowrap">
                                <ul>
                                    @foreach($donation->items as $item)
                                        <li>{{$item->product->name}} X {{$item->quantity}} = ₱{{$item->line_total}}</li>
                                    @endforeach
                                </ul>
                            </td>
                        @endif

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($donation->is_verified)
                                <p class="cursor-pointer bg-green-400 text-green-800 rounded-md px-4 py-1.5 text-sm">Verified</p>
                            @else
                                <form method="POST" action="{{ route('admin.donations.verify', ['donation' => $donation]) }}">
                                    @csrf
                                    <button type="submit" class="cursor-pointer bg-gray-400 text-gray-800 rounded-md px-4 py-1.5 text-sm">Verify</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>

<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Customer Messages</h1>
                <p class="text-sm text-gray-500 mt-1">Manage customer conversations</p>
            </div>
        </div>

        @if($conversations->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-violet-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-violet-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No messages yet</h3>
                <p class="text-gray-500">Customer messages will appear here when they start chatting.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($conversations as $convo)
                    <a href="{{ $convo['url'] }}"
                       class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-violet-200 transition-all duration-200 block group">
                        <div class="flex items-start gap-4">
                            <!-- Avatar -->
                            <div class="relative w-12 h-12 bg-gradient-to-br {{ $convo['type'] === 'guest' ? 'from-amber-500 to-orange-600' : 'from-violet-500 to-purple-600' }} rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0">
                                {{ $convo['initials'] }}
                                @if($convo['type'] === 'guest')
                                    <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-amber-400 rounded-full flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-800 group-hover:text-violet-700 transition-colors truncate">
                                        {{ $convo['name'] }}
                                        @if($convo['type'] === 'guest')
                                            <span class="text-xs font-normal text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-full ml-1">Guest</span>
                                        @endif
                                    </h3>
                                    @if($convo['unread_count'] > 0)
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full shrink-0">
                                            {{ $convo['unread_count'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 truncate mt-1">{{ $convo['email'] }}</p>

                                @if($convo['last_message'])
                                    <p class="text-sm text-gray-400 truncate mt-2">
                                        @if($convo['last_message']->sender_type === 'admin')
                                            <span class="text-violet-400">You:</span>
                                        @endif
                                        {{ $convo['last_message']->message }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $convo['last_message']->created_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-admin-layout>

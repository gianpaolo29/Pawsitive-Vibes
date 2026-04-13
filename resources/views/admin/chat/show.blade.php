<x-admin-layout>
    @php
        $isGuest = ($chatType === 'guest');
        $replyUrl = $isGuest
            ? route('admin.chat.reply', 'guest') . '?type=guest&session=' . $sessionId
            : route('admin.chat.reply', $user->id) . '?type=user';
        $messagesUrl = $isGuest
            ? route('admin.chat.messages', 'guest') . '?type=guest&session=' . $sessionId
            : route('admin.chat.messages', $user->id) . '?type=user';
        $typingUrl = $isGuest
            ? route('admin.chat.typing', 'guest') . '?type=guest&session=' . $sessionId
            : route('admin.chat.typing', $user->id) . '?type=user';
        $customerTypingUrl = $isGuest
            ? route('admin.chat.customerTyping', 'guest') . '?type=guest&session=' . $sessionId
            : route('admin.chat.customerTyping', $user->id) . '?type=user';
    @endphp

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="adminChat()" x-init="init()">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.chat.index') }}" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br {{ $isGuest ? 'from-amber-500 to-orange-600' : 'from-violet-500 to-purple-600' }} rounded-full flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr($user->fname, 0, 1)) }}{{ $isGuest ? 'G' : strtoupper(substr($user->lname, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800">
                        {{ $user->fname }} {{ $user->lname ?? '' }}
                        @if($isGuest)
                            <span class="text-xs font-normal text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full ml-1">Guest</span>
                        @endif
                    </h1>
                    <p class="text-sm" :class="customerIsTyping ? 'text-green-500 font-medium' : 'text-gray-500'"
                       x-text="customerIsTyping ? 'typing...' : '{{ $user->email }}'"></p>
                </div>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col" style="height: 600px;">
            <!-- Messages -->
            <div x-ref="chatMessages" class="flex-1 overflow-y-auto p-6 space-y-3 bg-gray-50">
                <template x-if="messages.length === 0">
                    <div class="text-center py-12">
                        <p class="text-gray-400">No messages in this conversation yet.</p>
                    </div>
                </template>

                <template x-for="(msg, idx) in messages" :key="msg.id">
                    <div>
                        <div :class="msg.sender_type === 'admin' ? 'flex justify-end' : 'flex justify-start'">
                            <div class="max-w-[65%]">
                                <div :class="msg.sender_type === 'admin'
                                    ? 'bg-gradient-to-br from-violet-600 to-purple-700 text-white rounded-2xl rounded-br-md'
                                    : 'bg-white text-gray-800 rounded-2xl rounded-bl-md shadow-sm border border-gray-100'"
                                    class="px-4 py-3">
                                    <p x-html="formatMessageAdmin(msg.message)" class="text-sm leading-relaxed"></p>
                                    <p :class="msg.sender_type === 'admin' ? 'text-white/60' : 'text-gray-400'"
                                       class="text-[10px] mt-1" x-text="formatTime(msg.created_at)"></p>
                                </div>
                                <!-- Delivered / Seen for admin messages -->
                                <template x-if="msg.sender_type === 'admin' && idx === getLastAdminIndex()">
                                    <div class="flex items-center justify-end gap-1 mt-0.5 pr-1">
                                        <template x-if="msg.is_read">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-violet-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <svg class="w-3.5 h-3.5 text-violet-500 -ml-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <span class="text-[10px] text-violet-500 font-medium">Seen</span>
                                            </div>
                                        </template>
                                        <template x-if="!msg.is_read && msg.is_delivered">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <svg class="w-3.5 h-3.5 text-gray-400 -ml-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <span class="text-[10px] text-gray-400 font-medium">Delivered</span>
                                            </div>
                                        </template>
                                        <template x-if="!msg.is_read && !msg.is_delivered">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <span class="text-[10px] text-gray-300 font-medium">Sent</span>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Customer typing indicator -->
                <div x-show="customerIsTyping" class="flex justify-start">
                    <div class="bg-white rounded-2xl rounded-bl-md shadow-sm border border-gray-100 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 bg-violet-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                                <span class="w-2 h-2 bg-violet-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                                <span class="w-2 h-2 bg-violet-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                            </div>
                            <span class="text-xs text-gray-400">Customer is typing</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Input -->
            <div class="p-4 bg-white border-t border-gray-100">
                <form @submit.prevent="send()" class="flex items-center gap-3">
                    <input x-model="newMessage"
                           @input="emitTyping()"
                           type="text"
                           placeholder="Type your reply..."
                           class="flex-1 px-5 py-3 bg-gray-100 rounded-full text-sm border-0 focus:ring-2 focus:ring-violet-400 focus:bg-white transition-all duration-200"
                           maxlength="1000"
                           :disabled="sending">
                    <button type="submit"
                            :disabled="!newMessage.trim() || sending"
                            class="px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-700 text-white rounded-full text-sm font-semibold hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function adminChat() {
        return {
            messages: @json($messages),
            newMessage: '',
            sending: false,
            pollInterval: null,
            customerIsTyping: false,
            typingTimeout: null,

            init() {
                this.$nextTick(() => this.scrollToBottom());
                this.pollInterval = setInterval(() => {
                    this.fetchMessages();
                    this.checkCustomerTyping();
                }, 3000);
            },

            getLastAdminIndex() {
                for (let i = this.messages.length - 1; i >= 0; i--) {
                    if (this.messages[i].sender_type === 'admin') return i;
                }
                return -1;
            },

            async fetchMessages() {
                try {
                    const res = await fetch(@json($messagesUrl), {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        if (JSON.stringify(data.map(m => m.id)) !== JSON.stringify(this.messages.map(m => m.id))
                            || JSON.stringify(data.map(m => m.is_read)) !== JSON.stringify(this.messages.map(m => m.is_read))
                            || JSON.stringify(data.map(m => m.is_delivered)) !== JSON.stringify(this.messages.map(m => m.is_delivered))) {
                            this.messages = data;
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    }
                } catch (e) {}
            },

            async send() {
                if (!this.newMessage.trim() || this.sending) return;
                this.sending = true;
                const msg = this.newMessage;
                this.newMessage = '';

                try {
                    const res = await fetch(@json($replyUrl), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: msg })
                    });
                    if (res.ok) {
                        const newMsg = await res.json();
                        this.messages.push(newMsg);
                        this.$nextTick(() => this.scrollToBottom());
                    }
                } catch (e) {
                    this.newMessage = msg;
                }
                this.sending = false;
            },

            async emitTyping() {
                if (this.typingTimeout) return;
                this.typingTimeout = setTimeout(() => { this.typingTimeout = null; }, 2000);

                try {
                    await fetch(@json($typingUrl), {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                } catch (e) {}
            },

            async checkCustomerTyping() {
                try {
                    const res = await fetch(@json($customerTypingUrl), {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.customerIsTyping = data.typing;
                        if (data.typing) {
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    }
                } catch (e) {}
            },

            scrollToBottom() {
                const container = this.$refs.chatMessages;
                if (container) container.scrollTop = container.scrollHeight;
            },

            formatMessageAdmin(text) {
                return text.replace(/\n/g, '<br>');
            },

            formatTime(datetime) {
                const d = new Date(datetime);
                const now = new Date();
                const isToday = d.toDateString() === now.toDateString();
                if (isToday) {
                    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }
                return d.toLocaleDateString([], { month: 'short', day: 'numeric' }) + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        }
    }
    </script>
</x-admin-layout>

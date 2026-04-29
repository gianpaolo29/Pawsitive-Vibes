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

    <style>
        .show-chat-layout {
            height: calc(100vh - var(--header-h) - 2rem);
        }
        @media (min-width: 640px) {
            .show-chat-layout { height: calc(100vh - var(--header-h) - 3rem); }
        }
        @media (min-width: 1024px) {
            .show-chat-layout { height: calc(100vh - var(--header-h) - 4rem); }
        }
        .show-scroll::-webkit-scrollbar { width: 5px; }
        .show-scroll::-webkit-scrollbar-thumb { background: rgba(139,92,246,0.2); border-radius: 99px; }
        .show-scroll::-webkit-scrollbar-track { background: transparent; }
        .bubble-in  { border-radius: 18px 18px 18px 4px; }
        .bubble-out { border-radius: 18px 18px 4px 18px; }
        .typing-dot { animation: tBounce 1.4s infinite ease-in-out both; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes tBounce {
            0%,80%,100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }
    </style>

    <div class="show-chat-layout flex flex-col rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-xl border border-gray-200/80 dark:border-gray-700 max-w-4xl"
         x-data="adminChat()" x-init="init()">

        {{-- Header --}}
        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.chat.index') }}"
               class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600 transition shrink-0">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>

            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0 {{ $isGuest ? 'bg-gradient-to-br from-amber-500 to-orange-500' : 'bg-gradient-to-br from-violet-500 to-purple-600' }}">
                {{ strtoupper(substr($user->fname, 0, 1)) }}{{ $isGuest ? 'G' : strtoupper(substr($user->lname, 0, 1)) }}
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white truncate">
                        {{ $user->fname }} {{ $user->lname ?? '' }}
                    </h3>
                    @if($isGuest)
                        <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 dark:bg-amber-900/30 dark:text-amber-400 px-1.5 py-0.5 rounded-full shrink-0">Guest</span>
                    @endif
                </div>
                <p class="text-xs mt-0.5 truncate"
                   :class="customerIsTyping ? 'text-green-500 font-medium' : 'text-gray-400 dark:text-gray-500'"
                   x-text="customerIsTyping ? 'typing...' : '{{ $user->email }}'"></p>
            </div>
        </div>

        {{-- Messages --}}
        <div x-ref="chatMessages" class="flex-1 overflow-y-auto show-scroll px-4 py-4 space-y-0.5 bg-gray-50 dark:bg-gray-900 min-h-0">
            <template x-if="messages.length === 0">
                <div class="flex items-center justify-center h-full">
                    <p class="text-sm text-gray-400 dark:text-gray-500">No messages in this conversation yet.</p>
                </div>
            </template>

            <template x-for="(msg, idx) in messages" :key="msg.id">
                <div>
                    <div class="flex mb-1.5" :class="msg.sender_type === 'admin' ? 'justify-end' : 'justify-start'">
                        <div class="max-w-[75%] sm:max-w-[70%] lg:max-w-[60%]">
                            <div class="px-3.5 py-2.5"
                                :class="msg.sender_type === 'admin'
                                    ? 'bubble-out bg-violet-500 text-white'
                                    : 'bubble-in bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 shadow-sm border border-gray-100 dark:border-gray-700'">
                                <p x-html="formatMsg(msg.message)" class="text-[13px] leading-relaxed break-words"></p>
                            </div>
                            <div class="flex items-center gap-1 mt-0.5 px-1"
                                 :class="msg.sender_type === 'admin' ? 'justify-end' : 'justify-start'">
                                <template x-if="msg.sender_type === 'admin' && idx === getLastAdminIdx()">
                                    <div class="flex items-center gap-0.5">
                                        <template x-if="msg.is_read">
                                            <div class="flex items-center">
                                                <svg class="w-3.5 h-3.5 text-violet-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                <svg class="w-3.5 h-3.5 text-violet-500 -ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            </div>
                                        </template>
                                        <template x-if="!msg.is_read">
                                            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </template>
                                    </div>
                                </template>
                                <span class="text-[10px] tabular-nums text-gray-400 dark:text-gray-500" x-text="formatTime(msg.created_at)"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Typing --}}
            <div x-show="customerIsTyping" x-transition class="flex justify-start mb-1.5">
                <div class="bubble-in bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 px-4 py-3">
                    <div class="flex items-center gap-1.5">
                        <span class="typing-dot w-2 h-2 bg-violet-400 rounded-full inline-block"></span>
                        <span class="typing-dot w-2 h-2 bg-violet-400 rounded-full inline-block"></span>
                        <span class="typing-dot w-2 h-2 bg-violet-400 rounded-full inline-block"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input --}}
        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shrink-0">
            <form @submit.prevent="send()" class="flex items-center gap-2">
                <input x-model="newMessage"
                       @input="emitTyping()"
                       @keydown.enter.prevent="send()"
                       type="text"
                       placeholder="Message..."
                       class="flex-1 px-4 py-2.5 text-sm bg-gray-100 dark:bg-gray-700 border-0 rounded-full focus:ring-2 focus:ring-violet-400 dark:focus:ring-violet-500 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                       maxlength="1000"
                       :disabled="sending"
                       autocomplete="off">
                <button type="submit"
                        :disabled="!newMessage.trim() || sending"
                        class="w-9 h-9 rounded-full bg-violet-500 hover:bg-violet-600 text-white flex items-center justify-center transition disabled:opacity-40 disabled:cursor-not-allowed shrink-0 shadow-md shadow-violet-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18"/>
                    </svg>
                </button>
            </form>
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
            typingThrottle: null,

            init() {
                this.$nextTick(() => this.scrollBottom());
                this.pollInterval = setInterval(() => {
                    this.fetchMessages();
                    this.checkTyping();
                }, 3000);
            },

            getLastAdminIdx() {
                for (let i = this.messages.length - 1; i >= 0; i--) {
                    if (this.messages[i].sender_type === 'admin') return i;
                }
                return -1;
            },

            async fetchMessages() {
                try {
                    const res = await fetch(@json($messagesUrl), { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();
                    const oldSig = this.messages.map(m => m.id + ':' + m.is_read).join(',');
                    const newSig = data.map(m => m.id + ':' + m.is_read).join(',');
                    if (oldSig !== newSig) {
                        this.messages = data;
                        this.$nextTick(() => this.scrollBottom());
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
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ message: msg })
                    });
                    if (res.ok) {
                        const newMsg = await res.json();
                        this.messages.push(newMsg);
                        this.$nextTick(() => this.scrollBottom());
                    }
                } catch (e) { this.newMessage = msg; }
                this.sending = false;
            },

            async emitTyping() {
                if (this.typingThrottle) return;
                this.typingThrottle = setTimeout(() => { this.typingThrottle = null; }, 2000);
                try {
                    await fetch(@json($typingUrl), {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                } catch (e) {}
            },

            async checkTyping() {
                try {
                    const res = await fetch(@json($customerTypingUrl), { headers: { 'Accept': 'application/json' } });
                    if (res.ok) {
                        const data = await res.json();
                        this.customerIsTyping = data.typing;
                        if (data.typing) this.$nextTick(() => this.scrollBottom());
                    }
                } catch (e) {}
            },

            scrollBottom() {
                const el = this.$refs.chatMessages;
                if (el) el.scrollTop = el.scrollHeight;
            },

            formatMsg(text) {
                if (!text) return '';
                return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
            },

            formatTime(dt) {
                const d = new Date(dt);
                return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        }
    }
    </script>
</x-admin-layout>

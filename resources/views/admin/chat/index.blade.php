<x-admin-layout>
    <style>
        /* Chat fills available viewport minus header and layout padding */
        .chat-layout {
            height: calc(100vh - var(--header-h) - 2rem);    /* mobile: p-4 = 1rem*2 */
        }
        @media (min-width: 640px) {
            .chat-layout { height: calc(100vh - var(--header-h) - 3rem); }   /* sm: p-6 = 1.5rem*2 */
        }
        @media (min-width: 1024px) {
            .chat-layout { height: calc(100vh - var(--header-h) - 4rem); }   /* lg: p-8 = 2rem*2 */
        }

        /* Thin scrollbars */
        .chat-scroll::-webkit-scrollbar { width: 5px; }
        .chat-scroll::-webkit-scrollbar-thumb { background: rgba(139,92,246,0.2); border-radius: 99px; }
        .chat-scroll:hover::-webkit-scrollbar-thumb { background: rgba(139,92,246,0.35); }
        .chat-scroll::-webkit-scrollbar-track { background: transparent; }

        /* Bubble shapes */
        .bubble-in  { border-radius: 18px 18px 18px 4px; }
        .bubble-out { border-radius: 18px 18px 4px 18px; }

        /* Typing dots */
        .typing-dot { animation: tBounce 1.4s infinite ease-in-out both; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes tBounce {
            0%,80%,100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }
    </style>

    <div class="chat-layout flex rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-xl border border-gray-200/80 dark:border-gray-700"
         x-data="adminChatApp()" x-init="init()">

        {{-- ══════════ LEFT PANEL ══════════ --}}
        <div class="w-full md:w-80 lg:w-[360px] shrink-0 border-r border-gray-200 dark:border-gray-700 flex flex-col"
             :class="activeConvo ? 'hidden md:flex' : 'flex'">

            {{-- Header --}}
            <div class="px-4 py-4 border-b border-gray-100 dark:border-gray-700 shrink-0">
                <h2 class="text-base font-bold text-gray-800 dark:text-white leading-tight">Messages</h2>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5"
                   x-text="conversations.length + ' conversation' + (conversations.length !== 1 ? 's' : '')"></p>
            </div>

            {{-- Search --}}
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 shrink-0">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" x-model="searchQuery" placeholder="Search conversations..."
                        class="w-full pl-9 pr-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border-0 rounded-xl focus:ring-2 focus:ring-violet-400 dark:focus:ring-violet-500 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500">
                </div>
            </div>

            {{-- List --}}
            <div class="flex-1 overflow-y-auto chat-scroll min-h-0">
                {{-- Empty state --}}
                <template x-if="filteredConversations.length === 0">
                    <div class="px-4 py-16 text-center">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-400 dark:text-gray-500">No conversations found</p>
                    </div>
                </template>

                {{-- Conversation items --}}
                <template x-for="convo in filteredConversations" :key="convo.id + '-' + convo.type">
                    <button @click="selectConversation(convo)"
                        class="w-full flex items-center gap-3 px-4 py-3.5 text-left transition-all duration-150 border-b border-gray-50 dark:border-gray-700/50"
                        :class="activeConvo && activeConvo.id === convo.id && activeConvo.type === convo.type
                            ? 'bg-violet-50 dark:bg-violet-900/20 border-l-[3px] border-l-violet-500'
                            : 'hover:bg-gray-50 dark:hover:bg-gray-700/30 border-l-[3px] border-l-transparent'">

                        {{-- Avatar --}}
                        <div class="relative shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                :class="convo.type === 'guest' ? 'bg-gradient-to-br from-amber-500 to-orange-500' : 'bg-gradient-to-br from-violet-500 to-purple-600'">
                                <span x-text="convo.initials"></span>
                            </div>
                            <template x-if="convo.unread_count > 0">
                                <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                            </template>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-sm font-semibold text-gray-800 dark:text-white truncate" x-text="convo.name"></span>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 shrink-0 tabular-nums" x-text="convo.last_time"></span>
                            </div>
                            <div class="flex items-center justify-between gap-2 mt-0.5">
                                <p class="text-xs text-gray-400 dark:text-gray-500 truncate" x-text="convo.last_preview"></p>
                                <template x-if="convo.unread_count > 0">
                                    <span class="shrink-0 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 bg-violet-500 text-white text-[10px] font-bold rounded-full"
                                          x-text="convo.unread_count > 9 ? '9+' : convo.unread_count"></span>
                                </template>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        {{-- ══════════ RIGHT PANEL ══════════ --}}
        <div class="flex-1 flex flex-col bg-gray-50 dark:bg-gray-900 min-w-0"
             :class="activeConvo ? 'flex' : 'hidden md:flex'">

            {{-- Empty placeholder --}}
            <template x-if="!activeConvo">
                <div class="flex-1 flex items-center justify-center p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-violet-100 dark:bg-violet-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-600 dark:text-gray-300 mb-1">Select a conversation</h3>
                        <p class="text-sm text-gray-400 dark:text-gray-500 max-w-xs mx-auto">Choose a customer from the list to start messaging</p>
                    </div>
                </div>
            </template>

            {{-- Active chat --}}
            <template x-if="activeConvo">
                <div class="flex flex-col h-full min-h-0">

                    {{-- Chat header --}}
                    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3 shrink-0">
                        {{-- Back (mobile) --}}
                        <button @click="activeConvo = null; messages = [];"
                            class="md:hidden w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600 transition shrink-0">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                        </button>

                        {{-- Avatar --}}
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                            :class="activeConvo.type === 'guest' ? 'bg-gradient-to-br from-amber-500 to-orange-500' : 'bg-gradient-to-br from-violet-500 to-purple-600'">
                            <span x-text="activeConvo.initials"></span>
                        </div>

                        {{-- Name --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white truncate" x-text="activeConvo.name"></h3>
                                <template x-if="activeConvo.type === 'guest'">
                                    <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 dark:bg-amber-900/30 dark:text-amber-400 px-1.5 py-0.5 rounded-full shrink-0">Guest</span>
                                </template>
                            </div>
                            <p class="text-xs mt-0.5 truncate"
                               :class="customerIsTyping ? 'text-green-500 font-medium' : 'text-gray-400 dark:text-gray-500'"
                               x-text="customerIsTyping ? 'typing...' : activeConvo.email"></p>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div x-ref="chatMessages" class="flex-1 overflow-y-auto chat-scroll px-4 py-4 space-y-0.5 min-h-0">
                        {{-- Loading --}}
                        <template x-if="loadingMessages">
                            <div class="flex items-center justify-center h-full">
                                <div class="flex items-center gap-2 text-gray-400">
                                    <svg class="animate-spin w-5 h-5" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <span class="text-sm">Loading...</span>
                                </div>
                            </div>
                        </template>

                        {{-- Empty --}}
                        <template x-if="!loadingMessages && messages.length === 0">
                            <div class="flex items-center justify-center h-full">
                                <p class="text-sm text-gray-400 dark:text-gray-500">No messages yet. Say hello!</p>
                            </div>
                        </template>

                        {{-- Message list --}}
                        <template x-for="(msg, idx) in messages" :key="msg.id">
                            <div>
                                {{-- Date divider --}}
                                <template x-if="idx === 0 || getDateLabel(msg.created_at) !== getDateLabel(messages[idx-1].created_at)">
                                    <div class="flex items-center justify-center my-3">
                                        <span class="px-3 py-1 bg-gray-200/60 dark:bg-gray-700 text-[11px] font-medium text-gray-500 dark:text-gray-400 rounded-full"
                                              x-text="getDateLabel(msg.created_at)"></span>
                                    </div>
                                </template>

                                {{-- Bubble --}}
                                <div class="flex mb-1.5" :class="msg.sender_type === 'admin' ? 'justify-end' : 'justify-start'">
                                    <div class="max-w-[75%] sm:max-w-[70%] lg:max-w-[60%]">
                                        <div class="px-3.5 py-2.5"
                                            :class="msg.sender_type === 'admin'
                                                ? 'bubble-out bg-violet-500 text-white'
                                                : 'bubble-in bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 shadow-sm border border-gray-100 dark:border-gray-700'">
                                            <p x-html="formatMsg(msg.message)" class="text-[13px] leading-relaxed break-words"></p>
                                        </div>
                                        {{-- Meta row --}}
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

                        {{-- Typing indicator --}}
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
                        <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                            <input x-model="newMessage"
                                   @input="emitTyping()"
                                   @keydown.enter.prevent="sendMessage()"
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
            </template>
        </div>
    </div>

    <script>
    function adminChatApp() {
        return {
            conversations: @json($conversations->values()),
            searchQuery: '',
            activeConvo: null,
            messages: [],
            newMessage: '',
            sending: false,
            loadingMessages: false,
            customerIsTyping: false,
            pollInterval: null,
            typingThrottle: null,

            init() {
                if (window.innerWidth >= 768 && this.conversations.length > 0) {
                    this.selectConversation(this.conversations[0]);
                }
            },

            get filteredConversations() {
                if (!this.searchQuery.trim()) return this.conversations;
                const q = this.searchQuery.toLowerCase();
                return this.conversations.filter(c =>
                    c.name.toLowerCase().includes(q) || (c.email && c.email.toLowerCase().includes(q))
                );
            },

            async selectConversation(convo) {
                if (this.activeConvo && this.activeConvo.id === convo.id && this.activeConvo.type === convo.type) return;
                if (this.pollInterval) { clearInterval(this.pollInterval); this.pollInterval = null; }

                this.activeConvo = convo;
                this.messages = [];
                this.loadingMessages = true;
                this.customerIsTyping = false;

                await this.fetchMessages();
                this.loadingMessages = false;
                convo.unread_count = 0;

                this.pollInterval = setInterval(() => {
                    this.fetchMessages();
                    this.checkTyping();
                }, 3000);
            },

            getMessagesUrl() {
                const c = this.activeConvo;
                if (c.type === 'guest') return `/admin/chat/guest/messages?type=guest&session=${c.id}`;
                return `/admin/chat/${c.id}/messages?type=user`;
            },

            getReplyUrl() {
                const c = this.activeConvo;
                if (c.type === 'guest') return `/admin/chat/guest/reply?type=guest&session=${c.id}`;
                return `/admin/chat/${c.id}/reply?type=user`;
            },

            getTypingUrl() {
                const c = this.activeConvo;
                if (c.type === 'guest') return `/admin/chat/guest/typing?type=guest&session=${c.id}`;
                return `/admin/chat/${c.id}/typing?type=user`;
            },

            getCustomerTypingUrl() {
                const c = this.activeConvo;
                if (c.type === 'guest') return `/admin/chat/guest/customer-typing?type=guest&session=${c.id}`;
                return `/admin/chat/${c.id}/customer-typing?type=user`;
            },

            async fetchMessages() {
                if (!this.activeConvo) return;
                try {
                    const res = await fetch(this.getMessagesUrl(), { headers: { 'Accept': 'application/json' } });
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

            async sendMessage() {
                if (!this.newMessage.trim() || this.sending || !this.activeConvo) return;
                this.sending = true;
                const text = this.newMessage;
                this.newMessage = '';

                try {
                    const res = await fetch(this.getReplyUrl(), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ message: text })
                    });
                    if (res.ok) {
                        const msg = await res.json();
                        this.messages.push(msg);
                        this.activeConvo.last_preview = 'You: ' + text.substring(0, 40);
                        this.activeConvo.last_time = 'Just now';
                        this.$nextTick(() => this.scrollBottom());
                    }
                } catch (e) { this.newMessage = text; }
                this.sending = false;
            },

            async emitTyping() {
                if (this.typingThrottle) return;
                this.typingThrottle = setTimeout(() => { this.typingThrottle = null; }, 2000);
                try {
                    await fetch(this.getTypingUrl(), {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                } catch (e) {}
            },

            async checkTyping() {
                if (!this.activeConvo) return;
                try {
                    const res = await fetch(this.getCustomerTypingUrl(), { headers: { 'Accept': 'application/json' } });
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

            getLastAdminIdx() {
                for (let i = this.messages.length - 1; i >= 0; i--) {
                    if (this.messages[i].sender_type === 'admin') return i;
                }
                return -1;
            },

            formatMsg(text) {
                if (!text) return '';
                return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
            },

            formatTime(dt) {
                const d = new Date(dt);
                return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            },

            getDateLabel(dt) {
                const d = new Date(dt);
                const now = new Date();
                const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                const date = new Date(d.getFullYear(), d.getMonth(), d.getDate());
                const diff = (today - date) / 86400000;
                if (diff === 0) return 'Today';
                if (diff === 1) return 'Yesterday';
                return d.toLocaleDateString([], { month: 'short', day: 'numeric', year: d.getFullYear() !== now.getFullYear() ? 'numeric' : undefined });
            },
        };
    }
    </script>
</x-admin-layout>

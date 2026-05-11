<div x-data="chatWidget()" x-init="init()" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Toggle Button -->
    <button @click="toggle()" class="relative w-14 h-14 bg-gradient-to-br from-violet-600 to-purple-700 text-white rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center">
        <template x-if="!open">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </template>
        <template x-if="open">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </template>

        <!-- Unread Badge -->
        <span x-show="unreadCount > 0" x-text="unreadCount"
              class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse"></span>
    </button>

    <!-- Chat Window -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="absolute bottom-20 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col"
         style="height: 500px;">

        <!-- Header -->
        <div class="bg-gradient-to-r from-violet-600 to-purple-700 px-5 py-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" class="w-7 h-7 rounded-full" alt="Logo">
            </div>
            <div class="flex-1">
                <h3 class="text-white font-semibold text-sm">Pawsitive Vibes Support</h3>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <p class="text-white/70 text-xs" x-text="adminIsTyping ? 'Admin is typing...' : 'Online - We reply instantly'"></p>
                </div>
            </div>
        </div>

        @guest
        <!-- Guest Info Form -->
        <div x-show="!guestStarted" class="flex-1 flex flex-col justify-center p-6 bg-gray-50">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-violet-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <h4 class="text-gray-800 font-semibold text-sm">Before we start chatting</h4>
                <p class="text-gray-500 text-xs mt-1">Please tell us a bit about yourself</p>
            </div>
            <form @submit.prevent="startGuestChat()" class="space-y-3">
                <div>
                    <input x-model="guestName" type="text" placeholder="Your name" required
                           class="w-full px-4 py-2.5 bg-white rounded-xl text-sm border border-gray-200 focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all duration-200">
                    <p x-show="guestErrors.name" x-text="guestErrors.name" class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <input x-model="guestEmail" type="email" placeholder="Your email" required
                           class="w-full px-4 py-2.5 bg-white rounded-xl text-sm border border-gray-200 focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all duration-200">
                    <p x-show="guestErrors.email" x-text="guestErrors.email" class="text-red-500 text-xs mt-1"></p>
                </div>
                <button type="submit"
                        class="w-full py-2.5 bg-gradient-to-r from-violet-600 to-purple-700 text-white rounded-xl text-sm font-semibold hover:shadow-lg transition-all duration-200">
                    Start Chat
                </button>
            </form>
        </div>
        @endguest

        <!-- Messages Container -->
        <div x-show="canChat" class="flex-1 flex flex-col" style="min-height: 0;">
            <div x-ref="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50" style="scroll-behavior: smooth;">

                <!-- Welcome + Suggestions (when no messages) -->
                <template x-if="messages.length === 0 && !sending">
                    <div>
                        <div class="text-center pt-4 pb-2">
                            <div class="w-14 h-14 bg-violet-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl">🐾</span>
                            </div>
                            <p class="text-gray-700 text-sm font-medium">Hi there! How can we help?</p>
                            <p class="text-gray-400 text-xs mt-1">Choose a topic or type your message</p>
                        </div>

                        <!-- Suggestion Chips -->
                        <div class="mt-4 space-y-2">
                            <template x-for="(suggestion, index) in suggestions" :key="index">
                                <button @click="handleSuggestion(suggestion)"
                                        class="w-full text-left px-4 py-3 bg-white rounded-xl border border-gray-100 hover:border-violet-300 hover:bg-violet-50 transition-all duration-200 flex items-center gap-3 group">
                                    <span class="w-8 h-8 rounded-lg bg-violet-100 group-hover:bg-violet-200 flex items-center justify-center transition-colors shrink-0" x-html="getSuggestionIcon(suggestion.icon)"></span>
                                    <span class="text-sm text-gray-700 group-hover:text-violet-700 transition-colors" x-text="suggestion.text"></span>
                                    <svg class="w-4 h-4 text-gray-300 group-hover:text-violet-400 ml-auto shrink-0 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Message Bubbles -->
                <template x-for="(msg, idx) in messages" :key="msg.id">
                    <div>
                        <div :class="msg.sender_type === 'customer' ? 'flex justify-end' : 'flex justify-start'">
                            <!-- Bot avatar for admin messages -->
                            <template x-if="msg.sender_type === 'admin'">
                                <div class="w-7 h-7 bg-violet-100 rounded-full flex items-center justify-center mr-2 shrink-0 self-end">
                                    <span class="text-xs">🐾</span>
                                </div>
                            </template>
                            <div class="max-w-[75%]">
                                <div :class="msg.sender_type === 'customer'
                                    ? 'bg-gradient-to-br from-violet-600 to-purple-700 text-white rounded-2xl rounded-br-md'
                                    : 'bg-white text-gray-800 rounded-2xl rounded-bl-md shadow-sm border border-gray-100'"
                                    class="px-4 py-2.5">
                                    <p x-html="formatMessage(msg.message)" class="text-sm leading-relaxed"></p>
                                    <p :class="msg.sender_type === 'customer' ? 'text-white/60' : 'text-gray-400'"
                                       class="text-[10px] mt-1" x-text="formatTime(msg.created_at)"></p>
                                </div>
                                <!-- Delivered / Seen status for customer messages -->
                                <template x-if="msg.sender_type === 'customer' && idx === getLastCustomerIndex()">
                                    <div class="flex items-center justify-end gap-1 mt-0.5 pr-1">
                                        <template x-if="msg.is_read">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <span class="text-[10px] text-violet-500 font-medium">Seen</span>
                                            </div>
                                        </template>
                                        <template x-if="!msg.is_read && msg.is_delivered">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                <span class="text-[10px] text-gray-400 font-medium">Delivered</span>
                                            </div>
                                        </template>
                                        <template x-if="!msg.is_read && !msg.is_delivered">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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

                <!-- Compact suggestions after messages -->
                <template x-if="messages.length > 0 && showSuggestionsAfter && !sending && !adminIsTyping">
                    <div class="pt-2">
                        <p class="text-xs text-gray-400 mb-2 text-center">Quick questions:</p>
                        <div class="flex flex-wrap gap-1.5 justify-center">
                            <template x-for="(suggestion, index) in suggestionsCompact" :key="'c'+index">
                                <button @click="sendSuggestion(suggestion)"
                                        class="px-3 py-1.5 bg-white text-xs text-violet-700 rounded-full border border-violet-200 hover:bg-violet-50 hover:border-violet-300 transition-all duration-200">
                                    <span x-text="suggestion"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Admin typing indicator -->
                <div x-show="adminIsTyping" class="flex justify-start">
                    <div class="w-7 h-7 bg-violet-100 rounded-full flex items-center justify-center mr-2 shrink-0 self-end">
                        <span class="text-xs">🐾</span>
                    </div>
                    <div class="bg-white rounded-2xl rounded-bl-md shadow-sm border border-gray-100 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 bg-violet-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                                <span class="w-2 h-2 bg-violet-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                                <span class="w-2 h-2 bg-violet-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                            </div>
                            <span class="text-xs text-gray-400">Admin is typing</span>
                        </div>
                    </div>
                </div>

                <!-- Bot typing indicator (for auto-reply delay) -->
                <div x-show="sending && !adminIsTyping" class="flex justify-start">
                    <div class="w-7 h-7 bg-violet-100 rounded-full flex items-center justify-center mr-2 shrink-0 self-end">
                        <span class="text-xs">🐾</span>
                    </div>
                    <div class="bg-white rounded-2xl rounded-bl-md shadow-sm border border-gray-100 px-4 py-3">
                        <div class="flex gap-1">
                            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-3 bg-white border-t border-gray-100">
                <form @submit.prevent="send()" class="flex items-center gap-2">
                    <input x-model="newMessage"
                           @focus="markAsRead()"
                           @input="emitTyping()"
                           type="text"
                           placeholder="Type your message..."
                           class="flex-1 px-4 py-2.5 bg-gray-100 rounded-full text-sm border-0 focus:ring-2 focus:ring-violet-400 focus:bg-white transition-all duration-200"
                           maxlength="1000"
                           :disabled="sending">
                    <button type="submit"
                            :disabled="!newMessage.trim() || sending"
                            class="w-10 h-10 bg-gradient-to-br from-violet-600 to-purple-700 text-white rounded-full flex items-center justify-center hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function chatWidget() {
    return {
        open: false,
        messages: [],
        newMessage: '',
        sending: false,
        unreadCount: 0,
        pollInterval: null,
        adminIsTyping: false,
        typingTimeout: null,
        isGuest: {{ auth()->check() ? 'false' : 'true' }},
        guestStarted: false,
        guestName: '',
        guestEmail: '',
        guestErrors: { name: '', email: '' },
        showSuggestionsAfter: true,

        suggestions: [
            { text: 'How do I track my order?', icon: 'package' },
            { text: 'What are your payment methods?', icon: 'credit-card' },
            { text: 'How do I buy products?', icon: 'truck' },
            { text: 'How can I donate?', icon: 'heart' },
            { text: 'Any promotions available?', icon: 'refresh' },
            { text: 'I need help with my account', icon: 'map-pin' },
            { text: 'My account is blocked', icon: 'ticket', action: 'ticket' },
        ],

        suggestionsCompact: [
            'Track order',
            'Payment methods',
            'How to buy',
            'Donate',
            'Submit a ticket',
        ],

        get canChat() {
            return !this.isGuest || this.guestStarted;
        },

        init() {
            if (!this.isGuest) {
                this.fetchUnread();
            }
            this.pollInterval = setInterval(() => {
                if (this.canChat) {
                    this.fetchUnread();
                    if (this.open) {
                        this.fetchMessages();
                        this.checkAdminTyping();
                    }
                }
            }, 3000);
        },

        startGuestChat() {
            this.guestErrors = { name: '', email: '' };
            let valid = true;

            if (!this.guestName.trim()) {
                this.guestErrors.name = 'Please enter your name';
                valid = false;
            }
            if (!this.guestEmail.trim() || !this.guestEmail.includes('@')) {
                this.guestErrors.email = 'Please enter a valid email';
                valid = false;
            }

            if (valid) {
                this.guestStarted = true;
                this.$nextTick(() => this.fetchMessages());
            }
        },

        toggle() {
            this.open = !this.open;
            if (this.open && this.canChat) {
                this.fetchMessages();
                this.markAsRead();
            }
        },

        handleSuggestion(suggestion) {
            if (suggestion.action === 'ticket') {
                window.location.href = '{{ route("support.ticket.create") }}';
                return;
            }
            this.sendSuggestion(suggestion.text);
        },

        sendSuggestion(text) {
            if (text === 'Submit a ticket') {
                window.location.href = '{{ route("support.ticket.create") }}';
                return;
            }
            this.newMessage = text;
            this.showSuggestionsAfter = false;
            this.send();
        },

        getLastCustomerIndex() {
            for (let i = this.messages.length - 1; i >= 0; i--) {
                if (this.messages[i].sender_type === 'customer') return i;
            }
            return -1;
        },

        async fetchMessages() {
            try {
                const res = await fetch('{{ route("chat.messages") }}', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                if (res.ok) {
                    const data = await res.json();
                    if (JSON.stringify(data.map(m => m.id)) !== JSON.stringify(this.messages.map(m => m.id))
                        || JSON.stringify(data.map(m => m.is_read)) !== JSON.stringify(this.messages.map(m => m.is_read))) {
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

            const body = { message: msg };
            if (this.isGuest) {
                body.guest_name = this.guestName;
                body.guest_email = this.guestEmail;
            }

            try {
                const res = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(body)
                });
                if (res.ok) {
                    const data = await res.json();
                    this.messages.push(data.message);

                    if (data.auto_reply) {
                        this.$nextTick(() => this.scrollToBottom());
                        await new Promise(resolve => setTimeout(resolve, 800));
                        this.messages.push(data.auto_reply);
                        this.showSuggestionsAfter = true;
                    }

                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (e) {
                this.newMessage = msg;
            }
            this.sending = false;
        },

        async fetchUnread() {
            try {
                const res = await fetch('{{ route("chat.unread") }}', {
                    headers: { 'Accept': 'application/json' }
                });
                if (res.ok) {
                    const data = await res.json();
                    this.unreadCount = data.count;
                }
            } catch (e) {}
        },

        async markAsRead() {
            if (this.unreadCount === 0) return;
            try {
                await fetch('{{ route("chat.markRead") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                this.unreadCount = 0;
            } catch (e) {}
        },

        async emitTyping() {
            if (this.typingTimeout) return;
            this.typingTimeout = setTimeout(() => { this.typingTimeout = null; }, 2000);

            try {
                await fetch('{{ route("chat.typing") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            } catch (e) {}
        },

        async checkAdminTyping() {
            try {
                const res = await fetch('{{ route("chat.adminTyping") }}', {
                    headers: { 'Accept': 'application/json' }
                });
                if (res.ok) {
                    const data = await res.json();
                    this.adminIsTyping = data.typing;
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

        formatMessage(text) {
            // Convert URLs to clickable links
            let formatted = text.replace(/\n/g, '<br>');
            formatted = formatted.replace(
                /(\/support\/ticket)/g,
                '<a href="{{ route("support.ticket.create") }}" class="underline font-semibold hover:opacity-80">Submit a Ticket</a>'
            );
            return formatted;
        },

        formatTime(datetime) {
            const d = new Date(datetime);
            const now = new Date();
            const isToday = d.toDateString() === now.toDateString();
            if (isToday) {
                return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
            return d.toLocaleDateString([], { month: 'short', day: 'numeric' }) + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },

        getSuggestionIcon(icon) {
            const icons = {
                'package': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
                'credit-card': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>',
                'truck': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>',
                'refresh': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182M21.015 4.356v4.992"/></svg>',
                'map-pin': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>',
                'heart': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>',
                'ticket': '<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>',
            };
            return icons[icon] || icons['package'];
        }
    }
}
</script>

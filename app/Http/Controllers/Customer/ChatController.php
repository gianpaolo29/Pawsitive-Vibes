<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatTyping;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
{
    private const AUTO_REPLIES = [
        'order' => [
            'keywords' => ['order', 'track', 'tracking', 'status', 'where is my', 'delivery status', 'my order'],
            'reply' => "You can check your order status by going to your Profile > Transactions. If you have concerns about a specific order, please share your order number and we'll look into it for you!",
        ],
        'shipping' => [
            'keywords' => ['shipping', 'deliver', 'delivery', 'how long', 'ship', 'arrive', 'when will'],
            'reply' => "We deliver within Metro Manila! Standard delivery takes 2-3 business days. For orders outside Metro Manila, it may take 5-7 business days. You'll receive a notification once your order is shipped.",
        ],
        'payment' => [
            'keywords' => ['payment', 'pay', 'gcash', 'cash', 'how to pay', 'payment method', 'cod'],
            'reply' => "We accept the following payment methods:\n- GCash (upload your receipt at checkout)\n- Cash on Delivery (COD)\n\nFor GCash payments, please make sure to upload a clear screenshot of your payment receipt.",
        ],
        'refund' => [
            'keywords' => ['refund', 'return', 'exchange', 'cancel', 'money back', 'cancelled'],
            'reply' => "For refunds and returns, please contact us with your order number and reason. We process refunds within 3-5 business days after approval. Items must be unused and in original packaging.",
        ],
        'hours' => [
            'keywords' => ['hours', 'open', 'close', 'time', 'schedule', 'available', 'operating'],
            'reply' => "Our online shop is available 24/7! For customer support, we're available Monday to Saturday, 9:00 AM - 6:00 PM. We'll respond to messages outside these hours on the next business day.",
        ],
        'location' => [
            'keywords' => ['location', 'address', 'where', 'store', 'branch', 'visit', 'physical'],
            'reply' => "We're located in Manila, Philippines. You can reach us at:\n- Email: support@pawsitivevibes.com\n- Phone: 0945-123-4567\n- Facebook: Pawsitive Vibes",
        ],
        'discount' => [
            'keywords' => ['discount', 'promo', 'sale', 'coupon', 'voucher', 'offer', 'deal'],
            'reply' => "Follow us on Facebook to stay updated on our latest promos and deals! We regularly offer discounts on selected pet products. Check our shop page for current offers.",
        ],
        'product' => [
            'keywords' => ['product', 'stock', 'available', 'price', 'how much', 'do you have', 'sell'],
            'reply' => "You can browse all our available products on the Shop page. Use the filters to search by category or price range. If you're looking for a specific product, let us know and we'll check availability for you!",
        ],
        'donate' => [
            'keywords' => ['donate', 'donation', 'charity', 'help', 'rescue', 'shelter', 'stray'],
            'reply' => "Thank you for your interest in donating! You can visit our Donate page to contribute. Your donations help support rescued and stray animals. Every little bit counts!",
        ],
        'account' => [
            'keywords' => ['account', 'register', 'sign up', 'login', 'password', 'forgot', 'reset'],
            'reply' => "For account-related concerns:\n- Register: Click 'Register' on the top right\n- Forgot Password: Use the 'Forgot Password' link on the login page\n- Account Issues: Please share your registered email and we'll assist you.",
        ],
        'ticket' => [
            'keywords' => ['ticket', 'reactivate', 'blocked', 'deactivated', 'locked', 'suspended', 'unblock', 'activate'],
            'reply' => "If your account has been deactivated or blocked, you can submit a reactivation ticket here:\n\n👉 Visit: /support/ticket\n\nYou'll need your registered email to submit a ticket. You can also track your ticket status anytime.",
        ],
        'greeting' => [
            'keywords' => ['hi', 'hello', 'hey', 'good morning', 'good afternoon', 'good evening', 'sup', 'yo'],
            'reply' => "Hi there! Welcome to Pawsitive Vibes! How can we help you today? You can ask about orders, shipping, payments, or anything pet-related!",
        ],
        'thanks' => [
            'keywords' => ['thank', 'thanks', 'thank you', 'salamat', 'appreciate'],
            'reply' => "You're welcome! If you have any other questions, feel free to ask. Happy shopping and give your fur babies a treat from us!",
        ],
    ];

    public function index(Request $request)
    {
        $query = $this->getConversationQuery($request);

        if (!$query) {
            return response()->json([]);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Mark customer messages as delivered when fetched
        $this->markDelivered($request);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $rules = ['message' => 'required|string|max:1000'];

        if (!auth()->check()) {
            $rules['guest_name'] = 'required|string|max:100';
            $rules['guest_email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        $data = [
            'message' => $request->message,
            'sender_type' => 'customer',
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        } else {
            $data['session_id'] = $request->session()->getId();
            $data['guest_name'] = $request->guest_name;
            $data['guest_email'] = $request->guest_email;
        }

        $message = ChatMessage::create($data);

        // Notify all admins
        $senderName = auth()->check()
            ? auth()->user()->fname . ' ' . auth()->user()->lname
            : ($request->guest_name ?? 'Guest');
        $admins = User::where('role', 'ADMIN')->get();
        Notification::send($admins, new NewChatMessageNotification($message, $senderName));

        // Check for auto-reply
        $autoReply = $this->getAutoReply($request->message);
        $botReply = null;

        if ($autoReply) {
            $botData = [
                'message' => $autoReply,
                'sender_type' => 'admin',
                'is_delivered' => true,
                'delivered_at' => now(),
            ];

            if (auth()->check()) {
                $botData['user_id'] = auth()->id();
            } else {
                $botData['session_id'] = $request->session()->getId();
                $botData['guest_name'] = $request->guest_name;
                $botData['guest_email'] = $request->guest_email;
            }

            $botReply = ChatMessage::create($botData);
        }

        return response()->json([
            'message' => $message,
            'auto_reply' => $botReply,
        ], 201);
    }

    public function suggestions()
    {
        $suggestions = [
            ['text' => 'How do I track my order?', 'icon' => 'package'],
            ['text' => 'What are your payment methods?', 'icon' => 'credit-card'],
            ['text' => 'How long is shipping?', 'icon' => 'truck'],
            ['text' => 'Do you have a refund policy?', 'icon' => 'refresh'],
            ['text' => 'Where are you located?', 'icon' => 'map-pin'],
            ['text' => 'How can I donate?', 'icon' => 'heart'],
            ['text' => 'My account is blocked/deactivated', 'icon' => 'ticket'],
        ];

        return response()->json($suggestions);
    }

    public function unread(Request $request)
    {
        $query = $this->getConversationQuery($request);

        if (!$query) {
            return response()->json(['count' => 0]);
        }

        $count = $query->where('sender_type', 'admin')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markRead(Request $request)
    {
        $query = $this->getConversationQuery($request);

        if ($query) {
            $query->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function typing(Request $request)
    {
        $data = [
            'typer_type' => 'customer',
            'last_typed_at' => now(),
        ];

        if (auth()->check()) {
            ChatTyping::updateOrCreate(
                ['user_id' => auth()->id(), 'typer_type' => 'customer'],
                $data
            );
        } else {
            $sessionId = $request->session()->getId();
            ChatTyping::updateOrCreate(
                ['session_id' => $sessionId, 'typer_type' => 'customer'],
                $data
            );
        }

        return response()->json(['success' => true]);
    }

    public function adminTyping(Request $request)
    {
        $isTyping = false;

        if (auth()->check()) {
            $typing = ChatTyping::where('user_id', auth()->id())
                ->where('typer_type', 'admin')
                ->where('last_typed_at', '>=', now()->subSeconds(3))
                ->first();
            $isTyping = (bool) $typing;
        } else {
            $sessionId = $request->session()->getId();
            $typing = ChatTyping::where('session_id', $sessionId)
                ->where('typer_type', 'admin')
                ->where('last_typed_at', '>=', now()->subSeconds(3))
                ->first();
            $isTyping = (bool) $typing;
        }

        return response()->json(['typing' => $isTyping]);
    }

    private function markDelivered(Request $request)
    {
        $query = $this->getConversationQuery($request);
        if ($query) {
            (clone $query)->where('sender_type', 'admin')
                ->where('is_delivered', false)
                ->update(['is_delivered' => true, 'delivered_at' => now()]);
        }
    }

    private function getConversationQuery(Request $request)
    {
        if (auth()->check()) {
            return ChatMessage::where('user_id', auth()->id());
        }

        $sessionId = $request->session()->getId();
        if ($sessionId) {
            return ChatMessage::where('session_id', $sessionId);
        }

        return null;
    }

    private function getAutoReply(string $message): ?string
    {
        $message = strtolower(trim($message));

        $bestMatch = null;
        $bestScore = 0;

        foreach (self::AUTO_REPLIES as $topic => $config) {
            $score = 0;
            foreach ($config['keywords'] as $keyword) {
                if (str_contains($message, strtolower($keyword))) {
                    $score += strlen($keyword);
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $config['reply'];
            }
        }

        return $bestMatch;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatTyping;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Get conversations from registered users
        $userConversations = User::where('role', 'CUSTOMER')
            ->whereHas('chatMessages')
            ->withCount(['chatMessages as unread_count' => function ($q) {
                $q->where('sender_type', 'customer')->where('is_read', false);
            }])
            ->with(['chatMessages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->get()
            ->map(function ($customer) {
                $last = $customer->chatMessages->first();
                $preview = '';
                $time = '';
                if ($last) {
                    $preview = ($last->sender_type === 'admin' ? 'You: ' : '') . \Illuminate\Support\Str::limit($last->message, 40);
                    $time = $last->created_at->diffForHumans(short: true);
                }

                return [
                    'type' => 'user',
                    'id' => $customer->id,
                    'name' => $customer->fname . ' ' . $customer->lname,
                    'email' => $customer->email,
                    'initials' => strtoupper(substr($customer->fname, 0, 1)) . strtoupper(substr($customer->lname, 0, 1)),
                    'unread_count' => $customer->unread_count,
                    'last_preview' => $preview,
                    'last_time' => $time,
                    'last_at' => $last?->created_at,
                ];
            });

        // Get guest conversations (grouped by session_id)
        $guestConversations = ChatMessage::whereNull('user_id')
            ->whereNotNull('session_id')
            ->selectRaw('session_id, MAX(guest_name) as guest_name, MAX(guest_email) as guest_email, MAX(created_at) as last_at')
            ->groupBy('session_id')
            ->get()
            ->map(function ($guest) {
                $unread = ChatMessage::where('session_id', $guest->session_id)
                    ->where('sender_type', 'customer')
                    ->where('is_read', false)
                    ->count();

                $lastMessage = ChatMessage::where('session_id', $guest->session_id)
                    ->latest()
                    ->first();

                $name = $guest->guest_name ?: 'Guest';
                $preview = '';
                $time = '';
                if ($lastMessage) {
                    $preview = ($lastMessage->sender_type === 'admin' ? 'You: ' : '') . \Illuminate\Support\Str::limit($lastMessage->message, 40);
                    $time = $lastMessage->created_at->diffForHumans(short: true);
                }

                return [
                    'type' => 'guest',
                    'id' => $guest->session_id,
                    'name' => $name,
                    'email' => $guest->guest_email,
                    'initials' => strtoupper(substr($name, 0, 1)) . 'G',
                    'unread_count' => $unread,
                    'last_preview' => $preview,
                    'last_time' => $time,
                    'last_at' => $lastMessage?->created_at,
                ];
            });

        $conversations = $userConversations->concat($guestConversations)
            ->sortByDesc(fn ($c) => $c['unread_count'] > 0 ? 1 : 0)
            ->sortByDesc('last_at')
            ->values();

        return view('admin.chat.index', compact('conversations'));
    }

    public function show(Request $request, $id)
    {
        $type = $request->query('type', 'user');

        if ($type === 'guest') {
            $sessionId = $request->query('session');
            $messages = ChatMessage::where('session_id', $sessionId)
                ->orderBy('created_at', 'asc')
                ->get();

            // Mark as read with timestamp
            ChatMessage::where('session_id', $sessionId)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            $firstMsg = ChatMessage::where('session_id', $sessionId)->first();
            $chatUser = (object) [
                'id' => $sessionId,
                'fname' => $firstMsg->guest_name ?? 'Guest',
                'lname' => '',
                'email' => $firstMsg->guest_email ?? 'N/A',
                'is_guest' => true,
            ];

            return view('admin.chat.show', [
                'user' => $chatUser,
                'messages' => $messages,
                'chatType' => 'guest',
                'sessionId' => $sessionId,
            ]);
        }

        $user = User::findOrFail($id);
        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        ChatMessage::where('user_id', $user->id)
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('admin.chat.show', [
            'user' => $user,
            'messages' => $messages,
            'chatType' => 'user',
            'sessionId' => null,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $type = $request->query('type', 'user');

        $data = [
            'message' => $request->message,
            'sender_type' => 'admin',
        ];

        if ($type === 'guest') {
            $sessionId = $request->query('session');
            $data['session_id'] = $sessionId;
        } else {
            $data['user_id'] = $id;
        }

        $message = ChatMessage::create($data);

        // Clear typing indicator after sending
        $this->clearTyping($request, $id);

        if ($request->wantsJson()) {
            return response()->json($message, 201);
        }

        return back();
    }

    public function messages(Request $request, $id)
    {
        $type = $request->query('type', 'user');

        if ($type === 'guest') {
            $sessionId = $request->query('session');
            $messages = ChatMessage::where('session_id', $sessionId)
                ->orderBy('created_at', 'asc')
                ->get();

            ChatMessage::where('session_id', $sessionId)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        } else {
            $messages = ChatMessage::where('user_id', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            ChatMessage::where('user_id', $id)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return response()->json($messages);
    }

    public function typing(Request $request, $id)
    {
        $type = $request->query('type', 'user');

        $data = [
            'typer_type' => 'admin',
            'last_typed_at' => now(),
        ];

        if ($type === 'guest') {
            $sessionId = $request->query('session');
            ChatTyping::updateOrCreate(
                ['session_id' => $sessionId, 'typer_type' => 'admin'],
                $data
            );
        } else {
            ChatTyping::updateOrCreate(
                ['user_id' => $id, 'typer_type' => 'admin'],
                $data
            );
        }

        return response()->json(['success' => true]);
    }

    public function customerTyping(Request $request, $id)
    {
        $type = $request->query('type', 'user');
        $isTyping = false;

        if ($type === 'guest') {
            $sessionId = $request->query('session');
            $typing = ChatTyping::where('session_id', $sessionId)
                ->where('typer_type', 'customer')
                ->where('last_typed_at', '>=', now()->subSeconds(3))
                ->first();
            $isTyping = (bool) $typing;
        } else {
            $typing = ChatTyping::where('user_id', $id)
                ->where('typer_type', 'customer')
                ->where('last_typed_at', '>=', now()->subSeconds(3))
                ->first();
            $isTyping = (bool) $typing;
        }

        return response()->json(['typing' => $isTyping]);
    }

    public function unreadTotal()
    {
        $count = ChatMessage::where('sender_type', 'customer')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    private function clearTyping(Request $request, $id)
    {
        $type = $request->query('type', 'user');

        if ($type === 'guest') {
            $sessionId = $request->query('session');
            ChatTyping::where('session_id', $sessionId)->where('typer_type', 'admin')->delete();
        } else {
            ChatTyping::where('user_id', $id)->where('typer_type', 'admin')->delete();
        }
    }
}

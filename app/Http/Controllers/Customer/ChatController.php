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
    // Bad words list - English & Tagalog profanity
    private const BLOCKED_WORDS = [
        // English
        'fuck', 'fucking', 'fucker', 'fucked', 'fck', 'fuk', 'f u c k',
        'shit', 'shitty', 'bullshit', 'sh1t', 'sht',
        'bitch', 'bitches', 'b1tch',
        'ass', 'asshole', 'a-hole', 'assh0le',
        'damn', 'damned', 'dammit',
        'dick', 'd1ck',
        'bastard', 'b@stard',
        'crap',
        'cunt',
        'whore', 'slut',
        'stfu', 'wtf', 'lmfao',
        'motherfucker', 'mofo', 'mf',
        'retard', 'retarded',
        'idiot', 'stupid', 'dumb',
        'nigga', 'nigger',

        // Tagalog / Filipino
        'putangina', 'putang ina', 'putang-ina', 'puta', 'potangina', 'ptngina', 'ptng ina', 'ptngin', 'tangina', 'tang ina', 'tang-ina', 'tanginamo', 'tangina mo', 'pisting yawa',
        'gago', 'gaga', 'g@go',
        'bobo', 'b0b0', 'tanga', 't@nga', 'engot', 'inutil', 'gunggong',
        'tarantado', 'tarantada',
        'hayop ka', 'hayup ka',
        'leche', 'letse', 'lintik', 'lintek',
        'ulol', 'ol0l', 'ulul',
        'kupal', 'kup@l',
        'peste', 'p3ste',
        'bwisit', 'bwiset', 'buset',
        'pakyu', 'pak yu', 'pakshet', 'paksh3t',
        'hinayupak', 'hayop',
        'punyeta', 'punyemas', 'pun yeta',
        'siraulo', 'sira ulo',
        'animal ka', 'anak ng puta',
        'kingina', 'king ina', 'kinginamo',
        'yawa', 'buang', 'bugo',
    ];

    private const AUTO_REPLIES = [
        'order' => [
            'keywords' => ['order', 'track', 'tracking', 'status', 'where is my', 'delivery status', 'my order'],
            'reply' => "You can check your order status by going to your Profile > Transactions. If you have concerns about a specific order, please share your order number and we'll look into it for you!",
        ],
        'shipping' => [
            'keywords' => ['shipping', 'deliver', 'delivery', 'how long', 'ship', 'arrive', 'when will'],
            'reply' => "Once your order is confirmed and payment is verified, we'll process it right away. You can track your order status anytime in Profile > Transactions. For specific delivery concerns, feel free to message us!",
        ],
        'payment' => [
            'keywords' => ['payment', 'pay', 'gcash', 'cash', 'how to pay', 'payment method', 'cod'],
            'reply' => "We accept the following payment methods:\n- GCash (upload your receipt at checkout)\n- Cash on Delivery (COD)\n\nFor GCash payments, please make sure to upload a clear screenshot of your payment receipt.",
        ],
        'refund' => [
            'keywords' => ['refund', 'return', 'exchange', 'cancel', 'money back', 'cancelled'],
            'reply' => "For refund, return, or cancellation concerns, please message us directly with your order number and we'll assist you. An admin will review your request and get back to you as soon as possible.",
        ],
        'product' => [
            'keywords' => ['product', 'stock', 'available', 'price', 'how much', 'do you have', 'sell', 'item', 'buy', 'purchase'],
            'reply' => "You can browse all our available products on the Shop page. Use the search bar, filter by category, or sort by price to find what you need. If you're looking for something specific, let us know!",
        ],
        'cart' => [
            'keywords' => ['cart', 'add to cart', 'checkout', 'bag'],
            'reply' => "To purchase items, simply browse our Shop, click 'Add to Cart' on the products you want, then go to your Cart to review and checkout. You can pay via GCash or Cash on Delivery!",
        ],
        'favorite' => [
            'keywords' => ['favorite', 'favourites', 'wishlist', 'save', 'liked'],
            'reply' => "You can save products you love by clicking the heart icon on any product! View all your saved items anytime from the Favorites page.",
        ],
        'donate' => [
            'keywords' => ['donate', 'donation', 'charity', 'help', 'rescue', 'shelter', 'stray', 'contribute'],
            'reply' => "Thank you for your interest in donating! You can visit our Donate page to contribute cash or products for rescued and stray animals. Every little bit counts!",
        ],
        'account' => [
            'keywords' => ['account', 'register', 'sign up', 'login', 'password', 'forgot', 'reset', 'profile'],
            'reply' => "For account-related concerns:\n- Register: Click 'Sign Up' on the login page\n- Forgot Password: Use the 'Forgot Password' link on the login page\n- Update Profile: Go to your Profile page after logging in\n\nNeed more help? Just let us know!",
        ],
        'ticket' => [
            'keywords' => ['ticket', 'reactivate', 'blocked', 'deactivated', 'locked', 'suspended', 'unblock', 'activate'],
            'reply' => "If your account has been deactivated or blocked, you can submit a reactivation ticket here:\n\n/support/ticket\n\nYou'll need your registered email to submit a ticket. You can also track your ticket status anytime.",
        ],
        'promo' => [
            'keywords' => ['discount', 'promo', 'sale', 'coupon', 'voucher', 'offer', 'deal', 'promotion'],
            'reply' => "Check our Shop page for the latest promotions and deals on selected pet products! We regularly update our offers so keep an eye out.",
        ],
        'greeting' => [
            'keywords' => ['hi', 'hello', 'hey', 'good morning', 'good afternoon', 'good evening', 'sup', 'yo', 'magandang'],
            'reply' => "Hi there! Welcome to Pawsitive Vibes! How can we help you today? You can ask about our products, orders, payments, donations, or anything else!",
        ],
        'thanks' => [
            'keywords' => ['thank', 'thanks', 'thank you', 'salamat', 'appreciate'],
            'reply' => "You're welcome! If you have any other questions, feel free to ask. Happy shopping and give your fur babies a treat from us!",
        ],

        // ── Pet Care Knowledge Base ──
        'dog_sick_food' => [
            'keywords' => ['dog eat when sick', 'dog food sick', 'sick dog eat', 'feed sick dog', 'dog not eating', 'dog won\'t eat', 'dog upset stomach', 'dog vomiting food', 'dog diarrhea food', 'aso may sakit kain', 'dog stomach'],
            'reply' => "When your dog is sick, here are some bland, easy-to-digest foods you can offer:\n- Boiled chicken (no skin, no seasoning)\n- Plain white rice\n- Boiled sweet potato or pumpkin\n- Bone broth (low sodium, no onion/garlic)\n\nImportant tips:\n- Serve small portions frequently instead of one big meal\n- Always keep fresh water available to prevent dehydration\n- Avoid fatty, spicy, or seasoned food\n- If your dog hasn't eaten for more than 24 hours or shows severe symptoms, please visit a vet immediately.\n\nWe carry digestive health pet food in our Shop — check it out!",
        ],
        'cat_sick_food' => [
            'keywords' => ['cat eat when sick', 'cat food sick', 'sick cat eat', 'feed sick cat', 'cat not eating', 'cat won\'t eat', 'cat upset stomach', 'cat vomiting food', 'pusa may sakit', 'cat stomach'],
            'reply' => "When your cat is sick and not eating well, try these:\n- Boiled chicken or fish (plain, no seasoning)\n- Warm wet cat food (warming it releases more aroma)\n- Meat-based baby food (no onion/garlic)\n- Bone broth (plain, no seasoning)\n\nHelpful tips:\n- Cats can be dangerous if they don't eat for more than 24-48 hours (risk of fatty liver disease)\n- Try hand-feeding small amounts\n- Keep them hydrated — offer water or unflavored Pedialyte\n- If refusing food for more than a day, please see a vet right away.\n\nBrowse our cat food selection in the Shop for recovery-friendly options!",
        ],
        'dog_food_general' => [
            'keywords' => ['what do dogs eat', 'dog food', 'feed my dog', 'best food for dog', 'dog diet', 'what to feed dog', 'puppy food', 'puppy eat', 'dog nutrition', 'ano kinakain ng aso'],
            'reply' => "Dogs thrive on a balanced diet! Here's a quick guide:\n\nCommercial food: High-quality dry kibble or wet food appropriate for their age (puppy, adult, senior).\n\nSafe human foods:\n- Lean meats (chicken, beef, fish — cooked, no seasoning)\n- Vegetables (carrots, green beans, sweet potato)\n- Fruits (apple slices, banana, blueberries — no grapes!)\n\nFoods to AVOID:\n- Chocolate, grapes, raisins, onions, garlic\n- Xylitol (found in sugar-free products)\n- Cooked bones (can splinter)\n- Salty or fatty foods\n\nCheck out our Shop for premium dog food brands!",
        ],
        'cat_food_general' => [
            'keywords' => ['what do cats eat', 'cat food', 'feed my cat', 'best food for cat', 'cat diet', 'what to feed cat', 'kitten food', 'kitten eat', 'cat nutrition', 'ano kinakain ng pusa'],
            'reply' => "Cats are obligate carnivores — they need meat-based diets! Here's a guide:\n\nCommercial food: Quality wet or dry cat food with real meat as the first ingredient.\n\nSafe human foods (in moderation):\n- Cooked chicken, turkey, or fish (plain)\n- Small amounts of cooked eggs\n- Pumpkin (great for digestion)\n\nFoods to AVOID:\n- Onions, garlic, chocolate\n- Raw eggs or raw fish\n- Milk/dairy (most cats are lactose intolerant)\n- Dog food (lacks nutrients cats need)\n\nVisit our Shop for a great selection of cat food!",
        ],
        'pet_vaccination' => [
            'keywords' => ['vaccine', 'vaccination', 'vaccinate', 'anti rabies', 'rabies', 'shots', 'inject', 'bakuna', 'deworm', 'deworming', '5 in 1', 'dhpp'],
            'reply' => "Vaccinations are essential for your pet's health!\n\nFor Dogs:\n- 6-8 weeks: First DHPP (Distemper, Hepatitis, Parvovirus, Parainfluenza)\n- Boosters every 2-4 weeks until 16 weeks\n- Anti-rabies: at 3 months old, then annually\n- Deworming: every 2 weeks until 12 weeks, then monthly until 6 months\n\nFor Cats:\n- 6-8 weeks: FVRCP (Feline Viral Rhinotracheitis, Calicivirus, Panleukopenia)\n- Boosters every 3-4 weeks until 16 weeks\n- Anti-rabies: at 3 months old, then annually\n\nAlways consult your vet for a personalized schedule. Keep your fur babies protected!",
        ],
        'pet_grooming' => [
            'keywords' => ['groom', 'grooming', 'bath', 'bathe', 'bathing', 'nail', 'trim', 'haircut', 'brush', 'fur', 'shedding', 'shed', 'shampoo', 'paligo', 'ligo aso', 'ligo pusa'],
            'reply' => "Here are some grooming tips for your pets:\n\nBathing:\n- Dogs: Every 4-6 weeks (or when dirty/smelly)\n- Cats: Rarely needed — they groom themselves! Only bathe if very dirty\n- Use pet-specific shampoo, never human shampoo\n\nBrushing:\n- Short-haired pets: 1-2x per week\n- Long-haired pets: Daily to prevent matting\n\nNail Trimming:\n- Every 2-4 weeks\n- Be careful of the quick (pink part inside the nail)\n\nEar Cleaning:\n- Weekly check, clean as needed\n- Watch for redness, odor, or discharge\n\nWe have grooming supplies available in our Shop!",
        ],
        'pet_health' => [
            'keywords' => ['sick pet', 'pet sick', 'vet', 'veterinarian', 'dog sick', 'cat sick', 'pet illness', 'pet disease', 'symptoms', 'fever', 'lethargic', 'lethargy', 'not feeling well', 'may sakit', 'ticks', 'fleas', 'tick', 'flea', 'pulgas', 'garapata', 'mange', 'galis'],
            'reply' => "Common signs your pet needs veterinary attention:\n- Not eating or drinking for more than 24 hours\n- Vomiting or diarrhea that persists\n- Lethargy or unusual behavior\n- Difficulty breathing\n- Limping or signs of pain\n- Swelling, lumps, or wounds\n- Excessive scratching (could be fleas, ticks, or mange)\n\nFor ticks & fleas:\n- Use vet-approved tick/flea treatments\n- Keep your pet's environment clean\n- Regularly check fur after outdoor walks\n\nFor skin issues (mange/galis):\n- Consult a vet for proper diagnosis\n- Don't use human medication on pets\n\nWhen in doubt, always consult a veterinarian! Your pet's health comes first.",
        ],
        'pet_training' => [
            'keywords' => ['train', 'training', 'potty', 'poop', 'pee', 'housebreak', 'house train', 'obedience', 'command', 'trick', 'behave', 'behavior', 'bite', 'biting', 'bark', 'barking', 'aggressive'],
            'reply' => "Here are some basic pet training tips:\n\nPotty Training:\n- Take your dog out first thing in the morning, after meals, and before bed\n- Reward immediately after they go in the right spot\n- Be patient — accidents happen! Never punish, just redirect\n\nBasic Commands (for dogs):\n- Start with: Sit, Stay, Come, Down\n- Use positive reinforcement (treats & praise)\n- Keep sessions short (5-10 minutes)\n- Be consistent with commands\n\nFor Biting/Aggression:\n- Redirect to toys\n- Socialize early with other pets and people\n- Never use physical punishment\n- Consult a professional trainer for serious aggression\n\nPatience and consistency are key! Check our Shop for training treats!",
        ],
        'pet_adoption' => [
            'keywords' => ['adopt', 'adoption', 'rescue', 'adopt a dog', 'adopt a cat', 'adopt pet', 'rehome', 'foster', 'ampunin', 'mag ampon'],
            'reply' => "That's wonderful that you're considering adoption! Adopting saves lives and gives pets a second chance.\n\nTips for pet adoption:\n- Consider your lifestyle, space, and budget\n- Prepare supplies before bringing your pet home (food, bed, bowls, litter box for cats)\n- Be patient — rescued pets may need time to adjust\n- Schedule a vet visit within the first week\n- Give lots of love and patience!\n\nPawsitive Vibes supports animal rescue! Visit our Donate page to help rescued animals, or check local shelters and rescue groups for adoptable pets.",
        ],
        'dog_breed' => [
            'keywords' => ['dog breed', 'breed of dog', 'what breed', 'aspin', 'askal', 'shih tzu', 'poodle', 'labrador', 'golden retriever', 'bulldog', 'pomeranian', 'husky', 'beagle', 'chihuahua', 'best dog breed'],
            'reply' => "Choosing the right dog breed depends on your lifestyle!\n\nFor small spaces/apartments:\n- Shih Tzu, Pomeranian, Chihuahua, Toy Poodle\n\nFor active owners:\n- Labrador, Golden Retriever, Beagle, Husky\n\nFor families with kids:\n- Golden Retriever, Labrador, Beagle, Poodle\n\nFor first-time owners:\n- Shih Tzu, Poodle, Golden Retriever\n\nDon't forget the mighty ASPIN (Asong Pinoy)! They're loyal, smart, and resilient. Adopt, don't shop!\n\nWhatever breed you choose, we have food and supplies for all dogs in our Shop!",
        ],
        'pet_age' => [
            'keywords' => ['how old', 'pet age', 'dog age', 'cat age', 'dog years', 'cat years', 'lifespan', 'how long do dogs live', 'how long do cats live', 'senior dog', 'senior cat', 'old dog', 'old cat'],
            'reply' => "Here's a quick guide on pet ages and lifespans:\n\nDogs:\n- Small breeds: 12-16 years\n- Medium breeds: 10-14 years\n- Large breeds: 8-12 years\n- Dogs are considered seniors at 7+ years\n- 1 dog year ≈ 7 human years (roughly)\n\nCats:\n- Indoor cats: 12-18 years (some live 20+!)\n- Outdoor cats: 5-10 years\n- Cats are considered seniors at 10+ years\n\nKeep your senior pets healthy with:\n- Regular vet checkups (every 6 months)\n- Age-appropriate food\n- Gentle exercise\n- Lots of love and comfort\n\nWe carry senior pet food in our Shop!",
        ],
        'pet_emergency' => [
            'keywords' => ['emergency', 'poisoned', 'poison', 'hit by car', 'bleeding', 'choking', 'seizure', 'not breathing', 'unconscious', 'accident', 'lason', 'nakalunok', 'nabangga'],
            'reply' => "If your pet is in an emergency, please act quickly:\n\n1. Stay calm\n2. Call your nearest emergency vet clinic immediately\n3. Do NOT give any medication without vet guidance\n\nCommon emergencies:\n- Poisoning: Note what they ingested, bring the container/sample to the vet\n- Bleeding: Apply gentle pressure with a clean cloth\n- Choking: Check mouth carefully, do NOT reach in blindly\n- Seizure: Keep them safe from objects, do NOT restrain them, time the seizure\n- Not breathing: Rush to the vet immediately\n\nKnow your nearest 24/7 vet clinic BEFORE an emergency happens. Your pet's life may depend on quick action!",
        ],

        'fallback_help' => [
            'keywords' => ['help', 'assist', 'support', 'question', 'how', 'what can'],
            'reply' => "Here's what I can help you with:\n\nShopping & Orders:\n- Browse products on our Shop page\n- Track orders in Profile > Transactions\n- Payment methods (GCash & COD)\n\nPet Care:\n- What to feed dogs & cats\n- What to feed sick pets\n- Vaccination schedules\n- Grooming tips\n- Training basics\n- Pet health & emergencies\n- Adoption advice\n\nOther:\n- Donations for rescued animals\n- Account or login issues\n- Submit a support ticket\n\nJust ask about any of these!",
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

        // Check for profanity
        if ($this->containsProfanity($request->message)) {
            return response()->json([
                'error' => 'profanity',
                'message' => 'Your message contains inappropriate language. Please keep the conversation respectful. 🐾',
            ], 422);
        }

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
            ['text' => 'How do I buy products?', 'icon' => 'truck'],
            ['text' => 'What should I feed my sick dog?', 'icon' => 'heart'],
            ['text' => 'Dog & cat vaccination schedule', 'icon' => 'heart'],
            ['text' => 'Pet grooming tips', 'icon' => 'heart'],
            ['text' => 'How can I donate?', 'icon' => 'heart'],
            ['text' => 'Any promotions available?', 'icon' => 'refresh'],
            ['text' => 'I need help with my account', 'icon' => 'map-pin'],
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

    private function containsProfanity(string $message): bool
    {
        $message = strtolower(trim($message));
        // Remove special characters that might be used to bypass filter (keep spaces)
        $cleaned = preg_replace('/[^a-z0-9\s]/', '', $message);
        // Also check version with spaces collapsed
        $noSpaces = preg_replace('/\s+/', '', $cleaned);

        foreach (self::BLOCKED_WORDS as $word) {
            $cleanWord = preg_replace('/[^a-z0-9\s]/', '', strtolower($word));
            $wordNoSpaces = preg_replace('/\s+/', '', $cleanWord);

            // Check in original message
            if (str_contains($cleaned, $cleanWord)) {
                return true;
            }
            // Check with spaces removed (catches "f u c k", "p u t a", etc.)
            if (strlen($wordNoSpaces) > 2 && str_contains($noSpaces, $wordNoSpaces)) {
                return true;
            }
        }

        return false;
    }

    private function getAutoReply(string $message): ?string
    {
        $message = strtolower(trim($message));
        // Normalize common filler words and typos for better matching
        $normalized = preg_replace('/\b(uhm|um|umm|uh|like|po|naman|ba|kasi|nga|eh|ah|oh)\b/', '', $message);
        $normalized = preg_replace('/\s+/', ' ', trim($normalized));

        $bestMatch = null;
        $bestScore = 0;

        foreach (self::AUTO_REPLIES as $topic => $config) {
            $score = 0;
            foreach ($config['keywords'] as $keyword) {
                $lowerKeyword = strtolower($keyword);
                // Check against both original and normalized message
                if (str_contains($message, $lowerKeyword) || str_contains($normalized, $lowerKeyword)) {
                    // Longer keyword matches = higher confidence
                    $score += strlen($keyword) * 2;
                } else {
                    // Check if individual words from multi-word keywords are present
                    $keywordWords = explode(' ', $lowerKeyword);
                    if (count($keywordWords) > 1) {
                        $matchedWords = 0;
                        foreach ($keywordWords as $word) {
                            if (strlen($word) > 2 && str_contains($normalized, $word)) {
                                $matchedWords++;
                            }
                        }
                        // If most words from the keyword phrase are found, partial match
                        if ($matchedWords >= ceil(count($keywordWords) * 0.6)) {
                            $score += $matchedWords * 2;
                        }
                    }
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

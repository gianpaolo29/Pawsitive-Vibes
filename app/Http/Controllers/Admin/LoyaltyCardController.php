<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{LoyaltyCard, User};
use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyCardController extends Controller
{
    public function __construct(private LoyaltyService $loyalty) {}

    public function index(Request $request)
    {
        $q = trim((string)$request->get('q',''));

        $cards = LoyaltyCard::query()
            ->with('user:id,fname,lname,email')
            ->when($q !== '', function ($qq) use ($q) {
                $qq->whereHas('user', function ($u) use ($q) {
                    $u->where('fname','like',"%{$q}%")
                        ->orWhere('lname','like',"%{$q}%")
                        ->orWhere('email','like',"%{$q}%");
                });
            })
            ->orderByDesc('stickers_balance')
            ->paginate(12)->withQueryString();

        return view('admin.loyalty.cards.index', compact('cards','q'));
    }

    public function show(LoyaltyCard $card)
    {
        $card->load(['user:id,fname,lname,email','events' => fn($q) => $q->latest()]);
        return view('admin.loyalty.cards.show', compact('card'));
    }

    public function adjust(Request $request, LoyaltyCard $card)
    {
        $data = $request->validate([
            'stickers' => ['required','integer','not_in:0','between:-100,100'],
        ]);

        $this->loyalty->adjust($card->id, (int)$data['stickers'], Auth::id());

        return back()->with('success', 'Sticker balance adjusted.');
    }
}

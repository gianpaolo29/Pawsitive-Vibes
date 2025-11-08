<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyRedemption;
use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyRedemptionController extends Controller
{
    public function __construct(private LoyaltyService $loyalty) {}

    public function index(Request $request)
    {
        $status = $request->get('status');

        $redemptions = LoyaltyRedemption::query()
            ->with(['card.user:id,fname,lname','reward:id,name'])
            ->when($status, fn($q) => $q->where('status',$status))
            ->latest()
            ->paginate(15)->withQueryString();

        return view('admin.loyalty.redemptions.index', compact('redemptions','status'));
    }

    public function approve(LoyaltyRedemption $redemption)
    {
        $this->loyalty->approve($redemption, Auth::id());
        return back()->with('success', 'Redemption approved.');
    }

    public function reject(LoyaltyRedemption $redemption)
    {
        $this->loyalty->reject($redemption, Auth::id());
        return back()->with('success', 'Redemption rejected');
    }
}

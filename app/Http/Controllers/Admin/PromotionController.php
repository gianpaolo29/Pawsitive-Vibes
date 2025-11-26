<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $promotions = Promotion::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('code', 'like', "%{$q}%");
                });
            })
            ->when($status === 'active', fn($qr) => $qr->where('is_active', true))
            ->when($status === 'inactive', fn($qr) => $qr->where('is_active', false))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.promotions.index', compact('promotions', 'q', 'status'));
    }

    public function create()
    {
        $promotion = new Promotion([
            'discount_type' => 'percent',
            'is_active'     => true,
        ]);

        return view('admin.promotions.form', compact('promotion'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:180'],
            'code'           => ['required', 'string', 'max:50', 'unique:promotions,code'],
            'discount_type'  => ['required', Rule::in(['percent', 'fixed'])],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'starts_at'      => ['nullable', 'date'],
            'ends_at'        => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active'      => ['boolean'],
            'description'    => ['nullable', 'string'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        Promotion::create($data);

        return redirect()
            ->route('admin.promotions.index')
            ->with('ok', 'Promotion created.');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.form', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:180'],
            'code'           => [
                'required',
                'string',
                'max:50',
                Rule::unique('promotions', 'code')->ignore($promotion->id),
            ],
            'discount_type'  => ['required', Rule::in(['percent', 'fixed'])],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'starts_at'      => ['nullable', 'date'],
            'ends_at'        => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active'      => ['boolean'],
            'description'    => ['nullable', 'string'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $promotion->update($data);

        return redirect()
            ->route('admin.promotions.index')
            ->with('ok', 'Promotion updated.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return back()->with('ok', 'Promotion deleted.');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->update(['is_active' => ! $promotion->is_active]);

        return back()->with('ok', 'Promotion status updated.');
    }
}

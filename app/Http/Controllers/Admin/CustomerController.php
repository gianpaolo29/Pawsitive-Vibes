<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim((string) $request->get('q', ''));
        $sort    = $request->get('sort', 'created_at');
        $dir     = $request->get('dir', 'desc');
        $perPage = (int) $request->get('per_page', 10);

        $sortable = ['fname', 'lname', 'username', 'email', 'created_at'];
        if (!in_array($sort, $sortable, true)) $sort = 'created_at';
        if (!in_array($dir, ['asc', 'desc'], true)) $dir = 'desc';

        $qbase = User::where('role', 'customer');

        if ($q !== '') {
            $qbase->where(function ($qq) use ($q) {
                $qq->where('fname', 'like', "%{$q}%")
                ->orWhere('lname', 'like', "%{$q}%")
                ->orWhereRaw("concat(fname,' ',lname) like ?", ["%{$q}%"])
                ->orWhere('username', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $customers = $qbase->orderBy($sort, $dir)->paginate($perPage)->withQueryString();

        $stats = [
            'total_customers'  => User::where('role', 'customer')->count(),
            'new_this_month'   => User::where('role', 'customer')
                                      ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                                      ->count(),
        ];

        return view('admin.customers.index', compact('customers', 'q', 'sort', 'dir', 'perPage', 'stats'));
    }

    public function create()
    {
        return view('admin.customers.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password'   => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated) {
            User::create([
                'fname'    => $validated['first_name'],
                'lname'    => $validated['last_name'],
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'customer',
            ]);
        });

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer added successfully!');
    }

    public function edit(User $customer)
    {
        abort_unless($customer->role === 'customer', 404);
        return view('admin.customers.form', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        abort_unless($customer->role === 'customer', 404);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($customer->id)],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($customer->id)],
            'password'   => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        DB::transaction(function () use ($customer, $validated) {
            $update = [
                'fname'    => $validated['first_name'],
                'lname'    => $validated['last_name'],
                'username' => $validated['username'],
                'email'    => $validated['email'],
            ];
            if (!empty($validated['password'])) {
                $update['password'] = Hash::make($validated['password']);
            }
            $customer->update($update);
        });

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    public function destroy(User $customer)
    {
        abort_unless($customer->role === 'customer', 404);
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}

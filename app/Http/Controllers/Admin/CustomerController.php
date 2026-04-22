<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user): View
    {
        $user->load('orders');

        return view('admin.customers.show', compact('user'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.customers.index')
                ->with('error', 'Không thể xóa tài khoản admin.');
        }

        $user->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Xóa khách hàng thành công.');
    }
}
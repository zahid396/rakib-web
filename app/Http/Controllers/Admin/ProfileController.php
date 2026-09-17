<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.account.index');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Auth::guard('admin')->user();

        if (! Hash::check($validated['current_password'], $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ])->with('error', 'Could not update password.');
        }

        if (Hash::check($validated['password'], $admin->password)) {
            return back()->with('error', 'New password must be different from your current password.');
        }

        $admin->update([
            'password' => $validated['password'],
        ]);

        AdminNotifier::securityAlert(
            "The admin password for account {$admin->email} was changed at " . now()->format('d M Y, H:i') . " from IP {$request->ip()}."
        );

        return back()->with('success', 'Password updated successfully.');
    }
}
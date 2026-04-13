<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load('userGroup', 'schoolClass', 'faculty');
        return view('client.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'phone'     => 'nullable|string|max:20',
            'birthdate' => 'nullable|date|before:today',
            'photo'     => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if stored locally
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('avatars', 'public');
        } else {
            unset($validated['photo']);
        }

        $user->update($validated);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.'])
                ->withFragment('password-section');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success_password', 'Đổi mật khẩu thành công!');
    }
}

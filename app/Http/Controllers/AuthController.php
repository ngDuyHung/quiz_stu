<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Thêm điều kiện status = 1 để chỉ cho phép tài khoản đang hoạt động đăng nhập
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status' => 1])) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        // Kiểm tra xem email có tồn tại nhưng bị khóa không để đưa ra thông báo chính xác
        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->status == 0) {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.'
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.'
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'role' => 0, // Default role = 0 (client)
        ]);

        Auth::login($user);
        return redirect()->route('client.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    private function redirectBasedOnRole()
    {
        $role = Auth::user()->role;
        if ($role == 0) {
            return redirect()->route('client.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
}

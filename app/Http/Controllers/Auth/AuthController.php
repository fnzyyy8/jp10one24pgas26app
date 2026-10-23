<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAuthRequest;
use App\Services\ModuleService\Auth\AuthService;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Inertia\Inertia;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    )
    {
    }

    public function login()
    {
        return Inertia::render('Auth/LoginPage', []);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password tidak sesuai',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Hubungi administrator.'
            ])->onlyInput('email');
        }

        if ($user->role !== 'super_admin' && (empty($user->verified_at) || empty($user->verified_by))) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Hubungi administrator.'
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with(['success' => 'Berhasil login']);
    }

    public function register()
    {
        return Inertia::render('Auth/RegisterPage', []);
    }

    public function create(CreateAuthRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make('Daanmogot123@');
            $this->service->create($data);
            return redirect()->route('login')->with('success', 'Creating Account Has Been Requested');

        } catch (Throwable $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }

    public function profile(Request $request)
    {
        return Inertia::render('Profile/ProfilePage', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $this->service->updateProfile(
            $user->id,
            $request->validated(),
        );

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->service->updatePassword(
            $request->user()->id,
            $request->validated()['password'],
        );

        return redirect()
            ->route('profile.show')
            ->with('success', 'Password updated successfully.');
    }
}

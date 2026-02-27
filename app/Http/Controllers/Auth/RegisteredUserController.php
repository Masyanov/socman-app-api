<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SettingLoadcontrol;
use App\Models\SettingUser;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Subscription;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Services\SmartCaptchaService;

class RegisteredUserController extends Controller {
    public function create() {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate main fields (do not validate recaptcha with a custom rule here)
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role'      => ['required', 'string', 'max:255'],
            'team_code' => ['nullable', 'regex:/^\d{3}-\d{3}$/'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            'ref'       => ['nullable', 'string'],
        ]);

        $token = $request->input('smart-token');

        if (empty($token)) {
            return back()->withErrors(['smart-token' => __('messages.Ошибка проверки безопасности. Обновите страницу и попробуйте снова.')])->withInput();
        }

        $captcha = new SmartCaptchaService();
        $result = $captcha->verify($token);

        \Log::info('register SmartCaptcha', [
            'status' => $result['status'] ?? null,
            'success' => $result['success'] ?? false,
        ]);

        if (empty($result['success'])) {
            return back()->withErrors(['smart-token' => __('messages.Ошибка проверки безопасности. Попробуйте позже.')])->withInput();
        }

        // Continue registration flow (your existing code)
        $teamCode = $request->team_code ?? '000-000';

        if ($request->role === 'coach') {
            $active      = 1;
            $loadControl = 0;
        } else {
            $active      = 0;
            $loadControl = 0;
        }

        $user = User::create([
            'name'         => $request->name,
            'second_name'  => $request->second_name,
            'last_name'    => $request->last_name,
            'role'         => $request->role,
            'team_code'    => $teamCode,
            'email'        => $request->email,
            'load_control' => $loadControl,
            'password'     => Hash::make($request->password),
            'active'       => $active,
        ]);

        // rest of your code unchanged...
        if ($user->role === 'admin') {
            $user->generateReferralCode();
        }

        if ($user->role === 'coach' && $request->ref) {
            $setting = SettingUser::where('slug', 'referral_code')
                                  ->where('value', $request->ref)
                                  ->where('active', true)
                                  ->first();
            if ($setting && $setting->user && $setting->user->role === 'admin') {
                $setting->user->coaches()->attach($user->id);
            }
        }

        UserMeta::create(['user_id' => $user->id]);

        if ($request->role == 'coach') {
            Subscription::create([
                'user_id'    => $user->id,
                'start_date' => Carbon::now()->toDateString(),
                'end_date'   => Carbon::now()->addDays(365)->toDateString(),
                'subscription'    => 'mini',
                'is_paid'    => false,
            ]);

            SettingLoadcontrol::create([
                'user_id'               => $user->id,
                'on_load'               => 0,
                'on_extra_questions'    => 0,
                'question_recovery_min' => 0,
                'question_load_min'     => 0,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}

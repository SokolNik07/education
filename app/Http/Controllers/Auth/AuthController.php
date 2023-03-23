<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
        $data = $request->validated();
        if (User::where('name', '=', $data['name'])->exists()) {
            print_r('ИМЯ ЗАНЯТО!');
        }
        if (User::where('email', '=', $data['email'])->exists()) {
            print_r('email занят!');
        }

        $user = User::create($data);
        if ($user) {
            event(new Registered($user));
            Auth::login($user);
            return new UserResource($user);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $request->get('email'))->first(); // найти одного пользователя с совпавшим email

        if (!$user) {
            return Response::deny('Такого пользователя нет или email указан не верно');
        }
        if (Auth::attempt($data, $request->boolean('remember'))) {                                        // если попытка аутентификации прошла успешно то
            $token = $user->createToken('base');
            return response()->json([
                'token' => $token->plainTextToken // сгенерировать новый токен и вывести его текстовое значение
            ]);
        }
        return Response::deny('email или пароль указаны не верно');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Response::deny('Вы свободны');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return Response::deny("Ссылка для сброса пароля была отправлена на вашу почту {$request['email']}");
        }
        return Response::deny('Данная почта не существует либо указанна не верно');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed']
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return Response::deny("Пароль успешно обновлён!");
        }
        return Response::deny('Данная почта не существует либо указанна не верно');
    }
}

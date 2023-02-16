<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $request->get('email'))->first(); // найти одного пользователя с совпавшим email

        if (!$user) {
            return ('Такого пользователя нет или email указан не верно');
        }
        if (Auth::attempt($data)) {                                        // если попытка аутентификации прошла успешно то
            $token = $user->createToken('base');
            return response()->json([
                'token' => $token->plainTextToken                          // сгенерировать новый токен и вывести его текстовое значение
            ]);
        }
        return ('email или пароль указаны не верно');
    }
}


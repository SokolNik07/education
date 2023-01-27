<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            print_r('Вы авторизовались!');
        }
        print_r('данные указанны не верно!');
    }
}

<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegistrationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request)
    {
        $data = $request->validated();

        if (User::where('name', '=', $data['name'])->exists() ) {
            print_r('ИМЯ ЗАНЯТО!');
        }
        if (User::where('email', '=', $data['email'])->exists() ) {
            print_r('email занят!');
        }

        $user = User::create($data);

        if($user) {
//            event(new Registered($user));
            Auth::login($user);
        }
    }
}

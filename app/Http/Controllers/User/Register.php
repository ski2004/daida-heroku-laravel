<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Register extends Controller
{
    /**
     * login
     *
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    public function __invoke(UserRegister $request)
    {
        // 建立資料
        $user = User::create($request->toArray());

        // 登入
        Auth::login($user, true);
        $token = $user->createToken('authToken')->plainTextToken;
        return $this->success([
            'access_token' => $token
        ]);
    }
}

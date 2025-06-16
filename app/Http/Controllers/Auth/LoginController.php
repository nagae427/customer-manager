<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //後でやる
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    //ログイン画面表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'password' => ['required'],
        ]);


        $user = \App\Models\User::where('id', $credentials['user_id'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {  //パスワードのハッシュ値が一致するかの確認
            Auth::login($user, $request->filled('remenber'));
            $request->session()->regenerate(); //セッション固定攻撃を防ぐ
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'user_id' => 'ユーザIDが違います',
            'password' => 'パスワードが違います',
        ])->onlyInput('user_id');   //user_idは残しておく、passwordはセキュリティのために再入力させる
    }
}

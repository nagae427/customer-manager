<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //ログアウト処理
    public function logout(Request $request)
    {
        //ログアウトする
        Auth::logout();

        //セッションの無効化
        $request->session()->invalidate();

        //新しいCSRFトークンを再生成する
        $request->session()->regenerateToken();

        //トップにリダイレクト
        return redirect('/login');
    }
}

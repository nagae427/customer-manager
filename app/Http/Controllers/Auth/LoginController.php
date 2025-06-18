<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        //空の場合
        $messages = [
        'user_id.required' => 'ユーザIDは必須です。',
        'password.required' => 'パスワードは必須です。',
        ];

        //空の場合はここで処理が停止し、必須エラーメッセージをフォームに送る
        $credentials = $request->validate([
            'user_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], $messages);

        //ここに到達したということは、入力欄が少なくとも一文字以上入力されているということ
        if (Auth::attempt(['id' => $credentials['user_id'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();  //セッションIDを新しいものにする(セッション固定攻撃対策)
            return redirect()->intended('dashboard');
        }

        // 認証失敗
        // ValidationException をスローし、user_id と password の両方のエラーメッセージを含める
        //ValidationException は自動でエラーメッセージがセッションにフラッシュされ、ユーザが直前のページにリダイレクトされる。
        // return back()->withErrors()がいらない
        throw ValidationException::withMessages([
            'error' => ['入力されたユーザーIDまたはパスワードが正しくありません。'], // エラーメッセージ
        ]);
    }
}

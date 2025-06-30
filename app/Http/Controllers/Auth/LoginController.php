<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter; // RateLimiterを使用してログイン試行の制限を行う
use Illuminate\Support\Str; // Strを使用してキーを生成するために使用

class LoginController extends Controller
{
    /**
     * ログイン画面表示
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ログインを実行
     */
    public function login(Request $request)
    {
        // ログイン試行回数とロックアウトのキーを作成
        $throttleKey = Str::lower($request->input('user_id')) . '|' . $request->ip();
        $maxAttempts = 5; //5回まで試行OK
        $decayMinutes = 1; //ロックされる分数

        //試行回数が指定された最大試行回数を超えていたらロックアウト処理を追加
        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            //ロックアウトされている場合
            $seconds = rateLimiter::availableIn($throttleKey); 
            throw ValidationException::withmessages([
                'error' => ["ログイン試行回数が上限を超えました。あと{$seconds}秒お待ちください。"],
            ]);
        }

        //空または文字列でない場合はここで処理が停止し、必須、文字列必須エラーメッセージをフォームに送る
        $credentials = $request->validate([
            'user_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // passworedはbcryptでハッシュ化されているので、パスワードの長さは255文字まで許容される。
        if (Auth::attempt(['id' => $credentials['user_id'], 'password' => $credentials['password']])) {
            RateLimiter::clear($throttleKey);  //成功した試行回数をリセット
            $request->session()->regenerate();  //セッションIDを新しいものにする(セッション固定攻撃対策)
            return redirect()->intended('users');
        }

        /*認証失敗
        失敗するたびに$throttleKeyに関連付けられた試行回数がカウントされる。あと、60秒に毎度延長される
        */
        RateLimiter::hit($throttleKey, $decayMinutes * 60);  
        // ValidationException をスローし、user_id と password の両方のエラーメッセージを含める
        //ValidationException は自動でエラーメッセージがセッションにフラッシュされ、ユーザが直前のページにリダイレクトされる。
        // return back()->withErrors()がいらない
        throw ValidationException::withMessages([
            'error' => ['入力されたユーザーIDまたはパスワードが正しくありません。'], 
        ]);
    }
}

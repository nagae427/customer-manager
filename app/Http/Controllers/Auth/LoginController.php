<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter; // RateLimiterを使用してログイン試行の制限を行う
use Illuminate\Cache\RateLimiting\Limit; // RateLimiterの制限を設定するために使用
use Illuminate\Support\Str; // Strを使用してキーを生成するために使用

class LoginController extends Controller
{

    //ログイン画面表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //ログイン試行回数とロックアウトのキーを作成
        $throttleKey = Str::lower($request->input('user_id')) . '|' . $request->ip();
        $maxAttempts = 5; //5回まで試行OK
        $decayMinutes = 1; //ロックされる分数

        //試行回数チェックしてロックアウト処理を追加
        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            //ロックアウトされている場合
            $seconds = rateLimiter::availableIn($throttleKey); //あと何秒か
            throw ValidationException::withmessages([
                'error' => ["ログイン試行回数が上限を超えました。あと{$seconds}秒お待ちください。"],
            ]);
        }

        //空の場合,文字列でない場合のエラーメッセージを定義
        $messages = [
            'user_id.required' => 'ユーザIDは必須です。',
            'password.required' => 'パスワードは必須です。',
            'user_id.string' => 'ユーザIDは文字列でなければなりません。',
            'password.string' => 'パスワードは文字列でなければなりません。',
        ];

        //空の場合はここで処理が停止し、必須エラーメッセージをフォームに送る
        $credentials = $request->validate([
            'user_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], $messages);

        //ここに到達したということは、入力欄が少なくとも一文字以上入力されているということ]
        // passworedはbcryptでハッシュ化されているので、パスワードの長さは255文字まで許容される。
        if (Auth::attempt(['id' => $credentials['user_id'], 'password' => $credentials['password']])) {
            RateLimiter::clear($throttleKey);  //成功した試行回数をリセット
            $request->session()->regenerate();  //セッションIDを新しいものにする(セッション固定攻撃対策)
            return redirect()->intended('dashboard');
        }

        // 認証失敗
        RateLimiter::hit($throttleKey, $decayMinutes * 60);  //失敗するたびに$throttleKeyに関連付けられた試行回数がカウントされる。あと、60秒に毎度延長される
        // ValidationException をスローし、user_id と password の両方のエラーメッセージを含める
        //ValidationException は自動でエラーメッセージがセッションにフラッシュされ、ユーザが直前のページにリダイレクトされる。
        // return back()->withErrors()がいらない
        throw ValidationException::withMessages([
            'error' => ['入力されたユーザーIDまたはパスワードが正しくありません。'], // エラーメッセージ
        ]);
    }
}

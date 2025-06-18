<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Throwable; // エラーハンドリングのため

class LogoutController extends Controller
{
    //ログアウト処理
    public function logout(Request $request)
    {
        try {
            //ログアウトする
            Auth::logout();

            //セッションの無効化
            $request->session()->invalidate();

            //新しいCSRFトークンを再生成する
            $request->session()->regenerateToken();

            return redirect('/');
        } catch (Throwable $e) {
            //ユーザーには見えない詳細なエラー
            Log::error('ログアウト処理中にエラーが発生しました: ' . $e->getMessage() , [
                'user_id' => Auth::id() ?? 'guest',
                'ip_address' => $request->ip(),  //IPアドレスも記録するといいらしい
                'exception' => $e
            ]);


            $request->session()
            ->flash('error', 'ログアウト処理中にエラーが発生しました。もう一度試すか、ブラウザを閉じてください。');

            return back();
        }
    }
}

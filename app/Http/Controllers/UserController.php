<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;

class userController extends Controller
{
    public function index() {
        $previousUrl = url()->previous();

        $users = User::all();  

        return view('users.index', compact('previousUrl', 'users'));
    }

    //顧客詳細表示
    public function show(User $user)
    {
        $previousUrl = url()->previous();

        //顧客も取得する
        $user->load('customers'); // ここで顧客情報を事前ロードする N+1問題解決
        return view('users.show', compact('previousUrl', 'user'));
    }

    //新規顧客登録
    public function create()
    {
        $user = User::all();
        return view('users.create', compact('users'));
    }

    public function storeConfirm(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:50',
            'user_name_kana' => 'required|string|max:100',
            'authority' => 'required|string|max:10',
        ]);

        $request->session()->put('user_data', $validated);  //バリデーション通ったものをセッションに保存

        $selectedAuthority = null;
        if (!empty($validated['authority'])) {
            $selectedAuthority = User::find($validated['authority']);
        }

        return view('users.store_confirm', compact('validated', 'selectedAuthority'));
    }

    public function store(Request $request)
    {
        //セッションからとってくる
        $user_data = $request->session()->get('user_data');

        //セッションになかったらエラー表示
        if (!$user_data) {
            return redirect('user.create')->with('error', '登録情報が見つからず、登録できませんでした。再度入力してください');
        }

        //ルールを決める
        $rules = [
            'user_name' => 'required|string|max:50',
            'user_name_kana' => 'required|string|max:100',
            'authority' => 'required|string|max:10',
        ];

        //バリデーションチェック
        $validator = Validator::make($user_data, $rules);

        //バリデーション失敗したら
        if ($validator->fails()) {
            //入力フォームへリダイレクト
            return redirect()->route('users.create')
                ->withErrors($validator)->withInput($user_data);
        }

        //バリデーションを追加したデータのみを取得
        $validatedData = $validator->validated();

        //保存する
        try {
            //パスワードはハッシュ化して保存
            $validatedData['password'] = bcrypt($validatedData['password']);
            User::create($validatedData);

            //成功したらメッセージ
            $request->session()->forget('user_data');
            return redirect()->route('users.index')->with('success', "{$validatedData['user_name']} さんを登録しました。");
        } catch (Exception $e) {
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('users.create')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    public function edit(user $user)   //$userはidだけど自動でインスタンスにしてくれる
    {
        $users = User::all(); //全員取ってくる。selectタグ用

        $previousUrl = url()->previous(); //前のページのurlも渡して戻れるようにしている

        return view('users.edit', compact('user', 'users', 'previousUrl'));
    }

    public function updateConfirm(Request $request, user $user)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:50',
            'user_name_kana' => 'required|string|max:100',
            'authority' => 'required|string|max:10',
        ]);

        $request->session()->put('user_data', $validated);  //バリデーション通ったものをセッションに保存

        $selectedAuthority = null;
        if (!empty($validated['authority'])) {
            if ($validated['authority'] === "admin") {
                $selectedAuthority = "管理者";
            } else {
                $selectedAuthority = "営業担当者";
            }
        }

        return view('users.update_confirm', compact('validated', 'selectedAuthority', 'user'));
    }

    public function update(Request $request, User $user)
    {
        //セッションからとってくる
        $user_data = $request->session()->get('user_data');

        //セッションになかったらエラー表示
        if (!$user_data) {
            return redirect('user.edit')->with('error', '更新情報が見つからず、更新できませんでした。再度入力してください');
        }

        //ルールを決める
        $rules = [
            'user_name' => 'required|string|max:50',
            'user_name_kana' => 'required|string|max:100',
            'authority' => 'required|string|max:10',
        ];

        //バリデーションチェック
        $validator = Validator::make($user_data, $rules);

        //バリデーション失敗したら
        if ($validator->fails()) {
            //入力フォームへリダイレクト
            return redirect()->route('user.edit')
                ->withErrors($validator)->withInput($user_data);
        }

        //バリデーションを追加したデータのみを取得
        $validatedData = $validator->validated();

        //更新する
        try {
            $user->update($validatedData);

            //成功したらメッセージ
            $request->session()->forget('user_data');
            return redirect()->route('users.index')->with('success', "{$validatedData['user_name']} さんを登録しました。");
        } catch (Exception $e) {
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('user.edit')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    public function destroy(User $user)
    {
        try {
            $userName = $user->user_name;  //削除前に名前を保持
            $user->delete();

            return redirect()->route('users.index')->with('success', "{$userName}さんの顧客情報を削除しました。");
        } catch (Exception $e) {
            Log::error("顧客情報の削除中にエラーが発生しました: ID={$user->id}, エラー: {$e->getMessage()}");
            return redirect()->route('users.index')->with('error', '顧客情報の削除中にエラーが発生しました。もう一度お試しください。');
        }
    }
}

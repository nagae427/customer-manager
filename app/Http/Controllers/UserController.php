<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class userController extends Controller
{
    /**
     * 営業担当者一覧表示
     */
    public function index() {
        $users = User::orderBy('id', 'desc')->get(); 
        return view('users.index', compact('users'));
    }

    /**
     * 営業担当者詳細表示
     */
    public function show(User $user)
    {
        $user->load('customers');
        return view('users.show', compact('user'));
    }

    /**
     * 編集画面表示
     */
    public function edit(User $user)
    {
        $users = User::all();
        return view('users.edit', compact('user', 'users'));
    }

    /**
     * 編集
     */
    public function store(Request $request)
    {
        //バリデーションチェック
        $validated = [
            'id' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:50',
            'name_kana' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|',
            'is_admin' => 'required|in:admin,sales',
        ];

        //保存する
        try {
            if (empty($validated['id'])) {
                //新規登録
                $user = User::create($validated);
                $message = "{$validated['name']} さんの情報を登録しました。";
            } else {
                //更新
                $user = User::findOrFail($validated['id']);
                $user->update($validated);
                $message = "{$validated['name']} さんの情報を更新しました。";
            }
            return redirect()->route('users.index', $user)->with('success', $message);
        } catch (Exception $e) {
            Log::error("保存エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('users.create')->with('error', '情報の編集中にエラーが発生しました。もう一度お試しください');
        }
    }

    /**
     * 営業担当者削除
     */
    public function destroy(User $user)
    {
        try {
            $userName = $user->name;  
            $user->delete();

            return redirect()->route('users.index')->with('success', "{$userName}さんの情報を削除しました。");
        } catch (Exception $e) {
            Log::error("顧客情報の削除中にエラーが発生しました: ID={$user->id}, エラー: {$e->getMessage()}");
            return redirect()->route('users.index')->with('error', '情報の削除中にエラーが発生しました。もう一度お試しください。');
        }
    }
}

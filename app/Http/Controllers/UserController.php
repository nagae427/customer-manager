<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * 営業担当者一覧表示
     */
    public function index() {
        $users = User::orderBy('id', 'desc')->get(); 
        return view('users.index', compact('users'));
    }

    /**
     * 特定のユーザー情報をJSON形式で取得 (Ajaxリクエスト用)
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return view('users.show_modal', compact('user'));
    }

    /**
     * 編集画面表示
     */
    public function edit(User $user)
    {
        return view('users.edit_modal', compact('user'));
    }

    /**
     * 編集(Json形式で返す)
     */
    public function store(Request $request): JsonResponse
    {
        //バリデーションチェック
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:50',
            'name_kana' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255' , Rule::unique('users')->ignore($request->id)], //自分自身の更新はユニーク無視
            'phone' => 'required|string|max:20',
            'is_admin' => 'required|in:admin,sales',
        ]);

        //保存する
        try {
            if (empty($validated['id'])) {
                //新規登録
                $validated['password'] = 'password';
                $user = User::create($validated);
                $message = "{$validated['name']} さんの情報を登録しました。";
            } else {
                //更新
                $user = User::findOrFail($validated['id']);
                $user->update($validated);
                $message = "{$validated['name']} さんの情報を更新しました。";
            }

            $request->session()->flash('success', $message);

            //json形式でレスポンス
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error("保存エラーが発生しました: {$e->getMessage()}");

            //エラーもjsonでレスポンス
            $errorMessage = '情報の更新中にエラーが発生しました。';
            $request->session()->flash('error', $errorMessage);
            return response()->json([
                'error' => $errorMessage
            ], 500);
        }
    }

    public function confirm(User $user)
    {
        return view('users.delete_modal', compact('user'));
    }

    /**
     * 営業担当者削除
     */
    public function delete(Request $request, User $user)
    {
        try {
            $userName = $user->name;  
            $user->delete();

            $message = " {$userName} さんの情報を削除しました。";
            $request->session()->flash('success', $message);
            return response()->json(['status' => "success"]);
        } catch (Exception $e) {
            Log::error("顧客情報の削除中にエラーが発生しました: ID={$user->id}, エラー: {$e->getMessage()}");
            $errorMessage = '情報の削除中にエラーが発生しました。もう一度お試しください。';
            $request->session()->flash('error', $errorMessage); // エラーメッセージもフラッシュする
            return response()->json(['status' => 'error', 'message' => $errorMessage], 500); // <-- JSONで返す
        }
    }
}

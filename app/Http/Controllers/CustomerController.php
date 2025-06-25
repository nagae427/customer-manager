<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Area;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * 顧客一覧表示
     */
    public function index()
    {
        $customers = Customer::with('area', 'user')->orderBy('id', 'desc')->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * 顧客詳細表示
     */
    public function show(Customer $customer)
    {
        $customer->load(['area', 'user']);
        return view('customers.show', compact('customer'));
    }

    /**
     * 顧客登録、編集画面表示
     */
    public function edit(Customer $customer)
    {
        $areas = Area::all();
        $users = User::all();
        return view('customers.edit', compact('areas', 'users', 'customer'));
    }

    /**
     * 顧客登録、編集確認画面
     */
    public function confirm(Request $request)
    {
        //バリデーション確認
        $validated = $request->validate([
            'id' => '',
            'name' => 'required|string|max:50',
            'name_kana' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:8|regex:/^\d{3}-?\d{4}$/',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:30',
            'contact_person_name_kana' => 'required|string|max:50',
            'contact_person_tel' => 'required|string|max:20|regex:/^\\d{2,4}-?\\d{2,4}-?\\d{3,4}$/',
            'user_id' => 'required|exists:users,id',
        ]);

        //バリデーションが通ったら、セッションに保存
        $request->session()->put('customer_data', $validated); 

        //選択されたエリアとユーザーを取得
        $selectedArea = null;
        if (!empty($validated['area_id'])) {
            $selectedArea = Area::find($validated['area_id']);
        }

        $selectedUser = null;
        if (!empty($validated['user_id'])) {
            $selectedUser = User::find($validated['user_id']);
        }
        return view('customers.confirm', compact('validated', 'selectedArea', 'selectedUser'));
    }

    /**
     * 登録、編集
     */
    public function store(Request $request)
    {
        // 戻るボタンをクリックされた場合
        if($request->input('back') == 'back'){
            return redirect()->route('customers.edit', $request->input('id'))
                 ->withInput();
        }

        //hiddenで送られてきた値をバリデーションチェック
        $validated = $request->validate([
            'id' => '',
            'name' => 'required|string|max:50',
            'name_kana' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:8|regex:/^\d{3}-?\d{4}$/',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:30',
            'contact_person_name_kana' => 'required|string|max:50',
            'contact_person_tel' => 'required|string|max:20|regex:/^\\d{2,4}-?\\d{2,4}-?\\d{3,4}$/',
            'user_id' => 'required|exists:users,id',
        ]);

        //セッションからとってくる
        $customer_data = session()->get('customer_data');

        //セッション情報とバリデーション後の値を比較する
        if (!$customer_data || $customer_data !== $validated) {
            //セッションになかったら登録画面か編集画面に表示
            return redirect()->route('customers.edit', $validated['id'])->with('error', '登録情報が見つからず、登録できませんでした。再度入力してください');
        }

        //保存する
        try {
            $customer = Customer::findOrFail($validated['id']);
            $customer->update($validated);
            $message = "{$validated['name']} さんの情報を更新しました。";

            //成功したらセッションを削除してメッセージ
            $request->session()->forget('customer_data');
            return redirect()->route('customers.index', $customer)->with('success', $message);
        } catch (Exception $e) {
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('customers.form')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    /**
     * 顧客情報削除
     */
    public function destroy(Customer $customer)
    {
        try {
            // 削除する顧客名を保持する。withメッセージで使用するため
            $customerName = $customer->name;
            // 顧客情報を削除
            $customer->delete();

            return redirect()->route('customers.index')->with('success', "{$customerName}さんの顧客情報を削除しました。");
        } catch (Exception $e) {
            Log::error("顧客情報の削除中にエラーが発生しました: ID={$customer->id}, エラー: {$e->getMessage()}");
            return redirect()->route('customers.index')->with('error', '顧客情報の削除中にエラーが発生しました。もう一度お試しください。');
        }
    }
}

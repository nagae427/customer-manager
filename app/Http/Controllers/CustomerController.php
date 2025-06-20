<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    //顧客一覧表示
    public function index()
    {
        //戻る用のurlを取得
        $previousUrl = url()->previous();
        //areaとuserを一緒に取得して、顧客一覧を取得
        $customers = Customer::with('area', 'user')->get();
        //顧客を逆順にして、最新の顧客が一番上に来るようにする
        $reversed_customers = collect($customers)->reverse();
        //ビューにデータを渡す
        return view('customers.index', compact('previousUrl', 'reversed_customers'));
    }

    //顧客詳細表示
    // ルートバインディング。laravelが自動で$customerをコントローラではCustomerオブジェクトだと認識
    public function show(Customer $customer)
    {
        $previousUrl = url()->previous(); 
        //$customerからareaとuserをロードする
        $customer->load(['area', 'user']);
        //詳細ページに必要なデータをビューに渡す
        return view('customers.show', compact('customer', 'previousUrl'));
    }

    //新規顧客登録画面へ
    public function create()
    {
        $areas = Area::all();
        $users = User::all();
        return view('customers.create', compact('areas', 'users'));
    }

    public function storeConfirm(Request $request)
    {
        //バリデーション確認
        $validated = $request->validate([
            'customer_name' => 'required|string|max:50',
            'customer_name_kana' => 'required|string|max:100',
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

        //確認画面を表示
        return view('customers.store_confirm', compact('validated', 'selectedArea', 'selectedUser'));
    }

    //新規登録処理
    public function store(Request $request)
    {
        //セッションからとってくる
        $customer_data = $request->session()->get('customer_data');

        //セッションになかったらエラー表示
        if (!$customer_data) {
            return redirect('customer.create')->with('error', '登録情報が見つからず、登録できませんでした。再度入力してください');
        }

        //ルールを決める
        $rules = [
            'customer_name' => 'required|string|max:50',
            'customer_name_kana' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:8|regex:/^\\d{3}-?\\d{4}$/',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:30',
            'contact_person_name_kana' => 'required|string|max:50',
            'contact_person_tel' => 'required|string|max:20|regex:/^\\d{2,4}-?\\d{2,4}-?\\d{3,4}$/',
            'user_id' => 'required|exists:users,id',
        ];

        //バリデーションチェック
        $validator = Validator::make($customer_data, $rules);

        //バリデーション失敗したら
        if ($validator->fails()) {
            //入力フォームへリダイレクト
            return redirect()->route('customers.create')
                ->withErrors($validator)->withInput($customer_data);
        }

        //バリデーションを追加したデータのみを取得
        $validatedData = $validator->validated();

        //保存する
        try {
            $customer = Customer::create($validatedData);

            //成功したらメッセージ
            $request->session()->forget('customer_data');
            return redirect()->route('customers.index')->with('success', "{$validatedData['customer_name']} さんを登録しました。");
        } catch (Exception $e) {
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('customers.create')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    //顧客情報の編集
    // ルートバインディング。
    public function edit(Customer $customer)
    {
        $areas = Area::all(); 
        $users = User::all(); 

        $previousUrl = url()->previous(); 

        return view('customers.edit', compact('customer', 'users', 'areas', 'previousUrl'));
    }

    public function updateConfirm(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:50',
            'customer_name_kana' => 'required|string|max:100',
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

        return view('customers.update_confirm', compact('validated', 'selectedArea', 'selectedUser', 'customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        //セッションからとってくる
        $customer_data = $request->session()->get('customer_data');

        //セッションになかったらエラー表示
        if (!$customer_data) {
            return redirect('customer.edit')->with('error', '更新情報が見つからず、更新できませんでした。再度入力してください');
        }

        //ルールを決める
        $rules = [
            'customer_name' => 'required|string|max:50',
            'customer_name_kana' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:8|regex:/^\\d{3}-?\\d{4}$/',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:30',
            'contact_person_name_kana' => 'required|string|max:50',
            'contact_person_tel' => 'required|string|max:20|regex:/^\\d{2,4}-?\\d{2,4}-?\\d{3,4}$/',
            'user_id' => 'required|exists:users,id',
        ];

        //バリデーションチェック
        $validator = Validator::make($customer_data, $rules);

        //バリデーション失敗したら
        if ($validator->fails()) {
            //入力フォームへリダイレクト
            return redirect()->route('customer.edit')
                ->withErrors($validator)->withInput($customer_data);
        }

        //バリデーションを追加したデータのみを取得
        $validatedData = $validator->validated();

        //更新する
        try {
            $customer->update($validatedData);

            //成功したらメッセージ
            $request->session()->forget('customer_data');
            return redirect()->route('customers.index')->with('success', "{$validatedData['customer_name']} さんを登録しました。");
        } catch (Exception $e) {
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('customer.edit')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            // 削除する顧客名を保持する。withメッセージで使用するため
            $customerName = $customer->customer_name;  
            // 顧客情報を削除
            $customer->delete();

            return redirect()->route('customers.index')->with('success', "{$customerName}さんの顧客情報を削除しました。");
        } catch (Exception $e) {
            Log::error("顧客情報の削除中にエラーが発生しました: ID={$customer->id}, エラー: {$e->getMessage()}");
            return redirect()->route('customers.index')->with('error', '顧客情報の削除中にエラーが発生しました。もう一度お試しください。');
        }
    }
}

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
        $customers = Customer::with('area', 'user')->get();
        $reversed_customers = collect($customers)->reverse();
        return view('customers.index', compact('reversed_customers'));
    }

    //顧客詳細表示
    public function show($id)
    {
        $customer = Customer::with(['area', 'user'])->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    //新規顧客登録
    public function create()
    {
        $areas = Area::all();
        $users = User::all();
        return view('customers.create', compact('areas', 'users'));
    }

    public function storeConfirm(Request $request)
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

        $request->session()->put('customer_data', $validated);  //バリデーション通ったものをセッションに保存

        $selectedArea = null;
        if (!empty($validated['area_id'])) {
            $selectedArea = Area::find($validated['area_id']);
        }

        $selectedUser = null;
        if (!empty($validated['user_id'])) {
            $selectedUser = User::find($validated['user_id']);
        }

        return view('customers.store_confirm', compact('validated', 'selectedArea', 'selectedUser'));
    }

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
            return redirect()->route('customer.create')
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
        } catch (Exception $e){
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('customer.create')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    // public function edit($id) 
    // {
    //     //方法1 前の書き方
    //     $customer = Customer::with('area', 'user')->find($id);

    //     if (!$customer) {
    //         abort(404); //明示的に書いている
    //     }

    //     return view('customers.edit', compact('customer'));
    // }

    public function edit(Customer $customer)   //$customerはidだけど自動でインスタンスにしてくれる
    {
        //方法2 ルートバインディング。laravelが自動でidだと認識し、findしてくれて、$customerを注入してくれる
        // $customer->load('area', 'user'); //とりあえず今はいらない

        $areas = Area::all(); //全員取ってくる。selectタグ用
        $users = User::all(); //全員取ってくる。selectタグ用
        
        $previousUrl = url()->previous(); //前のページのurlも渡して戻れるようにしている

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

        $request->session()->put('customer_data', $validated);  //バリデーション通ったものをセッションに保存

        $selectedArea = null;
        if (!empty($validated['area_id'])) {
            $selectedArea = Area::find($validated['area_id']);
        }

        $selectedUser = null;
        if (!empty($validated['user_id'])) {
            $selectedUser = User::find($validated['user_id']);
        }

        return view('customers.update_confirm', compact('validated', 'selectedArea', 'selectedUser','customer'));
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
        } catch (Exception $e){
            Log::error("エラーが発生しました: {$e->getMessage()}");
            return redirect()->route('customer.edit')->with('error', '顧客情報の登録中にエラーが発生しました。もう一度お試しください');
        }
    }

    public function destroy(Customer $customer) {
        try {
            $customerName = $customer->customer_name;  //削除前に名前を保持
            $customer->delete();

            return redirect()->route('customers.index')->with('success',"{$customerName}さんの顧客情報を削除しました。");
        } catch(Exception $e) {
            Log::error("顧客情報の削除中にエラーが発生しました: ID={$customer->id}, エラー: {$e->getMessage()}");
            return redirect()->route('customers.index')->with('error', '顧客情報の削除中にエラーが発生しました。もう一度お試しください。');
        }
    }
}

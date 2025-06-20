<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        //前のページのurlも渡して戻れるようにしている
        $previousUrl = url()->previous(); 

        //顧客の件数を取得
        $count_customers = Customer::count();

        //営業担当者の数だけ取得
        $count_sales = User::where('authority', 'sales')->count();

        //3日前の日付を取得
        $three_days_ago = Carbon::today()->subDays(3);

        //ここ3日間の顧客情報だけを取得
        $recentCustomers = Customer::whereDate('updated_at', '>=', $three_days_ago)->with('area', 'user')->get();

        return view('dashboard', compact('previousUrl', 'count_customers', 'count_sales', 'three_days_ago', 'recentCustomers'));
    }
}

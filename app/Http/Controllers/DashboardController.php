<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Contact_query;
use App\Order;
use App\Payment;
use App\Report_ad;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        $user_id = $user->id;

        $total_users = 0;
        $total_reports = 0;
        $total_payments = 0;
        $ten_contact_messages = 0;
        $reports = 0;
        $total_payments_amount = 0;

        if ($user->is_admin()){
            $approved_ads = Ad::where('status', '1')->count();
            $pending_ads = Ad::where('status', '0')->count();
            $blocked_ads = Ad::where('status', '3')->count();

            $total_users = User::count();
            $total_reports = Report_ad::count();
            $total_orders = Order::where('status','success')->count();
            $total_orders_amount = Order::where('status','success')->sum('total_amount');
            $ten_contact_messages = Contact_query::take(10)->orderBy('id', 'desc')->get();
            $reports = Report_ad::orderBy('id', 'desc')->with('ad')->take(10)->get();
        }else{
            $approved_ads = Ad::where('status',1)->where('user_id',$user_id)->count();
            $pending_ads = Ad::where('status',0)->where('user_id',$user_id)->count();
            $blocked_ads = Ad::where('status',2)->where('user_id',$user_id)->count();
        }

        return view('admin.dashboard', compact('approved_ads', 'pending_ads', 'blocked_ads', 'total_users', 'total_reports', 'total_orders', 'total_orders_amount', 'ten_contact_messages', 'reports'));
    }


    public function logout(){
        if (Auth::check()){
            Auth::logout();
        }

        return redirect(route('login'));
    }
}

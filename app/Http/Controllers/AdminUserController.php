<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public static function index(){
        return view('admin.user.user',[
            'users' => User::where('role_name', null)->get(),
        ]);
    }

    public static function affiusers(){
        return view('admin.user.affiusers',[
            'users' => User::where('role_name', 'affiliate')->get(),
        ]);
    }

    public static function commission(){
        return view('admin.user.commission',[
            'users' => User::where('role_name', 'affiliate')->get(),
            'orders' => Order::where('status', 2)->get(),
            'coupons' => Coupon::where('affiliate_user_id', '!=', null)->get(),
        ]);
    }

    public static function affpayment(){
        return view('admin.user.affpayment',[
            'requests' => PaymentRequest::orderBy('created_at', 'desc')->get(),
            'orders' => Order::where('status', 2)->get(),
        ]);
    }

    public static function payRequest(Request $request, $id){
        $pay = PaymentRequest::find($id);
        $user = User::find($pay->user_id);
        if($user){
            if($request->paid > $user->commission ){
                return back()->with('error', 'You are trying to pay more then pending ammount');
            }
        }

        $pay->paid = $request->paid;
        $pay->status = 2;
        $pay->save();

        $user->commission = $user->commission-$request->paid;
        $user->save();

        return back()->with('success', 'Successfully Paid '. $pay->user->name .' ' .$request->paid );
    }

    public static function userStatusChange($id){
        $user = User::find($id);

        if($user->status == 0 ){
            $user->status = 1;
        }else{
            $user->status = 0 ;
        }

        $user->save();
        return back()->with('success', 'User Status has been changed');
    }
}

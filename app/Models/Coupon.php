<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public static function saveInfo($request, $id = null){

        if($id == null){
           $blog = new Coupon();
           $action = 'created';
        }else{
            $blog = Coupon::find($id);
            $action = 'updated';
        }

        $blog->coupon = $request->coupon;
        $blog->coupon_type = $request->type;
        $blog->amount = $request->amount;
        $blog->affiliate_user_id = $request->affiliate_user_id;
        $blog->affiliate_commission = $request->affiliate_commission;
        $blog->start_date = $request->start_date;
        $blog->expire_date = $request->expire_date;
        $blog->max_user = $request->max_user;
        $blog->uses_per_user = $request->uses_per_user;
        $blog->status = $request->status;

        $blog->save();

        $successMessage = " $request->type Coupon has been " . $action . " successfully";
        $request->session()->flash('success', $successMessage);
    }
}

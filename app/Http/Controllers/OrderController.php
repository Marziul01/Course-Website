<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use App\Models\Order;
use App\Models\CourseEnroll;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public static function orders(){
        return view('admin.order.order',[
            'orders' => Order::where('status',1)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public static function completedorders(){
        return view('admin.order.comorder',[
            'orders' => Order::where('status',2)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public static function canceledorders(){
        return view('admin.order.canorder',[
            'orders' => Order::where('status',3)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public static function cancel($id){
        $order = Order::find($id);
        
        if($order->commission > 0 ){
            $coupon = Coupon::find($order->coupon_id);

            if($coupon && $coupon->affiliate_commission > 0){
                $affuser = User::find($coupon->affiliate_user_id);
                $affuser->commission = $affuser->commission-$order->commission;
                $affuser->save();
            }
        }
        
        foreach($order->items as $item){
            if(isset($item->course)){
                if($item->course->combo == 1){
                    foreach($item->course->comboCourses as $comboCourse){
                        if(!is_null($comboCourse->course->enroll->where('user_id', $order->user_id)) ){
                            $courseEnroll = CourseEnroll::where('user_id', $order->user_id)->where('course_id', $comboCourse->course->id)->first();
                            $courseEnroll->delete();
                        }
                    }
                }
                if($item->course->combo == 0){
                    if(!is_null($item->course->enroll->where('user_id', $order->user_id)) ){
                            $courseEnroll = CourseEnroll::where('user_id', $order->user_id)->where('course_id', $item->course->id)->first();
                            $courseEnroll->delete();
                        }
                }
            }
        }
        
        $order->status = 3 ;
        $order->save();
        return back()->with('success', 'Order has been marked as canceled');
    }

    public static function complete($id){
        $order = Order::find($id);
        

        if($order->commission > 0 ){
            $coupon = Coupon::find($order->coupon_id);

            if($coupon && $coupon->affiliate_commission > 0){
                $affuser = User::find($coupon->affiliate_user_id);
                $affuser->commission = $affuser->commission+$order->commission;
                $affuser->save();
            }
        }

        foreach($order->items as $item){
            if(isset($item->course)){
                if($item->course->combo == 1){
                    foreach($item->course->comboCourses as $comboCourse){
                        $courseEnroll = new CourseEnroll();
                        $courseEnroll->user_id = $order->user_id;
                        $courseEnroll->course_id = $comboCourse->course->id;
                        $courseEnroll->save();
                    }
                }else{
                    $courseEnroll = new CourseEnroll();
                    $courseEnroll->user_id = $order->user_id;
                    $courseEnroll->course_id = $item->course_id;
                    $courseEnroll->save();
                }
            }else{
                return back()->with('error', 'Ordered Course has been deleted, so can not complete this order.');
            }
            

        }
        
        $order->status = 2 ;
        $order->save();

        return back()->with('success', 'Order has been marked as completed');
    }

    public static function delete($id){
        $order = Order::find($id);
        $order->delete();
        return back()->with('success', 'Order has been deleted');
    }
}

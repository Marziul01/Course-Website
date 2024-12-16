<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ComboOffers;
use App\Models\CourseEnroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $userId = Auth::id();
        $courseId = $request->course_id;

        $alreadyEnrolled = CourseEnroll::where('user_id', $userId)->where('course_id', $courseId)->first();
        if ($alreadyEnrolled) {
            // Course already in the cart
            return response()->json(['success' => false, 'message' => 'You have purchased this course !']);
        }

        // Check if the course is already in the cart
        $cartItem = Cart::where('user_id', $userId)->where('course_id', $courseId)->first();

        if ($cartItem) {
            // Course already in the cart
            return response()->json(['success' => false, 'message' => 'Already added to cart!']);
        } else {
            // Add to cart
            Cart::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'quantity' => 1, // Default quantity
            ]);

            // Return success response
            return response()->json(['success' => true, 'message' => 'Course added to cart!']);
        }
    }

    public function cartCount()
    {
        $userId = Auth::id();
        return Cart::where('user_id', $userId)->count();
    }

    public function removeFromCart(Request $request)
{
    $cartItem = Cart::find($request->id);
    $cartItem->delete();

    return response()->json(['success' => true, 'message' => 'Item removed from cart']);
}

public static function cartPage(){
    $cartItems = Cart::where('user_id', Auth::user()->id)->get();

    $total = $cartItems->sum(function($cartItem) {
        return ($cartItem->course->sale_price ?? $cartItem->course->price) * $cartItem->quantity;
    });

    return view('frontend.order.cart', [
        'cartItems' => $cartItems,
        'total' => $total,
    ]);
}

}

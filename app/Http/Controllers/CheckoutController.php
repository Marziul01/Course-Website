<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Mpdf\Output\Destination;
use App\Models\PaymentMethod;
use App\Mail\OrderInvoiceMail;
use App\Mail\AdminOrderNotification;
use App\Models\ComboOffers;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as FacadesLaravelMpdf;
use Meneses\LaravelMpdf\LaravelMpdf;
use Mpdf\Mpdf;

class CheckoutController extends Controller
{

    public static function checkout(){

        $cartItems = Cart::where('user_id', Auth::user()->id)->get();

        $total = $cartItems->sum(function($cartItem) {
            return ($cartItem->course->sale_price ?? $cartItem->course->price);
        });

        return view('frontend.order.checkout',[
            'cartItems' => $cartItems,
            'total' => $total,
            'coupons' => Coupon::where('status',1)->get(),
            'payment_methods' => PaymentMethod::where('status',1)->get(),
        ]);
    }




    public function applyCoupon(Request $request)
{
    // Retrieve coupon code from the request
    $couponCode = $request->coupon_code;

    // Fetch the coupon from the database
    $coupon = Coupon::where('coupon', $couponCode)->first();

    // Check if the coupon exists
    if (!$coupon) {
        return response()->json(['success' => false, 'message' => 'Invalid coupon']);
    }

    if ($coupon->start_date && $coupon->start_date > now()) {
        return response()->json(['success' => false, 'message' => 'This coupon offer did not start yet ']);
    }

    // Check if the coupon has expired
    if ($coupon->expire_date && $coupon->expire_date < now()) {
        return response()->json(['success' => false, 'message' => 'This coupon has expired']);
    }

    // // Check if the coupon usage limit has been reached
    $totalUses = Order::where('coupon_id', $coupon->id)->count() ?? 0;
    if ($coupon->max_user && $totalUses >= $coupon->max_user) {
        return response()->json(['success' => false, 'message' => 'This coupon has reached its maximum usage limit']);
    }

    // // Check if the user has already used this coupon and verify if they can use it again
    $userUses = Order::where('coupon_id', $coupon->id)->where('user_id', Auth::id())->count() ?? 0;
    if ($coupon->uses_per_user && $userUses >= $coupon->uses_per_user) {
        return response()->json(['success' => false, 'message' => 'You have already used this coupon the maximum allowed times']);
    }

    $total = Cart::with('course')
    ->where('user_id', Auth::id())
    ->get()
    ->sum(function ($cart) {
        return $cart->course->sale_price ?? $cart->course->price;
    });

    // Calculate the discount based on the coupon type (fixed or percentage)
    if ($coupon->coupon_type == 'fixed') {
        $discount = $coupon->amount;
    } elseif ($coupon->coupon_type == 'percentage') {
        $discount = ($total * $coupon->amount) / 100;
    } else {
        $discount = 0; // Default to zero discount if coupon type is unknown
    }

    // Ensure that the discount does not exceed the total
    $discount = min($discount, $total);

    // Calculate the new total after applying the discount
    $newTotal = $total - $discount;

    // Store the coupon info in the session
    session([
        'coupon_discount' => $discount,
        'coupon_id' => $coupon->id
    ]);

    // Return a successful JSON response with the new total
    return response()->json([
        'success' => true,
        'message' => 'Coupon applied successfully',
        'new_total' => $newTotal,
        'discount' => $discount,
    ]);
}


public function processCheckout(Request $request)
{
    // Validate request
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'payment_number' => 'required',
        'transaction_id' => 'required',
        'payment_method_id' => 'required|exists:payment_methods,id', // Ensure payment method exists
    ]);

    // Retrieve the cart items for the authenticated user
    $cartItems = Cart::where('user_id', Auth::id())->get();

    // Check if there are items in the cart
    if ($cartItems->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
    }

    // Calculate total price
    $total = 0;
    foreach ($cartItems as $cartItem) {
        $price = $cartItem->course->sale_price ?? $cartItem->course->price;
        $total += $price * $cartItem->quantity; // Assuming there's a quantity field in your Cart model
    }

    $commission = 0;

    if (session()->has('coupon_id')) {
        // Retrieve the coupon from the database
        $coupon = Coupon::find(session('coupon_id'));

        // Check if the coupon exists and has a valid affiliate commission
        if ($coupon && $coupon->affiliate_commission > 0) {
            // Calculate the commission
            $commission = ($total - session('coupon_discount', 0)) * $coupon->affiliate_commission / 100;
        }
    }

    // Create the order
    $order = new Order();
    $order->user_id = Auth::id();
    $order->name = $request->name;
    $order->email = $request->email;
    $order->phone = $request->phone;
    $order->total = $total; // This is the total amount before discount
    $order->discount = session('coupon_discount', 0); // Get discount amount from session
    $order->grand_total = $total - session('coupon_discount', 0); // Calculate grand total
    $order->coupon_id = session('coupon_id'); // Get coupon ID from session if available
    $order->commission = $commission;
    $order->payment_method_id = $request->payment_method_id;
    $order->payment_number = $request->payment_number;
    $order->transaction_id = $request->transaction_id;
    $order->payment_status = 1; // Assuming 1 means successful payment
    $order->status = 1; // Assuming 1 means active or pending
    $order->course_id = null; // Set this to null or remove it completely if not needed
    $order->save();

    // Save each course in the OrderItems table
    foreach ($cartItems as $cartItem) {
        $orderitem = new OrderItems();
        $orderitem->order_id = $order->id;
        $orderitem->course_id = $cartItem->course_id;
        $orderitem->save();
    }

    $pdf = $this->generateInvoice($order);

    // Send PDF Invoice and Email to User and Admin
    $this->sendInvoiceToUser($order, $pdf);
    $this->sendAdminNotification($order, $pdf);
    // Clear the cart
    Cart::where('user_id', Auth::id())->delete();

    // Clear the coupon from the session
    $request->session()->forget('coupon_discount');
    $request->session()->forget('coupon_id'); // Also forget the coupon ID if applicable

    return response()->json(['success' => true, 'message' => 'Order placed successfully']);
}


// Function to generate the invoice PDF using mPDF
private function generateInvoice($order)
{
    // Create a new instance of mPDF
    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => [
            storage_path('fonts'), // Ensure this path is correct and points to your fonts directory
            // Add any other font directories if needed
            'path/to/another/font/directory', // Optional: replace with actual path if necessary
        ],
        'fontdata' => [
            'notosansbengali' => [
                'R' => 'SolaimanLipi.ttf',

            ],
        ],
        'default_font' => 'SolaimanLipi', // Use the Bangla font as the default
    ]);

    // Load the view for the invoice and render the HTML content
    $html = view('invoice.invoice', compact('order'))->render();

    // Write the HTML content to mPDF
    $mpdf->WriteHTML($html);

    // Define the file path for the PDF
    $filePath = storage_path('app/invoices/order_' . $order->id . '.pdf');

    // Output the PDF to the defined file path
    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

    return $filePath; // Return the path of the saved PDF
}





// Function to send invoice to user
private function sendInvoiceToUser($order, $pdf)
{
    Mail::send('emails.order_invoice', ['order' => $order], function ($message) use ($order, $pdf) {
        $message->to($order->email);
        $message->subject('Your Order Invoice');
        $message->attach($pdf, [
            'as' => 'invoice.pdf',
            'mime' => 'application/pdf',
        ]);
    });
}

// Function to send notification to admin
private function sendAdminNotification($order, $pdf)
{
    $siteEmail = SiteSetting::find(1);

    Mail::send('emails.admin_order_notification', ['order' => $order], function ($message) use ($pdf, $siteEmail) {
        $message->to($siteEmail->email); // Corrected scope for $siteEmail
        $message->subject('New Order Created');
        $message->attach($pdf, [
            'as' => 'order_invoice.pdf',
            'mime' => 'application/pdf',
        ]);
    });
}


}

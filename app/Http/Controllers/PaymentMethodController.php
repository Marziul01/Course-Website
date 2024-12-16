<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payment.payment',[
            'payments' => PaymentMethod::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:payment_methods,name',
            'number' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                PaymentMethod::saveInfo($request);
                return back();

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|unique:payment_methods,name,' . $id,
            'number' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                PaymentMethod::saveInfo($request,$id);
                return back();

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = PaymentMethod::find($id);
        $coupon->delete();
        return back()->with('success', 'Payment Method deleted successfully');
    }
}

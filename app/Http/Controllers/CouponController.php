<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.coupon.coupon',[
            'coupons' => Coupon::all(),
            'users' => User::where('role_name','affiliate')->get(),
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
            'coupon' => 'required|unique:coupons,coupon',  // 'name' should be unique in the 'coupons' table
            'type' => 'required',
            'amount' => 'required|numeric',  // Add 'numeric' rule for 'amount'
            'expire_date' => 'required|date',  // Ensure 'expire_date' is a valid date
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                Coupon::saveInfo($request);
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
            'coupon' => 'required|unique:coupons,coupon,' . $id,
            'type' => 'required',
            'amount' => 'required|numeric',
            'expire_date' => 'required|date',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                Coupon::saveInfo($request,$id);
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
        $coupon = Coupon::find($id);
        $coupon->delete();
        return back()->with('success', 'Coupon deleted successfully');
    }
}

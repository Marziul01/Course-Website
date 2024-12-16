<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    public static function saveInfo($request, $id = null){

        if($id == null){
           $blog = new PaymentMethod();
           $action = 'created';
        }else{
            $blog = PaymentMethod::find($id);
            $action = 'updated';
        }

        $blog->name = $request->name;
        $blog->number = $request->number;
        $blog->status = $request->status;

        $blog->save();

        $successMessage = " $request->type Payment Method has been " . $action . " successfully";
        $request->session()->flash('success', $successMessage);
    }
}

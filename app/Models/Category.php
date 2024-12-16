<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function saveInfo($request, $id = null){
        if($id == null){
           $Category = new Category();
           $action = 'created';
        }else{
            $Category = Category::find($id);
            $action = 'updated';
        }

        $Category->name = $request->name;
        $Category->status = $request->status;

        if ($request->file('image')){
            if ($Category->image){
                if (file_exists($Category->image)){
                    unlink($Category->image);
                }
            }
            $Category->image = self::saveImage($request);
        }

        $Category->save();

        $successMessage = " $request->type Cateogry has been " . $action . " successfully";
        $request->session()->flash('success', $successMessage);
    }

    public static function saveImage($request){
        $image = $request->file('image');
        $imageNewName = $request->name.rand().'.'.$image->extension();
        $dir = "admin-assets/img/cateogry/";
        $imageUrl = $dir.$imageNewName;
        $image->move($dir,$imageUrl);
        return $imageUrl;
    }
}

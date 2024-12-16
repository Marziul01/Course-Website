<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public static function saveInfo($request, $id = null){
        if($id == null){
           $blog = new Blog();
           $action = 'created';
        }else{
            $blog = Blog::find($id);
            $action = 'updated';
        }

        $blog->title = $request->title;
        $blog->desc = $request->desc;
        $blog->status = $request->status;

        if ($request->hasFile('image')) {
            if ($blog->image){
                if (file_exists($blog->image)){
                    unlink($blog->image);
                }
            }
            $blog->image = self::saveImage($request);
        }

        $blog->save();

        $successMessage = " $request->type Blog has been " . $action . " successfully";
        $request->session()->flash('success', $successMessage);
    }

    public static function saveImage($request){
        $image = $request->file('image');
        $imageNewName = $request->title.rand().'.'.$image->extension();
        $dir = "admin-assets/img/Blog/";
        $imageUrl = $dir.$imageNewName;
        $image->move($dir,$imageUrl);
        return $imageUrl;
    }
}

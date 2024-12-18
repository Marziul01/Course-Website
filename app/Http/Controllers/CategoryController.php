<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.course.category',[
            'categories' => Category::all(),
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
            'name' => 'required',
            'image' => 'nullable',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                Category::saveInfo($request);
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
            'name' => 'required',
            'image' => 'nullable',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                Category::saveInfo($request, $id);
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
        $Category = Category::find($id);

        if ($Category) {
            if (!empty($Category->image)) {

                $imagePath = public_path($Category->image);

                if (file_exists($imagePath)) {

                    unlink($imagePath);
                }
                $Category->delete();
            }else{
                $Category->delete();
            }

        }
        return back();
    }
}

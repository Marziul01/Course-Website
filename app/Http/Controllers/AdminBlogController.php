<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.blog.blog',[
            'blogs' => Blog::all(),
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
            'title' => 'required',
            'image' => 'required',
            'desc' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                Blog::saveInfo($request);
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
            'title' => 'required',
            'image' => 'nullable',
            'desc' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){

                Blog::saveInfo($request,$id);
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
        $Blog = Blog::find($id);

        if ($Blog) {
            if (!empty($Blog->image)) {

                $imagePath = public_path($Blog->image);

                if (file_exists($imagePath)) {

                    unlink($imagePath);
                }
                $Blog->delete();
            }else{
                $Blog->delete();
            }

        }
        return back();
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {

        $blogs=Blog::paginate(5);
        return view('blogs.index', compact('blogs'));
    }


    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        //method 1
        //$blog=new Blog();
        //$blog->title= $request->title;
        //$blog->content= $request->content;
        //$blog->save();

        //method 2
        //Blog::create($request->only('title', 'content'));

        //method 3
        $blog=auth()->user()->blogs()->create($request->only('title','content'));
        if ($request->hasFile('attachment')){
            $filename=$blog->id.'-'.date("Y-m-d").'-'.$request->attachment->getClientOriginalExtension();
            Storage::disk('public')->put($filename, File::get($request->attachment));
            $blog->attachment=$filename;
            $blog->save();
        }
        return redirect()-> route('blogs.index')->with ('success','Blog created successfuly');
    }
    public function show(Blog $blog)
    {
        return view('blogs.show',compact ('blog'));
    }
    public function edit (Blog $blog)
    {
        return view('blogs.edit',compact ('blog'));
    }
    public function update(Request $request, Blog $blog)
    {
        $blog->update($request->only('title','content'));
        return redirect()-> route('blogs.index')->with ('success','Blog updated successfuly');
    }
    public function delete(Blog $blog)
    {
        if($blog->attachment !=null){
            Storage::disk('public')->delete($blog->attachment);
        }
        $blog->delete();
        return redirect()-> route('blogs.index')->with ('success','Blog deleted successfuly');
    }

}
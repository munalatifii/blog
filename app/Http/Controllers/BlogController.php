<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs=Blog::all();
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
        auth()->user()->blogs()->create($request->only('title','content'));
        return redirect()-> route('blogs.index');
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
        return redirect()-> route('blogs.index');
    }
    public function delete(Blog $blog)
    {
        $blog->delete();
        return redirect()-> route('blogs.index');
    }

}
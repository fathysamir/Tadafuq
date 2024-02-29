<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Image;
use Str;
use File;

class PostController extends Controller
{
    public function index(Request $request)
    {  

        if ($request->has('search')) {

            $all_posts = Post::where('title', 'LIKE', '%' . $request->search . '%')->paginate(10);
        } else {

            $all_posts= Post::where('deleted_at',null)->orderBy('id','desc')->paginate(10);
        } 
        return view('website.home.index',compact('all_posts'));

    }

    public function create(){
        return view('website.home.post.create');
    }

    public function store(Request $request){

           $validator = Validator::make($request->all(), [
            'title' => 'required',
            'phone' => 'required|numeric',
            'description' => 'required|max:2048',
            

            ],[ 
                   'description.max' => 'The description must be less than or equale 2KB.'
                ]);

           
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
           
            Post::create(['user_id'=>auth()->user()->id,'title'=>$request->title,'description'=>$request->description,'phone'=>$request->phone]);

          return redirect('/');

    }

    public function edit($id){
        $post=Post::where('id',$id)->first();
        return view('website.home.post.edit',compact('post'));
    }

    public function update(Request $request,$id){
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'phone' => 'required|numeric',
            'description' => 'required|max:2048',
            

            ],[ 
                   'description.max' => 'The description must be less than or equale 2KB.'
                ]);

           
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
           
            Post::where('id',$id)->update(['title'=>$request->title,'description'=>$request->description,'phone'=>$request->phone]);
             return redirect('/');

    }


    public function show($id){
        $post=Post::where('id',$id)->first();
        return view('website.home.post.show',compact('post'));
    }

     public function delete($id)
    {
        Post::where('id', $id)->delete();
        return redirect('/');
    }
}
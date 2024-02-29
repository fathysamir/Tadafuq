<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Image;
use Illuminate\Validation\Rule;
use Str;
use File;

class PostController extends ApiController
{  

///////////////////////////////////////////////  Home  ///////////////////////////////////////////
    public function index(Request $request){    
        $query = Post::orderBy('id', 'desc');
        $perPage = intval($request->limit);
        $page = intval($request->page) ?? 1;
        $all_posts = $query->paginate($perPage, ['*'], 'page', $page);

        foreach ($all_posts->items() as $post) {
            $post->title = strlen($post->title) > 512 ? substr($post->title, 0, 512) . '...' : $post->title;
            $post->description = strlen($post->description) > 512 ? substr($post->description, 0, 512) . '...' : $post->description;
        }

        $response['data']['all_posts'] = $all_posts->items();
        $response['data']['current_page'] = $all_posts->currentPage();
        $response['data']['last_page'] = $all_posts->lastPage();
        $response['data']['total'] = $all_posts->total();

        return $this->sendResponse($response);

    }
///////////////////////////////////////////////  Stor Post  ///////////////////////////////////////////
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'phone' => 'required|numeric',
                'description' => 'required|max:2048',
            

                ],[ 
                    'description.max' => 'The description must be less than or equale 2KB.'
                    ]);

            $path = null;
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            
            $post=Post::create(['user_id'=>Auth::user('api')->id,'title'=>$request->title,'description'=>$request->description,'phone'=>$request->phone]);
            return $this->sendResponse($post,'your post created successfully');
            
    }
///////////////////////////////////////////////  Update Post  ///////////////////////////////////////////
    public function update(Request $request){
            $validator = Validator::make($request->all(), [
                'post_id'=>[
                    'required',
                    Rule::exists('posts', 'id')->where(function ($query) {
                        $query->whereNull('deleted_at');
                    }),
                ],
                'title' => 'required',
                'phone' => 'required|numeric',
                'description' => 'required|max:2048',
            

                ],[ 
                    'description.max' => 'The description must be less than or equale 2KB.'
                    ]);

            
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
           
            Post::where('id',$request->post_id)->update(['title'=>$request->title,'description'=>$request->description,'phone'=>$request->phone]);
            $post=Post::where('id',$request->post_id)->first();
            return $this->sendResponse($post,'your post updated successfully');

    }
///////////////////////////////////////////////  Show Post  ///////////////////////////////////////////
    public function show(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id'=>[
                'required',
                Rule::exists('posts', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ]);

        
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $post=Post::where('id',$request->post_id)->first();

       return $this->sendResponse($post);

    }
///////////////////////////////////////////////  Delete Post  ///////////////////////////////////////////
     public function delete(Request $request){
        
        $validator = Validator::make($request->all(), [
            'post_id'=>[
                'required',
                Rule::exists('posts', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ]);

        
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        Post::where('id', $request->post_id)->delete();
        return $this->sendResponse(null,'your post deleted successfully');

    }
}
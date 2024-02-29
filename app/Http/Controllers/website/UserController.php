<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Image;
use Str;
use File;

class UserController extends Controller
{
    public function index(Request $request)
    {  

        if ($request->has('search')) {

            $all_users = user::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('phone', 'LIKE', '%' . $request->search . '%')->paginate(10);
        } else {

            $all_users= user::orderBy('id','desc')->paginate(10);
        } 
        return view('website.users.index',compact('all_users'));

    }

    public function create(){
        return view('website.users.user.create');
    }

    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
                'password' => ['required', 'string', 'min:8','confirmed'],
                'username' =>['required'],
                'phone_number' => ['required', 'unique:users,phone', 'numeric'],
                

            ]);

           
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $name=$request->first_name.' '.$request->last_name;
            $user = User::create([
                'name' => $name,
                'email'=> $request->email ,
                'phone'=>$request->phone_number,
                'username'=> $request->username,
                'password'=>  Hash::make($request->password)
                
            ]);
            $role = Role::where('name','Client')->first();
            
            $user->assignRole([$role->id]);

          return redirect('/users');

    }

    public function edit($id){
        $user=User::where('id',$id)->first();
        return view('website.users.user.edit',compact('user'));
    }

    public function update(Request $request,$id){
         $validator = Validator::make($request->all(), [
               
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,' . $id],
                
                'username' =>['required'],
                'phone_number' => ['required', 'unique:users,phone,' . $id, 'numeric'],
            

            ]);

           
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            
            User::where('id',$id)->update([ 'name' => $request->name,
            'email'=> $request->email ,
            'phone'=>$request->phone_number,
            'username'=> $request->username]);
             return redirect('/users');

    }


   

     public function delete($id)
    {
        User::where('id', $id)->delete();
        return redirect('/users');
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class AuthController extends ApiController
{
///////////////////////////////////////////  Register  ///////////////////////////////////////////

   

    public function register(Request $request){

        $validator  =   Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8','confirmed'],
            'username' =>['required'],
            'phone_number' => ['required', 'unique:users,phone', 'numeric'],
            
        ]);
        // dd($request->all());
        if ($validator->fails()) {

            return $this->sendError(null,$validator->errors());
        }
        
        $name=$request->first_name.' '.$request->last_name;
        $verification_code = substr(str_shuffle('0123456789'), 0, 6);
        $user = User::create([
            'name' => $name,
            'email'=> $request->email ,
            'phone'=>$request->phone_number,
            'username'=> $request->username,
            'password'=>  Hash::make($request->password),
            'verification_code'=>$verification_code,
        ]);

        $role = Role::where('name','Client')->first();
            
        $user->assignRole([$role->id]);
        $phone='+2'.$user->phone; 
        $accountSid = 'ACaffa993dec0732d3ba73bb744deb07c3';
        $authToken = '22d64ac295ea7cb7010665ce788f74a7';

        $twilio = new Client($accountSid, $authToken);
        // $validation_request = $twilio->validationRequests
        //                      ->create($phone, // phoneNumber
        //                               ["friendlyName" => "My Home Phone Number"]
        //                      );
        $message = $twilio->messages->create(
            $phone,
            [
                'from' => '+16802062371',
                'body' => 'Your verification code is: ' . $verification_code
            ]
        );
        User::where('id',$user->id)->delete();
        
       
        return $this->sendResponse(null,'A verification code will be sent via SMS message');

    }


    public function verify_register(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'verification_code'=>'required'
           
        ]);

        if ($validator->fails()) {
            return $this->sendError(null,$validator->errors(),400);
        }
        $success_login = false;
        $user = User::withTrashed()->Where('phone', $request->phone)->whereHas('roles', function ($q) {
            $q->where('roles.name', 'Client');
        })->latest()->first();
       
        if ($user && $request->verification_code && $request->verification_code==$user->verification_code) {
            $success_login = true;
            $user->deleted_at=null;
            $user->save();   
        }

        if($success_login){
            $token = auth('api')->login($user);
            $response['token']=$token;
            $response['token_type']='bearer';
            $response['expires_in']=auth('api')->factory()->getTTL() * 60;
            $response['user'] = $user;
        }else{
            return $this->sendError(null,'verification code is incorrect',400);
           
        }

        return $this->sendResponse($response);
    }

///////////////////////////////////////////  Login  ///////////////////////////////////////////


    public function login(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'phone' => ['required','numeric'],
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError(null,$validator->errors());
        }

        if (! $token = auth('api')->attempt($validator->validated())) {
            
            return $this->sendError(null,'please check your credentials');
        }
        $response['token']=$token;
        $response['token_type']='bearer';
        $response['expires_in']=auth('api')->factory()->getTTL() * 60;
        $response['user']=auth('api')->user();
        return $this->sendResponse($response);
        
       
    }
///////////////////////////////////////////  Logout  ///////////////////////////////////////////

    public function logout(){
        auth('api')->logout();
        
        return $this->sendResponse(null,'You are logout of system');
        
    }

    ///////////////////////////////////////////////// Log ////////////////////////////
    public function get_today_log(){
        $date=date('Y-m-d');
        $logFilePath = storage_path('logs/laravel-'.$date.'.log');
        if (file_exists($logFilePath)) {
            $logs = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            // The FILE_IGNORE_NEW_LINES flag removes newlines from each line
            // The FILE_SKIP_EMPTY_LINES flag skips empty lines

            $logArray = [];
            foreach ($logs as $log) {
            
                $startPosition = strpos($log, '{');

                    if ($startPosition !== false) {
                        $resultString = substr($log, $startPosition);
                        $resultString=json_decode($resultString,true);
                        if($resultString['status_code']!=500)
                            $resultString['response']=json_decode($resultString['response']);
                        $logArray[] =  $resultString;
                    
                    }
                
            }
        }else{
            $logArray=[];
        }
        
     
        return $this->sendResponse($logArray);
    }
}
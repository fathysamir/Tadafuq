<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Image;
use Str;
use File;

class ProfileController extends ApiController
{  
    public function user_profile()
    {
       $user=Auth('api')->user();
       return $this->sendResponse($user);
	}

}
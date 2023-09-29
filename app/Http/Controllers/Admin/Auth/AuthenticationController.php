<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{   
  
  #Register Controller
  public function register(Request $request)
  {
    # Validate the form data
    $this->validate($request, [
      'name'       =>   'required|string|max:255',
      'email'      =>   'required|email',
      'password'   =>   'required',
      'c_password' =>   'same:password',
    ]);

    DB::beginTransaction();
    try
    {
      $addUser = new User;

      $addUser->name        = $request->name; 
      $addUser->email       = $request->email; 
      $addUser->password    = Hash::make($request->password);
      $addUser->save(); 

       DB::commit();
       return array('success' => true, 'msg'=>['New User Added']);
      }catch(\Exception $e){
          DB::rollBack();
         
          if($e->errorInfo[1] == 1062){
              return array('success' => false, 'msg'=>['Email ID already Exists!']);
          }else{
              return array('success' => false, 'msg'=>['Internal server error!']);
          }
       }
    
  }


    # Login controller
    public function login(Request $request)
    {
      # Validate the form data
      $this->validate($request, [
        'email'    =>  'required|email',
        'password' => 'required|min:8'
      ]);

      $findUser = User::where('email',$request->email)->first();
      $guard = 'web';
      Auth::guard($guard)->attempt(['email' => $request->email, 'password' => $request->password]);

      return [
        'success' => true,
        'msg'     => 'Login Successful',
        'token'   =>  $findUser->createToken($guard)->plainTextToken,
        'guard'   => $guard,
        'name'    => $findUser->name
      ];
    }

    #logout Controller
    public function logout()
    {
      $guard = Auth::getDefaultDriver();
      // //dd($guard);
      // $user  = Auth::guard($guard)->user();
      
      // $user->tokens()->delete();
      Auth::guard($guard)->logout();
        return [
            'success' => true,
            'message' => 'Logged out',
            'token'   => '',
        ];
    }
}

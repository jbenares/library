<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login_form(){
        $formData = [
            'email'=>null,
            'password'=> null,
        ];

        return response()->json($formData);
   }

   public function login_process(Request $request){
       
    
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
           
        ];
     
   
            if (Auth::attempt($credentials)) {
                
                $user = $request->user();
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                $success['name'] = $user->name;
                $success['id'] = $user->id;

            $response = [
                    'success' => true,
                    'data' => $success,
                    'message' => 'User login successfully'
            ];

            return response()->json($response, 200);
            } else {

                $response = [
                    'success' => false,
                    'message' => 'Unauthorized'
            ];
            
            return response()->json($response,200);     
            }

    }

    public function get_users_details($id){
        
        $userdetails = User::where('id','=',$id)->get();
        foreach($userdetails AS $ud){
            $formData=[
                
                'name'=>$ud->name,
                'email'=>$ud->email
            ];
        }

        return $formData;
       
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
      }

}

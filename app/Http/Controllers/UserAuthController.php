<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use OpenApi\Generator;
use App\Events\ResetPasswordEvent;
use Validator;
use Exception;
use Password;
use Illuminate\Auth\Events\PasswordReset;

class UserAuthController extends Controller
{
    //register a user
    public function create(Request $request){
        $registerUserData =Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        if ($registerUserData->fails())
        {
            return response(['errors'=>$registerUserData->errors()->all()], 401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'User Created ',
            'status'=> 201 
        ]);
    }
    //login
/** 
        * @OA\Post(
        * path="/api/v1/login",
        * operationId="authLogin",
        * tags={"Login"},
        * summary="User Login",
        * description="Login User Here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email", "password"},
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="password", type="password"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function login(Request $request){
        $loginUserData = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($loginUserData->fails())
        {
            return response(['errors'=>$loginUserData->errors()->all()], 422);
        }
       
        $user = User::where('email',$request->email)->first();
       
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'status' => 200,
        ]);
    }
    //logout 

    public function logout(){
        auth()->user()->tokens()->delete();
    
        return response()->json([
          "message"=>"logged out"
        ]);
    }
    /**forgot password API */
   public function forgetPassword(Request $request)
   {
       $data = [];
       try
       {
           $validator = Validator::make($request->all(), [
               'email' => 'required|email'
           ]);
           if ($validator->fails()) {
                   $data ['status'] = 201;
                   $data ['data'] = 'Validation Error.';
                   $data ['message'] = $validator->errors()->first();
                   return response()->json($data);
           }
        //    $response = Password::sendResetLink($request->only('email'));
        $email = $request->email;
     
        $user = User::where('email', $email)->first();
        if($user == null)
        {
            $data ['status'] = 401;
            $data ['data'] = "";
            $data ['message'] = "Email is not exist in database.";
        }else{
        $response = event(new ResetPasswordEvent($email));
           if($response) {
                           $data ['status'] = 200;
                           $data ['data'] = "";
                           $data ['message'] = "Reset password email sent successfully.";
           } else {
                           $data ['status'] = 200;
                           $data ['data'] = "";
                           $data ['message'] = "Unable to send reset password email.";
           }
       }}
       catch(Exception $ex)
       {
               $data ['status'] = 500;
               $data ['data'] = 'Something Went Wrong...';
               $data ['message'] = $ex->getMessage();
       }
       return response()->json($data);
   }
//view reset form
   public function viewReset(Request $request)
    {
        
        
        $data['email'] = $request->email;
        $data['token'] = $request->token;
        return view('auth.reset-password',$data);
    }
//Change password after get rest link on your email
    public function storePassword(Request $request)
    {
        // try{
        $validator = \Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 401);
        }

        
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    // 'account_verified'=>1,
                    'password' => \Hash::make($request->password),
                    'remember_token' => \Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }
        );
        // return Password::PASSWORD_RESET;
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
       if($status == Password::PASSWORD_RESET)
       {
           
           return response()->json(['message'=> 'password changed','status'=>200]);
       }
       return response()->json(['message' => 'Password not changed','status'=>401]);
    }
    // catch(Exception $e)
    // {
    //     return response()->json(['message' => 'Somthing went wrong','status'=>500]);
    // }
    // }
    
}
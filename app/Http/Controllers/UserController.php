<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\VerifyCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        $request->validate([
            "name"=>"required|string|max:50",
            "email"=>"required|string|unique:users,email",
            "password"=>"required|string|min:6"
        ]);

        $verfiycode = rand(10000, 99999);

       $user= User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "verifycode"=>$verfiycode,
            "is_verified"=>"0"
        ]);

        Mail::to($user->email)->send(new VerifyCode($user));

        return response()->json(["status"=>"success"]);
    }

    
public function verifyCode(Request $request){
    $request->validate(
        [
            "email"=>"required|string",
            "verifycode"=>"required|string"
        ]
        );
        $user=User::where("email",$request->email)
        ->where("verifycode",$request->verifycode)->firstOrFail();
        if(!$user){
         return response()->json(['status' => 'fail', 'message' => 'رمز التحقق غير صحيح'], 400);
        }

        $user->update([
            "is_verified"=>"1",
        ]);

      return response()->json(['status' => 'success']);
}



public function resendVerificationCode(Request $request){
   $request->validate([
        "email"=>"required|string"
    ]);
    $user=User::where("email",$request->email)->firstOrFail();
    if(!$user){
        return response()->json(['status' => 'fail', 'message' => 'المستخدم غير موجود'], 404);
    }
    if($user->is_verified=="1"){
        return response()->json(['status' => 'fail', 'message' => 'الحساب مفعل مسبقًا'], 400);
    }

    $newCode=rand(10000, 99999);
    $user->update([
         "verifycode"=>$newCode
        ]);

    Mail::to($user->email)->send(new VerifyCode($user));
    return response()->json(['status' => 'success']);
}


    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
            $request->validate([
            "email"=>"required|string",
            "password"=>"required|string|"
        ]);

        if(!Auth::attempt($request->only("email","password")))
         return response()->json([
            'status' => 'fail',
            'message' => 'بيانات الدخول غير صحيحة'
        ], 401);

        $user = User::where("email",$request->email)->FirstOrFail();
        if($user->is_verified=="0"){
                        return response()->json([
                'status' => 'fail',
                'message' => 'الحساب غير مفعل، الرجاء التحقق من بريدك الإلكتروني أولاً'
            ], 403); 
        }
        $token =$user->createToken("token")->plainTextToken;
       return response()->json(
        [
            "status"=>"success",
            "user"=>$user,
            "token"=>$token
        ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "status"=>"success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $user=User::find($id)->profile;
       return response()->json(["status"=>"success","user"=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function getdatauser()
    {
        $data = User::with("profile")->get();
       return  UserResource::collection($data);
    }

    //    public function getdatauser()
    // {
    //     $user_id =Auth::user()->id;
    //     $data = User::with("profile")->findOrFail($user_id);
    //    return new UserResource($data);
    // }
}

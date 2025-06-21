<?php
namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'    => 'required|in:admin,student,instructor',
            'major'    => 'nullable|string|max:100',
        ]);

         if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        
      $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => bcrypt($request->password),
    'role' => $request->role,
    'major' => $request->major,
]);


          $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
 
      return response()->json([
    'message' => "User registered as {$user->role}",
    'user' => new UserResource($user),
    'token' => $token,
    'token_type' => 'Bearer',
]);

    }







  public function login(LoginRequest $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'بيانات اعتماد غير صالحة'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('auth-token', [$user->role])->plainTextToken;

    return response()->json([
        'message'     => "Login successful as {$user->role}",
        'token'       => $token,
        'token_type'  => 'Bearer',
    ]);
}


 // Profile 
    public function profile(Request $request)
    {
        return response()->json([
            'name' => $request->user(),
            'role' => $request->user()->role
        ]);
    }
 





 public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
  
 

}

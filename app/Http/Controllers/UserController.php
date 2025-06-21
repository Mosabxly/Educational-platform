<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $users = User::with([
            'coursesTeach',
            'enrollments',
            'reviews',
            'quizResults',
            'certificates',
            'payments'
        ])->paginate(3);  
      return UserResource::collection($users); // تم إضافة return هنا
    }

        
    /**
     * Show the form for creating a new resource.
     */
   /* public function create()
    {
        //
    }*/

   
    
    public function store(StoreUserRequest  $request)
    {

          $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return new UserResource($user);

    }

   
    
    public function show(string $id)
    {
           $user = User::with([
            'coursesTeach',
            'enrollments',
            'reviews',
            'quizResults',
            'certificates',
            'payments'
        ])->findOrFail($id);

        return new UserResource($user); }

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


    public function update(UpdateUserRequest  $request, string $id)
    {
        

        $user = User::findOrFail($id);
        $data = $request->validated();
        $user->update($data);
        return response()->json(['message' => 'تم التحديث', 'user' => $user]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 200);
   
    }
}

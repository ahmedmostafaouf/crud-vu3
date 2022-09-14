<?php
namespace App\Repository;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Repository\Interfaces\UsersInterFace;

class UsersRepository implements UsersInterFace{
    public function update_user($request, $user)
    {
        $input=$request->except('password');
        if($request->has('password') && $request->password!=null){
            $input['password']=$request->password;
        }
        $user->update($input);
        return response()->json(['status'=>true,'message'=>'updated success'],200);

    }
    public function create_user($request)
    {

        User::create($request->all());
        return response()->json(['status'=>true,'message'=>'Created success'],200);

    }
    public function destroy_user($user)
    {
        $user->delete();
        return response()->json(['status'=>true,'message'=>'deleted success'],200);
    }
    public function get_users($request)
    {
        $users = User::filter($request);
        return UserResource::collection($users);
    }
    public function edit_user($user)
    {
       return UserResource::make($user);
    }
}

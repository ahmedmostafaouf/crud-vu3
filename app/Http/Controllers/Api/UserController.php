<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Repository\Interfaces\UsersInterFace;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UsersInterFace $usersInterFace;

    public function __construct(UsersInterFace $usersInterFace)
    {
        $this->usersInterFace = $usersInterFace;
    }


    public function index(Request $request)
     {
         return $this->usersInterFace->get_users($request);

     }


    public function create()
    {
        //
    }


    public function store(UserRequest $request)
    {
        $this->usersInterFace->create_user($request);
    }




    public function edit(User $user)
    {
       return response()->json(['status'=>true, 'message'=>'return success','user'=>$this->usersInterFace->edit_user($user)],200);
    }


    public function update(UserRequest $request, User $user)
    {
        $this->usersInterFace->update_user($request,$user);
    }

    public function destroy(User $user)
    {
        $this->usersInterFace->destroy_user($user);
    }
}

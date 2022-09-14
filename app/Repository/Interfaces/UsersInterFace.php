<?php
namespace App\Repository\Interfaces;

interface UsersInterFace
{
    public function get_users($request);
    public function create_user($request);
    public function update_user($request,$user);
    public function destroy_user($user);
    public function edit_user($user);


}

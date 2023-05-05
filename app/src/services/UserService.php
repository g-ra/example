<?php

namespace App\Services;

use Model\User;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    public function getAllUsers(Request $request)
    {
        return User::all();
    }

    public function findByID(Request $request, $id)
    {
        return User::find($id);
    }

    public function store(Request $request)
    {
        $input = json_decode($request->getContent(), true);
        $user = new User;
        $user->fill($input);
        $user->save();
        return [$user->name, $user->email, $user->id];
    }

    public function update(Request $request, $id)
    {
        $input = json_decode($request->getContent(), true);
        $user = User::find($id);
        $user->fill($input);
        $user->save();
        return true;
    }

    public function destroy(Request $request, $id)
    {
        User::destroy($id);
        return true;
    }
}

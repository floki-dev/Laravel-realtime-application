<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection|User[]
     */
    public function index()
    {
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Model|User
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request['password']);

        return User::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return User
     */
    public function update(Request $request, User $user): User
    {
        $data = $request->all();
        $data['password'] = Hash::make($request['password']);

        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return User
     */
    public function destroy(User $user): User
    {
        $user->delete();

        return $user;
    }
}

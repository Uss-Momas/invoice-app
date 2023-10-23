<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LkUserType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            "message"    =>  "All users data!",
            "data"  =>  $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|string|email",
            "first_name" => "required",
            "last_name" => "required",
            "password" => "required|string",
            'phone_number'  => "required"
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user_type = $request->user_type === LkUserType::ADMIN ? LkUserType::ADMIN : LkUserType::CUSTOMER;
        $user->user_type = $user_type;
        $user->save();

        return response()->json([
            "status" => "success",
            "message"   => "User created with success!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            "status" => "success",
            "data"   => $user
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "email" => "required",
            "first_name" => "required",
            "last_name" => "required",
            'phone_number'  => "required"
        ]);
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->update();

        return response()->json([
            "status" => "success",
            "message"   => "User updated with success!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            "status" => "success",
            "message"   => "User deleted with success!"
        ]);
    }
}

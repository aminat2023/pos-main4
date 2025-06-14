<?php

namespace App\Http\Controllers;

use App\Models\User; // Use the correct User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); // Get all users
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'required|boolean',
        ]);
    
        // Create a new User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->phone = $request->phone; // Store phone number
        $user->password = Hash::make($request->password); // Secure password hashing
        $user->is_admin = $request->is_admin;
        $user->save();
    
        if ($user) {
            return redirect()->back()->with('success', 'User created successfully');
        }
        return redirect()->back()->with('error', 'User failed to create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // 'phone' => 'required|string|max:15', // Adjust this if necessary
            'password' => 'nullable|string|min:8',
            'is_admin' => 'required|boolean',
        ]);
    
        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        //  $user->phone = $request->phone; // Uncomment if you intend to update the phone number
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Update password if provided
        }
        $user->is_admin = $request->is_admin;
        $user->save();
    
        return redirect()->back()->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}



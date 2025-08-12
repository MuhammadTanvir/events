<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
            'email' => 'required|email|unique:users,email',
        ]);
        // Create user with random password
        $password = Str::random(10);
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        // Generate password reset token
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        //Send welcome mail with token (include reset link)
        Mail::to($user->email)->send(new WelcomeMail($user, $token));

        return redirect()->route('users.index')->with('success', 'User created and reset email sent successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
     {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // No need to find the user again, Laravel already injected it
        $user->update($request->only('name', 'role', 'email'));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent users from deleting their own account
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        // Continue with deletion
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}

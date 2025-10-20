<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['department'])->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plants = Plant::all();
        $roles = Role::all();
        return view('users.create', compact('plants', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
            'user_role' => 'required|string|exists:roles,name'
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_uuid' => $request->department ?? Auth::user()->department->uuid,
        ]);

        $user->assignRole($request->user_role);
        return redirect()->route('users.index')->with('success', 'User created successfully');
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
    public function edit($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $plants = Plant::all();
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();
        return view('users.edit', compact('user', 'plants', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username'   => 'required|string|max:255',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'user_role'  => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'username'        => $request->username,
            'name'            => $request->name,
            'email'           => $request->email,
            'department_uuid' => $request->department ?? Auth::user()->department->uuid,
        ]);

        // ✅ Replace existing roles with the new one
        $user->syncRoles([$request->user_role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus($uuid)
    {
        $user = User::firstWhere('uuid', $uuid);

        if ($user->status = 1) {
            $user->update([
                'status' => 0
            ]);
        } elseif ($user->status = 0) {
            $user->update([
                'status' => 1
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Status user berhasil diupdate');
    }
}

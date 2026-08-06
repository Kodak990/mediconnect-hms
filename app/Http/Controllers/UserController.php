<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role   = $request->get('role');

        $users = User::when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        $totalUsers   = User::count();
        $totalAdmins  = User::where('role', 'admin')->count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPatients= User::where('role', 'patient')->count();

        return view('users.index', compact(
            'users', 'search', 'role',
            'totalUsers', 'totalAdmins', 'totalDoctors', 'totalPatients'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,doctor,patient,nurse,lab,billing',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User account created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,doctor,patient,nurse,lab,billing',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('users.index')
            ->with('success', 'User role updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User account deleted.');
    }
}
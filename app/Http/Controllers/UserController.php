<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a listing of the users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }


    // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created user in storage
    public function store(Request $request)
    {
        // Validate and save a new user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        // Validate and update user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Only update name and email, and optionally password
        $user->update($request->only('name', 'email'));

        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function bookmark(Post $post)
    {
        $bookmark = Bookmark::where('post_id', $post->id)
                            ->where('user_id', auth()->id())
                            ->first();

        if ($bookmark) {
            // If bookmark exists, delete it (toggle functionality)
            $bookmark->delete();
            return redirect()->back()->with('success', 'Bookmark removed.');
        } else {
            // Create a new bookmark
            Bookmark::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
            ]);
            return redirect()->back()->with('success', 'Post bookmarked successfully.');
        }
    }

    public function bookmarks()
    {
        $user = auth()->user();
        $bookmarks = $user->bookmarks; // Assuming you have a relationship set up in User model

        return view('users.bookmarks', compact('bookmarks'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        // Fetch posts with related user and category, and paginate them
        $posts = Post::with(['user', 'category'])->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        // Fetch all categories for the post creation form
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Create new post
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->user_id = Auth::id(); // Assign post to the logged-in user

        // Handle image upload if there is an image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        // Save the post
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Check if the logged-in user is the author of the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        // Fetch categories for the form
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Ensure the authenticated user is the author of the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        // Validate the updated form input
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update post fields
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;

        // Handle image upload if there is a new image
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            // Store the new image
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        // Save the updated post
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function bookmark(Request $request, $postId)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())->where('post_id', $postId)->first();

        if ($bookmark) {
            $bookmark->delete(); // Remove bookmark if it already exists
        } else {
            Bookmark::create(['user_id' => auth()->id(), 'post_id' => $postId]); // Create bookmark
        }

        return back();
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Ensure the authenticated user is the author of the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        // Delete the post's image if it exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

}

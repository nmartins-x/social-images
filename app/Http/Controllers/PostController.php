<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Show most recent post and display the post view
     * 
     * @return View
     */
    public function index(): View
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Display the post create view
     * 
     * @return View
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store new Post and redirect
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);
        
        $imagePath = $request->file('image')->store('uploads', 'public');

        auth()->user()->posts()->create([
           'caption' => $data['caption'],
           'image_path' => $imagePath
        ]);
        
        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Display a post view
     * @param Post $post
     * @return type
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Validates user and displays the edit view
     * 
     * @param Post $post
     * @return type
     */
    public function edit(Post $post)
    {
        $this->validateUser($post);
        
        return view('posts.edit', compact('post'));
    }

    /**
     * Validates user and updates a Post, then redirect
     * 
     * @param Request $request
     * @param Post $post
     * @return type
     */
    public function update(Request $request, Post $post)
    {
        $this->validateUser($post);
        
        $data = $request->validate([
            'caption' => 'required'
        ]);
        
        $post->update($data);
        
        return redirect('/posts/' . $post->id);
    }

    /**
     * Validate, destroy one one post and redirect
     * 
     * @param Post $post
     * @return type
     */
    public function destroy(Post $post)
    {
        $this->validateUser($post);
        
        Storage::disk('public')->delete($post->image_path);
        
        $post->delete();
        
        return redirect('/profile/' . auth()->user()->id);
    }
    
    /**
     * Validate that user is Authenticated and owns the Post
     * @param Post $post
     */
    private function validateUser(Post $post) {
        if (auth()->id() !== $post->user_id) {
            abort(403, "Forbidden");
        }
    }
}

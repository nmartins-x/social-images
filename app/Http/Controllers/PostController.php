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
    
    public function index(): View
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);
        
        $imagePath = $request->file('image',)->store('uploads', 'public');
        
        auth()->user()->posts()->create([
           'caption' => $data['caption'],
           'image_path' => $imagePath
        ]);
        
        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->validateUser($post);
        
        return view('posts.edit'. compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->validateUser($post);
        
        $data = $request->validate([
            'caption' => 'required'
        ]);
        
        $post->update($data);
        
        return redirect('/posts' . $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->validateUser($post);
        
        Storage::disk('public')->delete($post->image_path);
        
        $post->delete();
        
        return redirect('/profile/' . auth()->user()->id);
    }
    
    private function validateUser(Post $post) {
        if (auth()->id() !== $post->user_id) {
            abort(403, "Forbidden");
        }
    }
}

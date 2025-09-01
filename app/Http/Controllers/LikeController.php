<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function store(Post $post): RedirectResponse
    {
        $post->likes()->create([
           'user_id' => auth()->id()
        ]);
        
        return back();
    }
    
    public function destroy(Post $post): RedirectResponse
    {
        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);
        
        return back();
    }
    
    private function validateUser(Comment $comment) {
        if (auth()->id() !== $comment->user_id && auth()->id() !== $comment->post->user_id) {
            abort(403, "Forbidden");
        }
    }
}

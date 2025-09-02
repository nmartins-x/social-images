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
    
    /**
     * Store new like and return to previous view
     * 
     * @param Post $post
     * @return RedirectResponse
     */
    public function store(Post $post): RedirectResponse
    {
        $post->likes()->create([
           'user_id' => auth()->id()
        ]);
        
        return back();
    }
    
    /**
     * DEstroy new like and return to previous view
     * 
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);
        
        return back();
    }
    
     /**
     * Validate that user is Authenticated and owns the Post
     * @param Comment $comment
     */
    private function validateUser(Comment $comment) {
        if (auth()->id() !== $comment->user_id && auth()->id() !== $comment->post->user_id) {
            abort(403, "Forbidden");
        }
    }
}

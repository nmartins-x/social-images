<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Store new comment and redirect
     * 
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'comment' => 'required|max:255',
        ]);
        
        $post->comments()->create([
           'comment' => $data['comment'],
           'user_id' => auth()->id()
        ]);
        
        return redirect('/posts/' . $post->id);
    }
    
    /**
     * Destroy new comment and redirect
     * 
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->validateUser($comment);
        
        $postId = $comment->post_id;
        $comment->delete();
        
        return redirect('/posts/' . $postId);
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

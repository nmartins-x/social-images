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
     * Destroy post like and return to previous view
     * 
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->likes()->where([
            'user_id' => auth()->id(),
        ])->delete();
        
        return back();
    }
}

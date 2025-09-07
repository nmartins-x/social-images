<?php

namespace App\Http;

/**
 * Class defining all HTTP route names
 */
class Routes {
    public const HOME = 'home';
    public const LOGIN = 'login';
    
    // POSTS
    public const POSTS_INDEX = 'posts.index';
    public const POSTS_STORE = 'posts.store';
    public const POSTS_CREATE = 'posts.create';
    public const POSTS_SHOW = 'posts.show';
    public const POSTS_EDIT = 'posts.edit';
    public const POSTS_UPDATE = 'posts.update';
    public const POSTS_DESTROY = 'posts.destroy';
    
    // PROFILE
    public const PROFILE_SHOW = 'profile.show';
    public const PROFILE_EDIT = 'profile.edit';
    public const PROFILE_UPDATE = 'profile.update';
    
    // COMMENTS
    public const COMMENTS_STORE = 'comments.store';
    public const COMMENTS_DESTROY = 'comments.destroy';
    
    // LIKES
    public const LIKES_STORE = 'likes.store';
    public const LIKES_DESTROY = 'likes.destroy';
}

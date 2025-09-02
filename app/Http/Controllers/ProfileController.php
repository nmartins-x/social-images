<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{    
    /**
     * Displays the profile view
     * 
     * @param User $user
     * @return View
     */
    public function index(User $user): View
    {
        return view('profiles.index', compact('user'));
    }

    /**
     * Validates user and displays the profile edit view
     * 
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $this->validateUser($user);
        
        return view('profiles.edit', compact('user'));
    }

    /**
     * Validates user, updates profile and redirects
     * 
     * @param Request $request
     * @param User $user
     * @return type
     */
    public function update(Request $request, User $user)
    {
        $this->validateUser($user);
        
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'bio' => 'nullable',
            'profile_image' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:4096'
        ]);
        
        // @TODO unique username check
        
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profile', 'public');
            $data['profile_image'] = $imagePath;
        }
        
        $user->update($data);
        
        return redirect("/profile/{$user->id}");
    }
    
     /**
     * Validate that user is Authenticated and owns the Profile
     * @param User $user
     */
    private function validateUser(User $user) {
        if (auth()->id() !== $user->id) {
            abort(403, "Forbidden");
        }
    }
}

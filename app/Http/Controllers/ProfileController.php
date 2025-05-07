<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $user = Auth::user();

        try {
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    Storage::delete($user->profile_picture);
                }

                // Store the new profile picture
                $path = $request->file('profile_picture')->store('profile_picture', 'public');
                $user->profile_picture = $path; // Save the path to the user model
            }

            $user->save(); // Save the user model
            return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'Failed to upload profile picture: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Store new image in public/storage/profile_pictures
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Save the image path in the database
            $user->profile_picture = $path; // Store the relative path
            $user->save();

            return response()->json(['success' => true, 'profile_picture' => asset('storage/' . $path)]);
        }

        return response()->json(['success' => false, 'message' => 'Profile picture failed to upload.']);
    }

    public function uploadTest(Request $request)
    {
        $request->validate([
            'test_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('test_picture');
        $imageName = 'test_' . time() . '.' . $image->extension();
        $image->move(public_path('test_uploads'), $imageName);

        return back()->with('success', 'Test file uploaded successfully!');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Check if the user already has a profile picture and delete it
        if ($user->profile_picture) {
            $oldImagePath = public_path('storage/' . $user->profile_picture);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }
        }

        // Store the new profile picture
        $file = $request->file('profile_picture');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/profile_pictures', $fileName);

        // Update the user's profile picture path in the database
        $user->profile_picture = 'profile_pictures/' . $fileName;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile picture updated successfully.');
    }
}



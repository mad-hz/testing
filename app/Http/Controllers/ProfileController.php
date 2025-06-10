<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesValidationRequests;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use HandlesValidationRequests;

    /**
     * Display the user's information form
     */
    public function profile(Request $request): View
    {
        return view('profile.information', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's security form
     */
    public function security(Request $request): View
    {
        return view('profile.security', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $request->validate(array_merge(
            $this->validationRequestRules()
        ));
        $this->deleteValidationRequests($request, $user);

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        if ($request->filled('skills')) {
            $skills = collect(explode(',', $request->input('skills')))
                ->map(fn($skill) => trim($skill))
                ->filter()
                ->implode(', ');
            $user->skills = $skills;
        }

        $user->save();

        return redirect()->route('users.show', compact('user'))->with('success', 'Profile has been updated!');
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
}

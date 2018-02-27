<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	/**
	 * @param \App\Http\Requests\Users\UpdateProfileRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateProfile(UpdateProfileRequest $request)
	{
		$user = Auth::user();
		
		// Check if old password is correct
		if (Hash::check($request->password, $user->password)) {
			
			// Update email
			$user->email = $request->email;
			
			// Change role
			$user->is_admin     = $request->get('is_admin', false);
			$user->is_moderator = $request->get('is_moderator', false);
			
			// Update password if new password given
			if (isset($request->new_password)) {
				$user->password = Hash::make($request->new_password);
			}
		} else {
			return response()->json([
										'message' => 'The given data was invalid.',
										'errors'  => [
											'password' => ['Password is incorrect.'],
										],
									], 500);
		}
		
		// Update changes
		$user->save();
		
		Auth::logout();
		
		return response()->json(true);
	}
}

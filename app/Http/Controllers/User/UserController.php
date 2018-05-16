<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\UserUpdateRequest;

class UserController extends Controller
{
    private $user;
    private $response;
    private $statusCode;

    public function __construct()
    {
        $this->response = true;
        $this->statusCode = 200;
    }

    /**
     * Update user profile
     *
     * @param \App\Http\Requests\Users\UserUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request): JsonResponse
    {
        // Set user
        $this->user = Auth::user();

        if ($this->checkIsUserCanBeUpdated($request->password)) {
            // Update email
            $this->user->email = $request->email;

            // Change role
            $this->user->is_admin = $request->get('is_admin', false);
            $this->user->is_moderator = $request->get('is_moderator', false);

            // Update password if new password given
            if (isset($request->new_password)) {
                $this->user->password = Hash::make($request->new_password);
            }

            // Update changes
            $this->user->save();

            // Log out
            Auth::logout();
        }

        return response()->json($this->response, $this->statusCode);
    }

    /**
     * Validate user
     *
     * @param string $requestPassword
     *
     * @return bool
     */
    private function checkIsUserCanBeUpdated(string $requestPassword): bool
    {
        // Validate user name is not admin or moderator
        if (!$this->isUserNameValid()) {
            return false;
        };

        // Validate user password
        if (!$this->isUserPasswordValid($requestPassword)) {
            return false;
        }

        // User can be updated
        return true;
    }

    /**
     * Check user name
     *
     * @return bool
     */
    private function isUserNameValid(): bool
    {
        $tempName = strtolower($this->user->name);

        if ($tempName === 'admin' || $tempName === 'moderator') {
            $this->setResponse(['message' => $this->user->name . ' data can`t be updated.'], 500);

            return false;
        }

        return true;
    }

    /**
     * Validate password
     *
     * @param $requestPassword
     *
     * @return bool
     */
    private function isUserPasswordValid(string $requestPassword): bool
    {
        if (!Hash::check($requestPassword, $this->user->password)) {
            $this->setResponse([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['Password is incorrect.'],
                ],
            ], 500);

            return false;
        }

        return true;
    }

    /**
     * Set response
     *
     * @param     $response
     * @param int $statusCode
     */
    private function setResponse($response, int $statusCode): void
    {
        $this->response = $response;
        $this->statusCode = $statusCode;
    }
}
<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Avatar;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    /**
     * Create an user deactivate and send notification to account confirm
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [json] message, errors
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Loggin user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [json] token, error
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        $customClaims = [];
        if ($request->remember_me)
            $customClaims = ['exp' => Carbon::now()->addWeeks(1)->getTimestamp()];

        if (! $token = auth()->claims($customClaims)->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::createFromTimestamp(auth()->payload()->get('exp'))->toDateTimeString()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return [json] message
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return [json] user obj
     */
    public function user()
    {
        return response()->json(auth()->user());
    }
}

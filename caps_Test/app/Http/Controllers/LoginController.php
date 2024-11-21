<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class LoginController extends Controller
{
    public function loginview(){
        return view ('login_and_Signup.Login');
    }
    public function isStaff($userId)
    {
        $user = DB::table('users')->where('id', $userId)->first();

        if ($user) {
            // Assuming you have an 'is_staff' column in your users table
            return $user->is_staff;
        }

        return false;
    }
    public function login(LoginRequest $request)
    {
        $email = $request->input('emailInput');
        $password = $request->input('passwordInput');

        // Retrieve the user and join with the usertype and preference tables
        $user = DB::table('users')
            ->join('usertype', 'users.idusertype', '=', 'usertype.idusertype') // Join with the usertype table
            ->leftJoin('preference_table', 'users.id', '=', 'preference_table.user_id') // Left join with preference_table using the foreign key
            ->select('users.id', 'users.email', 'users.password', 'users.is_verified', 'usertype.userRole', 'preference_table.idpreference') // Select necessary fields
            ->where('users.email', $email)
            ->first();

        // Check if the user exists
        if ($user) {
            // Verify the password
            if (Hash::check($password, $user->password)) {
                // Check if the user is verified
                if ($user->is_verified !== 'Verified') {
                    // User is not verified, don't allow login
                    return redirect()->route('otp.request')->withInput($request->only('emailInput'))->withErrors([
                        'emailInput' => __('auth.not_verified'), // Ensure this error message is defined in your translation files
                    ]);
                }

                // Password is correct, update status to 'online'
                DB::table('users')->where('id', $user->id)->update(['is_online' => 'online']);
                
                // Store user info in session
                session(['id' => $user->id, 'email' => $user->email, 'userRole' => $user->userRole]);

                // Now, check if the user has a related idpreference in the preference_table
                if (!$user->idpreference && $user->userRole === 'is_user') {
                    // If the user doesn't have a preference and is a 'is_user', redirect them to set their preferences
                    return redirect()->route('preference.view')->with('status', 'Please set your preferences before proceeding.');
                }

                // Check the user role and redirect accordingly
                switch ($user->userRole) { // Assuming 'userRole' stores 'is_admin', 'is_staff', 'is_user'
                    case 'is_admin':
                        return redirect()->route('admin.home'); // Redirect to admin route
                    case 'is_staff':
                        return redirect('/applicants'); // Redirect to staff route
                    case 'is_user':
                        return redirect('/homepage'); // Redirect to user route
                    default:
                        // Handle unexpected user roles
                        return redirect('/login')->withErrors(['error' => 'User role not recognized']); // Default fallback with error
                }
            } else {
                // Password is incorrect
                return redirect()->route('login.view')->withInput($request->only('emailInput'))->withErrors([
                    'emailInput' => __('auth.failed'), // Custom message for failed login
                ]);
            }
        } else {
            // User does not exist
            return redirect()->route('login.view')->withInput($request->only('emailInput'))->withErrors([
                'emailInput' => __('auth.failed'), // Custom message for user not found
            ]);
        }

        }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Perform logout operations, such as clearing session data or tokens
        $userId = session('id'); // Assuming 'id' is stored in the session

        if ($userId) {
            // Update user status to offline
            DB::table('users')->where('id', $userId)->update(['is_online' => 'offline']);

            // Clear the session data
            $request->session()->flush();

            // Optionally regenerate session ID for security
            $request->session()->regenerate();

            // Redirect to login or another view after logout
            return redirect()->route('login.view');
        }

        // If session doesn't exist, just redirect to login
        return redirect()->route('login.view');
    }
}

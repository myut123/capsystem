<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHome extends Controller
{
    public function viewAdmin(){
       
                // Retrieve the user ID from the session
                $userId = session('id'); // This should fetch the user's ID stored in session

                // Retrieve the user data from the database
                $user = DB::table('users')
                    ->join('usertype', 'users.idusertype', '=', 'usertype.idusertype')
                    ->select('users.first_name', 'users.last_name', 'users.email', 'users.is_online','usertype.userRole as role') // Adjust fields as necessary
                    ->where('users.id', $userId)
                    ->first();
                
                if ($user) {
                    // Return the view and pass the user data to it
                    return view('Admin.Homepage', ['user' => $user]); // Adjust the view name to your actual view
                } else {
                    // If user not found, redirect to the login page with an error message
                    return redirect()->route('login.view')->withErrors(['error' => 'User not found. Please login again.']);
                }
    }
}

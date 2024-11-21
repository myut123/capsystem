<?php

namespace App\Http\Controllers;

use App\Http\Requests\registerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class registrationController extends Controller
{
    public function registrationview(Request $request){
        return view ('login_and_Signup.mockup'); 
    }
    public function registration(Request $request)
    {  
        $password = $request->input('passwordReg');
        $confirmPassword = $request->input('conPassword'); // Assuming the name of the confirm password field is 'conPassword'
    
        if ($password !== $confirmPassword) {
            // Password and confirm password do not match
            return redirect()->route('register.link')->withErrors(['error' => 'Passwords do not match. Please try again.']);
        }
    
        // Validate the input data
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'emailReg' => 'required|string|email|max:255|unique:users,email',
            'passwordReg' => 'required',
        ]);
    
        // Define the user role you want to insert
        $role = [
            'userRole' => 'is_user' // Ensure that 'is_user' is a string
        ];
    
        // Insert the new user role into the usertype table and get the ID
        $userTypeId = DB::table('usertype')->insertGetId($role);
    
        // Prepare the user data including the idusertype
        $register = [
            'first_name' => $validatedData['fname'],
            'middle_name' => $validatedData['mname'],
            'last_name' => $validatedData['lname'],
            'email' => $validatedData['emailReg'],
            'password' => Hash::make($validatedData['passwordReg']), // Hash the password before storing
            'idusertype' => $userTypeId, // Insert the user type ID into the idusertype column
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
      
        // Insert the new user and get the inserted ID
        $insertedId = DB::table('users')->insertGetId($register);

        if ($insertedId) {
            Session::put('user_id', $insertedId); // Store the user ID in the session
            return redirect()->route('otp.request')->with(['email' => $validatedData['emailReg']]);
        } else {
            return redirect()->route('login.view')->withErrors(['error' => 'Failed to register. Please try again.']);
        }
    }
    
}

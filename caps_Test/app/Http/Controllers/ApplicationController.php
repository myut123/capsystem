<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function showApplicationForm($petId)
    {
        $userId = session('id');
        if (!$userId) {
            // Redirect to the login page if user_id is not in session
            return redirect()->route('login.view')->with('error', 'Please log in to continue.');
        }

        $userId = session('id'); 
     
        $user = DB::table('users')
            ->where('id', $userId)
            ->select('*') // Select all columns from the users table
            ->first();


        session(['petId' => $petId]);

 
        
        return view('home.adoption', ['petId' => $petId, 'user' => $user]);
        
    }
    public function submitApplication(Request $request)
    {
        
            $userId = session('id'); // Retrieve user ID from session
            $petId = session('petId'); // Retrieve pet ID from session
            
            // Step 1: Insert the address and retrieve the new idaddresses
            $idaddresses = DB::table('addresses')->insertGetId([
                'street' => $request->input('street'),
                'barangay' => $request->input('barangay'),
                'city' => $request->input('city'),
                'region' => $request->input('region'),
                'postalCode' => $request->input('postal_code')
            ]);
            
            // Step 2: Update the user's idaddresses in the users table
            $updated = DB::table('users')
                ->where('id', $userId)
                ->update(['idaddresses' => $idaddresses]); // Update the user's address ID
            
            if (!$updated) {
                // Handle update failure
                return redirect()->route('error.page')->with('error', 'Failed to update user address.');
            }
            
            // Fetch user details from the database after the update
            $user = DB::table('users')->where('id', $userId)->first();
            
            if (!$user) {
                return redirect()->route('error.page')->with('error', 'User not found.'); // Redirect to an error page
            }
            
            // Insert the adoption application data into the database
            try {
                $inserted = DB::table('adoption_application')->insert([
                    'id' => $userId, // Assuming this is the foreign key to the users table
                    'idpet' => $petId, // Assuming the pet ID is passed in the session
                    'application_date' => now(), // Set to current date and time
                    'first_name' => $user->first_name, // First name from the user details
                    'last_name' => $user->last_name, // Last name from the user details
                    'status' => 'pending', // Default status for the application
                    'transportation_time' => $request->input('time'), // Transportation time
                    'meridiem' => $request->input('meridiem'), // Meridiem value from the request
                    'transportation_date' => $request->input('date'), // Transportation date from the request
                    'id_address' => $idaddresses // New address ID from the inserted address
                ]);
            
                if ($inserted) {
                    return redirect()->route('home.view')->with('success', 'Application submitted successfully.'); // Redirect to success page
                } else {
                    return redirect()->route('adoption.error')->with('error', 'Failed to submit application.'); // Redirect to error page
                }
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the insert
                return redirect()->route('adoption.error')->with('error', 'An error occurred: ' . $e->getMessage()); // Redirect to error page
            }
            
    }
    public function submitEmployment(Request $request)
    {
        $userId = session('id');
            if (!$userId) {
                // Redirect to the login page if user_id is not in session
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            // Validate the request
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'employment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'utility_bills' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'monthly_income' => 'required|numeric',
        ]);

        // Handle file uploads for employment proof and utility bills
        $employmentProofPath = $request->file('employment_proof')->store('uploads/employment_proofs');
        $utilityBillsPath = $request->file('utility_bills')->store('uploads/utility_bills');

        // Insert the employment information and get the inserted ID
        $employmentId = DB::table('employment_info')->insertGetId([
            'job_title' => $validated['job_title'],
            'employment_proof' => $employmentProofPath,
            'utility_bills' => $utilityBillsPath,
            'income' => $validated['monthly_income'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get the user ID from the session
        $userId = session('id'); // Adjust this according to how you're storing user ID in the session

        // Update the user table with the new employment ID
        DB::table('users')->where('id', $userId)->update([
            'id_employment' => $employmentId, // Assuming your users table has an employment_id column
            'updated_at' => now(),
        ]);

        // Optionally return a response or redirect
        return response()->json(['message' => 'Employment information stored successfully!'], 201);
    }
    public function idsubmit(Request $request)
    {
        $userId = session('id');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }
        
        $request->validate([
            'valid_id_1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'valid_id_2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selfie_picture' => 'required|string',
        ]);
        
        $validId1Path = $request->file('valid_id_1')->store('valid_ids', 'public');
        $validId2Path = $request->file('valid_id_2')->store('valid_ids', 'public');
        
        // Handle the selfie picture
        $selfieData = $request->input('selfie_picture');
        $selfieData = str_replace('data:image/png;base64,', '', $selfieData);
        $selfieData = str_replace(' ', '+', $selfieData);
        
        // Generate a short, unique filename for the selfie
        $selfieImageName = 'selfie_' . uniqid() . '.png';
        Storage::put('public/selfies/' . $selfieImageName, base64_decode($selfieData));
        
        // Prepare data for insertion
        $data = [
            'goverment_id' => $validId1Path,
            'valid_id' => $validId2Path,
            'selfie' => 'selfies/' . $selfieImageName, // Save the short filename of the selfie
            'updated_at' => now(),
        ];
        
        DB::table('users')
            ->where('id', $userId)
            ->update($data);
        
        return redirect()->back()->with('success', 'Reference information submitted successfully.');
        
    }
}

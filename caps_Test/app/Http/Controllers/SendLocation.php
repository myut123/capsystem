<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LocationMail;
use Illuminate\Support\Facades\Log;

class SendLocation extends Controller
{
    public function viewMap(){
        return view('home.map');
    }

    public function saveLocation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user_id exists in the users table
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        DB::table('locations_save')->insert([
            'user_id' => $request->input('user_id'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Location saved successfully.']);
    }

    public function sendLocationEmail(Request $request)
    {
        $userId = $request->input('user_id'); // Assuming userId is passed from the request
    
        // Retrieve the location for the user without ordering
        $location = DB::table('adoption_application')
            ->where('id', $userId) // Use the appropriate foreign key for user
            ->select('idadoption_application') // Select the desired field
            ->first();
        
            if ($location) {
                // Access idadoption_application from the result
                $idadop = $location->idadoption_application;
            } else {
                // Handle case when no location is found
                Log::error('No adoption application found for user ID: ' . $userId);
            }

            if ($idadop) {
                // Create a Google Maps URL using the latitude and longitude
                // Assuming $location contains latitude and longitude for the current application
                $mapUrl = "http://127.0.0.1:8000/api/location/{$idadop}";
            
                // Fetch user details
                $user = DB::table('users')->where('id', $userId)->first();
            
                if ($user) {
                    Mail::raw($mapUrl, function ($message) use ($user) {
                        $message->to($user->email)
                                ->subject('Your Location Information');
                    });
            
                    return response()->json(['message' => 'Location email sent successfully.']);
                } else {
                    return response()->json(['error' => 'User not found.'], 404);
                }
            } else {
                // Log the error when the location is not found
                Log::error('Location not found for user ID: ' . $userId);
                return response()->json(['error' => 'Location not found.'], 404);
            }
            
    }
    
    
    

}

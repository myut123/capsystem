<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;


class getLoc extends Controller
{

    public function viewLocation($id)
    {

        $application = DB::table('adoption_application')
            ->join('users', 'adoption_application.id', '=', 'users.id') // Join with users table
            ->join('locations_save', 'adoption_application.id_address', '=', 'locations_save.idlocations_save') // Join with locations_save table
            ->select(
                'adoption_application.*',
                'users.first_name',
                'users.email',
                'locations_save.latitude',  // Assuming you need latitude and longitude
                'locations_save.longitude',
                'adoption_application.id_address'
            )
            ->where('adoption_application.idadoption_application', $id) // Use the correct foreign key
            ->first();

        if ($application) {
            // Store id_address in session
            Session::put('id_address', $application->id_address);

            // Pass the application data to the view
            return view('MapInfo.PetInfo', [
                'application' => $application,
                'id' => $id,
            ]);
        }
        
        // Log the error when the application is not found
        Log::warning("Adoption application not found for ID: {$id}");

        // Return a 404 view if the application is not found
        return response()->view('errors.404', [], 404);
            
     }

    // Method to get the user's location
    public function getUserLocation($userId): JsonResponse
    {

        $idAddress = Session::get('id_address');

        dd($idAddress);
 

        $location = DB::table('locations_save')->where('idlocations_save', $idAddress)->first();

        dd($location);
        if ($location) {
            // Log the successful retrieval of location
            Log::info("Location found for user ID: {$userId}", [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
            ]);

            return response()->json([
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
            ]);
        } else {
            // Log the error when the location is not found
            Log::warning("Location not found for user ID: {$userId}");

            // Return a 404 response if no location is found
            return response()->json(['error' => 'Location not found'], 404);
        }
    }


}

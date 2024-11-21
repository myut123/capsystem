<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class petController extends Controller
{
    public function viewtData(Request $request){
        $pets = Pet::all(); 
        return view('home.recommendPage', ['pets' => $pets]);
    }
    public function viewPetListing(Request $request){

        $userId = $request->session()->get('id');
        // Retrieve user preferences
        
        $userPreferences = DB::table('users')
            ->join('preference_table', 'users.idpreference', '=', 'preference_table.idpreference')
            ->select('preference_table.*')
            ->where('users.id', $userId)
            ->first();
    
        // Query pet data based on matching criteria
        $query = DB::table('pet');
    
        if ($userPreferences) {
            $query->where('species', $userPreferences->species)
                ->where('color', $userPreferences->color)
                ->where('size', $userPreferences->size);
            // Add more criteria as needed
        }
    
        // Execute the query and get the matched pets
        $matchedPets = $query->get();
    
        // Pass matched pets to the view
        return view('home.recommendPage', ['matchedPets' => $matchedPets]);
    }

}

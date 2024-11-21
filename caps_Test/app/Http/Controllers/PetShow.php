<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class PetShow extends Controller
{public function clickablepet($idpet)
    {
        // Retrieve user ID from the session
        $userId = session('id');
    
        // If no user ID is found in the session, return an error or redirect
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view pet details.');
        }
    
        // Fetch the main pet details
        $pets = DB::table('pet')
            ->join('pet_categories', 'pet.idpet', '=', 'pet_categories.pet_id')
            ->join('selection_store', 'pet_categories.selected_id', '=', 'selection_store.idselection_store')
            ->join('category_store', 'selection_store.category_id', '=', 'category_store.idcategory_store')
            ->where('pet.idpet', $idpet)
            ->select('pet.*', 'pet.img as pet_image', 'pet_categories.*', 'selection_store.choice', 'category_store.idcategory_store as category_id', 'category_store.category_name as category_name')
            ->get();
    
        // If no pet is found, return a 404 Not Found response
        if ($pets->isEmpty()) {
            abort(404);
        }
    
        // Log the interaction in the interaction table
        DB::table('interaction')->insert([
            'user_id' => $userId,
            'pet_id' => $idpet,
            'interaction_type' => 'view', // Assuming you have an interaction_type column
            'created_at' => now(),       // Laravel's helper for current timestamp
            'updated_at' => now()
        ]);
    
        // Fetch similar pets based on the main pet's category or traits, excluding the current pet
        $similarPets = DB::table('pet')
            ->join('pet_categories', 'pet.idpet', '=', 'pet_categories.pet_id')
            ->join('selection_store', 'pet_categories.selected_id', '=', 'selection_store.idselection_store')
            ->join('category_store', 'selection_store.category_id', '=', 'category_store.idcategory_store')
            ->where('category_store.idcategory_store', $pets[0]->category_id) // Now this will work since category_id is selected
            ->where('pet.idpet', '!=', $idpet) // Exclude the current pet
            ->select('pet.*', 'pet.img as pet_image', 'selection_store.selection_name', 'category_store.*')
            ->limit(4) // Optionally limit the number of similar pets to display
            ->get();
    
        // Log the queries
        Log::info('Main Pet Details:', (array) $pets);
        Log::info('Similar Pets:', (array) $similarPets);
    
        // Return the view with both the main pet and similar pets
        return view('home.Petshow', [
            'pets' => $pets,
            'similarPets' => $similarPets // Pass similar pets to the view
        ]);
    }
    

    public function getCompatibility($petId)
    {
        // Fetch the pet's selected traits (selected_id) along with the category name
        $petCategories = DB::table('pet')
            ->join('pet_categories', 'pet.idpet', '=', 'pet_categories.pet_id')
            ->join('selection_store', 'pet_categories.selected_id', '=', 'selection_store.idselection_store')
            ->join('category_store', 'selection_store.category_id', '=', 'category_store.idcategory_store')
            ->where('pet.idpet', $petId)
            ->select('pet_categories.selected_id', 'category_store.category_name') // Fetch selected_id and category_name
            ->get();
    
        // Log retrieved pet categories
        Log::info('Pet Categories:', ['petCategories' => $petCategories]);
    
        // Fetch user traits using the user_id from session
        $userId = session('id'); // Get user ID from session
        Log::info('Session Data:', ['sessionId' => $userId]);
    
        // Fetch user traits from the preference_table
        $userTraits = DB::table('preference_table')
            ->where('user_id', $userId)
            ->pluck('selected_id') // Get only selected_id values
            ->toArray(); // Convert to an array for easy comparison
    
        // Log retrieved user traits
        Log::info('User Traits Data:', ['userTraits' => $userTraits]);
    
        if ($petCategories->isEmpty()) {
            Log::error('Error fetching traits.', [
                'petId' => $petId,
                'userId' => $userId,
                'petCategories' => $petCategories,
                'userTraits' => $userTraits,
            ]);
            return response()->json(['error' => 'Pet traits not found.'], 404);
        }
    
        // Fetch all categories for comparison
        $allCategories = DB::table('category_store')->pluck('category_name')->toArray(); // Get all category names
        $compatibility = [];
    
        // Iterate through each category to ensure all are displayed
        foreach ($allCategories as $categoryName) {
            // Find the pet category with the corresponding name
            $petCategory = $petCategories->firstWhere('category_name', $categoryName);
            
            // Initialize the compatibility score
            if ($petCategory) {
                $petSelectedId = $petCategory->selected_id; // Get the pet's selected_id
                // Calculate compatibility score
                $compatibility[$categoryName] = $this->calculateCompatibility($petSelectedId, $userTraits);
            } else {
                // If pet category does not exist, set compatibility to 0
                $compatibility[$categoryName] = 0; // No match if category is not found
            }
        }
    
        Log::info('Calculated compatibility:', ['compatibility' => $compatibility]);
    
        return response()->json($compatibility);
    }
    
    private function calculateCompatibility($petSelectedId, $userSelectedIds)
    {
        // Check if the selected_id matches any of the user's selected_ids
        if (in_array($petSelectedId, $userSelectedIds)) {
            return 100; // Perfect match if selected_id matches
        } elseif ($petSelectedId !== null && !empty($userSelectedIds)) {
            return 50; // Partial match (both selected_id exist but are different)
        } else {
            return 0; // No match if one or both selected_ids are missing
        }
    }  
}

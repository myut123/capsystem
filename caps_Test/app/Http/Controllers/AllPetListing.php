<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AllPetListing extends Controller
{
    public function viewAllListing(Request $request)
    {
      // Check if user ID is present in the session
        $userId = session('id');

        if (!$userId) {
            // If user ID is not found in session, redirect to the login page
            return redirect()->route('login.view'); // Make sure you have a named route for 'login'
        }

        // Query all pets from the 'pet' table
        $matchedPets = DB::table('category_store')
            ->join('selection_store', 'category_store.idcategory_store', '=', 'selection_store.idselection_store') // Join with selection_store
            ->join('pet_categories', 'selection_store.idselection_store', '=', 'pet_categories.selected_id') // Join with pet_categories
            ->join('pet', 'pet_categories.pet_id', '=', 'pet.idpet') // Join with pet table
            ->select('pet.*') // Select all columns from the pet table
            ->distinct() // Optional: to ensure unique pets
            ->get(); // Execute the query

        // Query to fetch categories
        $categories = DB::table('category_store')
            ->select('idcategory_store AS id', 'category_name') // Ensure to select the 'id' column
            ->get(); // Fetch categories

        // Pass matched pets and categories to the view
        return view('home.recommendPage', [
            'matchedPets' => $matchedPets,
            'categories' => $categories
        ]);
    }
    
    public function fetchCategoryContent($categoryId)
    {
        Log::info('Fetching content for category ID: ' . $categoryId);
    
        // Fetch content based on the category ID dynamically from the database using joins
        $content = DB::table('selection_store')
            ->join('pet_categories', 'selection_store.idselection_store', '=', 'pet_categories.selected_id') // Join with pet_categories
            ->where('selection_store.category_id', $categoryId) // Use the category ID to filter
            ->select('pet_categories.idpet_categories', 'pet_categories.pet_id') // Select pet_id and idpet_category from pet_categories
            ->distinct() // Optional: to ensure unique results
            ->get(); // Execute the query
    
        // Check if content exists
        if ($content->isNotEmpty()) {
            // Fetch detailed pet information for the fetched pet IDs
            $petDetails = DB::table('pet')
                ->whereIn('idpet', $content->pluck('pet_id')) // Use the pet IDs from the content
                ->get();
    
            // Return the pet details along with their categories
            return response()->json([
                'content' => $content,
                'petDetails' => $petDetails,
            ]);
        } else {
            Log::warning('No content found for category ID: ' . $categoryId);
            return response()->json(['message' => 'Content for this category is not available.'], 404);
        }
        
    }
    public function showpet($categoryId)
    {   
            $userId = session('id');
        // First, get the selected_id values from the preference table
            $selectedIds = DB::table('preference_table')
            ->where('user_id', $userId) // Assuming there's a user or some filter
            ->pluck('selected_id'); // Get all selected_ids as an array

            // Now, query the pet details based on matching selected_ids
            $petDetails = DB::table('pet')
            ->join('pet_categories', 'pet.idpet', '=', 'pet_categories.pet_id') // Join with pet_categories
            ->join('selection_store', 'pet_categories.selected_id', '=', 'selection_store.idselection_store') // Join with selection_store
            ->whereIn('pet_categories.selected_id', $selectedIds) // Only get pets where selected_id matches those in preference
            ->where('selection_store.category_id', $categoryId) // Filter by category ID
            ->select('pet.idpet', 'pet.name', 'pet.description', 'pet.img') // Select relevant pet details
            ->distinct() // Optional: to ensure unique results
            ->get(); // Execute the query

            // Check if pet details exist
            if ($petDetails->isNotEmpty()) {
            return response()->json([
                'success' => true, // Indicate success
                'petDetails' => $petDetails,
            ]);
            } else {
            Log::warning('No pets found for category ID: ' . $categoryId);
            return response()->json(['success' => false, 'message' => 'No pets available for this category.'], 404);
            }

    }
    public function getAllPets(Request $request)
    {
        // Get the current page number from the request, defaulting to 1 if not provided
            $page = $request->input('page', 1);

            // Fetch paginated pets from the database using Query Builder
            $pets = DB::table('pet')->paginate(8, ['*'], 'page', $page); // 8 items per page

            // Return the pets as a JSON response, including pagination info
            return response()->json([
                'success' => true,
                'petDetails' => $pets->items(), // Return only the current page items
                'currentPage' => $pets->currentPage(),
                'totalPages' => $pets->lastPage(),
            ]);
    }
    // Method to get the user's preferences from the 'preferences' table
  
    public function getUserPreferences() {
        // Retrieve the userId from the session
        $userId = session('id');
        Log::info("Retrieved userId from session", ['userId' => $userId]);
    
        if (!$userId) {
            Log::error("User ID not found in session");
            return response()->json(['error' => 'User ID not found in session'], 400);
        }
    
        // Retrieve user preferences based on the session's userId
        $preferences = DB::table('preference_table')
            ->join('pet_categories', 'preference_table.selected_id', '=', 'pet_categories.idpet_categories')
            ->where('preference_table.user_id', $userId)  // Use dynamic user_id
            ->select('preference_table.selected_id', 'pet_categories.*')
            ->get();
    
        if ($preferences->isEmpty()) {
            Log::warning("No preferences found for user", ['userId' => $userId]);
            return null; // Indicate no preferences were found
        }
    
        Log::info("User preferences retrieved", ['preferences' => $preferences]);
    
        return $preferences;
    }
    
    public function getPetsWithCategories() {
        Log::info("Fetching pets with categories");
    
        // Fetch pets and join with pet_categories
        $pets = DB::table('pet')
            ->join('pet_categories', 'pet.idpet', '=', 'pet_categories.pet_id')
            ->leftJoin('selection_store', 'selection_store.idselection_store', '=', 'pet_categories.selected_id')
            ->select('pet.idpet as id', 'pet.name', 'pet.img', 'pet_categories.idpet_categories', 'selection_store.idselection_store')
            ->distinct()  // Ensure distinct pet records
            ->get()
            ->map(function ($pet) {
                $pet->selection_choice = [
                    'selected_id' => $pet->selected_id ?? null,
                ];
                unset($pet->selected_id);
                return $pet;
            });

    
        Log::info("Pets with categories fetched", ['pets' => $pets]);
    
        return $pets;
    }
    
    
    public function contentBasedScore($userPreferences, $pet) {
        Log::info("Calculating content-based score", [
            'userPreferences' => $userPreferences,
            'pet' => $pet,
        ]);
    
        $dotProduct = 0;
        $userMagnitude = 0;
        $petMagnitude = 0;
    
        // Loop through user preferences and calculate the score
        foreach ($userPreferences as $preference) {
            $categoryId = $preference->idpet_categories;  // Matching category ID
    
            // Check if the pet's category matches the user's preference
            if ($pet->idpet_categories == $categoryId) {
                // Assuming preferences include a value for matching categories
                $userValue = $preference->value ?? 1;  // Default to 1 if no value is set
                $petValue = 1;  // Pet has this category, so value is 1
    
                // Calculate the dot product, user magnitude, and pet magnitude
                $dotProduct += $userValue * $petValue;
                $userMagnitude += pow($userValue, 2);
                $petMagnitude += pow($petValue, 2);
            }
        }
    
        if ($userMagnitude == 0 || $petMagnitude == 0) {
            Log::warning("Magnitude is zero, returning a score of 0");
            return 0;
        }
    
        // Calculate cosine similarity score
        $score = $dotProduct / (sqrt($userMagnitude) * sqrt($petMagnitude));
        Log::info("Content-based score calculated", ['score' => $score]);
    
        return $score;
    }
    
    
    
    
    public function collaborativeFilteringScore($userId, $petId) {
        Log::info("Calculating collaborative filtering score", [
            'userId' => $userId,
            'petId' => $petId,
        ]);
    
        // Retrieve all users who have interacted with the given pet (excluding the current user)
        $similarUsers = DB::table('interaction')
            ->where('pet_id', $petId)
            ->where('user_id', '!=', $userId)
            ->pluck('user_id');  // Returns a collection of user_ids who interacted with the pet
    
        Log::info("Similar users retrieved", ['similarUsers' => $similarUsers]);
    
        // If there are no similar users, return a score of 0
        if ($similarUsers->isEmpty()) {
            Log::info("No similar users found, returning score of 0");
            return 0;
        }
    
        // Count the number of interactions for the pet from similar users
        $interactionCount = DB::table('interaction')
            ->whereIn('user_id', $similarUsers)
            ->where('pet_id', $petId)
            ->count(); // Count the number of interactions
    
        Log::info("Interaction count calculated", ['interactionCount' => $interactionCount]);
    
        // Calculate the score based on the interaction count and the number of similar users
        $score = $interactionCount > 0 ? $interactionCount / $similarUsers->count() : 0;
    
        Log::info("Collaborative filtering score calculated", ['score' => $score]);
    
        return $score;
    }

    public function hybridScore($contentScore, $collaborativeScore, $alpha = 0.6) {
        // Ensure the scores are within valid ranges
        $contentScore = max(0, min(1, $contentScore));  // Clamp contentScore between 0 and 1
        $collaborativeScore = max(0, min(1, $collaborativeScore));  // Clamp collaborativeScore between 0 and 1
        
        
        // Compute the hybrid score using the weighted sum formula
        $score = ($alpha * $contentScore) + ((1 - $alpha) * $collaborativeScore);
    
        // Log the scores for debugging or analysis purposes
        Log::info("Hybrid score calculated", [
            'contentScore' => $contentScore,
            'collaborativeScore' => $collaborativeScore,
            'alpha' => $alpha,
            'score' => $score,
        ]);
    
        // Return the final hybrid score
        return $score;
    }
    
    public function recommendPets(Request $request, $alpha = 0.6) {
    // Retrieve user ID from the session
    $userId = session('id');
    Log::info("Starting pet recommendation process", ['userId' => $userId]);

    if (!$userId) {
        Log::error("User ID is not set in the session");
        return response()->json(['error' => 'User ID is not set in the session'], 400);
    }

    // Get page from request, default to 1
    $page = $request->input('page', 1);
    $perPage = 10; // Number of pets to show per page
    Log::info("Pagination parameters", ['page' => $page, 'perPage' => $perPage]);

    // Get user preferences and pet data
    $userPreferences = $this->getUserPreferences();
    Log::info("User preferences retrieved", ['preferences' => $userPreferences]);

    if ($userPreferences === null) {
        Log::info("No preferences found, falling back to random pets");
        $pets = $this->getPetsWithCategories()->random($perPage);
        Log::info("Random pets selected", ['pets' => $pets]);
    } else {
        $pets = $this->getPetsWithCategories();
        Log::info("Pets fetched with categories", ['pets' => $pets]);
    }

    if ($pets->isEmpty()) {
        Log::error("No pets available for recommendation");
        return response()->json(['error' => 'No pets available for recommendation'], 404);
    }

    $recommendations = [];
    $processedPets = [];  // Array to track processed pets

    Log::info("Calculating recommendations for pets");

    // Loop through pets and calculate scores
    foreach ($pets as $pet) {
        // Ensure pet is not already processed
        if (in_array($pet->id, $processedPets)) {
            continue; // Skip already processed pets
        }

        $contentScore = 0;
        if ($userPreferences !== null) {
            $contentScore = $this->contentBasedScore($userPreferences, $pet);
            Log::info("Content-based score calculated", ['pet_id' => $pet->id, 'score' => $contentScore]);
        }

        $collaborativeScore = $this->collaborativeFilteringScore($userId, $pet->id);
        Log::info("Collaborative filtering score calculated", ['pet_id' => $pet->id, 'score' => $collaborativeScore]);

        $hybridScore = $this->hybridScore($contentScore, $collaborativeScore);
        Log::info("Hybrid score calculated", ['pet_id' => $pet->id, 'score' => $hybridScore]);

        // Add pet to recommendations if not already processed
        $recommendations[] = [
            'pet_id' => $pet->id,
            'pet_name' => $pet->name,
            'image_url' => $pet->img,
            'score' => $hybridScore,
        ];

        // Mark this pet as processed
        $processedPets[] = $pet->id;
    }

    // Paginate recommendations
    $totalPets = count($recommendations);
    $totalPages = ceil($totalPets / $perPage);
    $currentPagePets = array_slice($recommendations, ($page - 1) * $perPage, $perPage);

    Log::info("Pagination applied", [
        'totalPets' => $totalPets,
        'totalPages' => $totalPages,
        'currentPagePets' => $currentPagePets
    ]);

    return response()->json([
        'pets' => $currentPagePets,
        'totalPages' => $totalPages,
    ]);
}

    public function showPetsByCategory($categoryId)
    {
          // Fetch pets based on the category ID
          $pets = DB::table('pet')
          ->join('pet_categories', 'pet.idpet', '=', 'pet_categories.pet_id')
          ->join('selection_store', 'pet_categories.selected_id', '=', 'selection_store.idselection_store')
          ->where('selection_store.category_id', 26)  // Replace with your category ID
          ->get();
      
        // Check if any pets are found
        if ($pets->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No pets available for this category.'
            ]);
        }

        // If pets are found, return them
        return response()->json([
            'success' => true,
            'petDetails' => $pets
        ]);
    }


    
    
    
}
        


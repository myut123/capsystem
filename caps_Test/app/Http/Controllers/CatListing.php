<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatListing extends Controller
{
    public function viewtCatData(Request $request){
        $pets = Pet::all(); 
        return view('home.Alldogs', ['pets' => $pets]);
    }
    public function viewCatListing(Request $request){

        $userId = $request->session()->get('id'); // This line can be removed if not required elsewhere

        // Query pet data specifically for dogs
        $query = DB::table('pet')
                    ->where('species', 'cat'); // Filter pets where species is 'dog'
        
        // Execute the query and get the matched pets
        $matchedPets = $query->get();
        
        // Pass matched pets to the view
        return view('home.recommendPage', ['matchedPets' => $matchedPets]);
    }
}

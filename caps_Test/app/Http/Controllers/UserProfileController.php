<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function update(Request $request)
    {
        // Retrieve the user ID from the session
        $userId = session('id');
    
        // Retrieve the user from the database using the user ID
        $user = DB::table('users')->where('id', $userId)->first();
    
        if (!$user) {
            Log::error('User not found for ID: ' . $userId);
            return redirect()->back()->with('error', 'User not found.');
        }
    
        // Proceed with the validation and update logic
        $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'new_password' => 'nullable|string|min:8|confirmed', // Use 'confirmed' for validation
        ]);
    
        // Log the password values for debugging
        Log::debug('New Password: ' . $request->input('new_password'));
        Log::debug('Confirmed Password: ' . $request->input('new_password_confirmation'));
    
        // Check for password and confirmation match
        if ($request->filled('new_password') && $request->input('new_password') !== $request->input('new_password_confirmation')) {
            Log::warning('Password and confirmation do not match for user ID: ' . $userId);
            return redirect()->route('profile.edit')->withErrors(['new_password' => 'The new password field confirmation does not match.']);
        }
    
        // Update the user's profile


        DB::table('users')
        ->where('id', $user->id)
        ->update([
            'first_name' => $request->fname,
            'middle_name' => $request->mname,
            'last_name' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->input('new_password')), // Hash the password
        ]);

    
        Log::info('User profile updated successfully for ID: ' . $user->id);
    
        return response()->json(['message' => 'Profile updated successfully.']);
    }

    public function categories()
    {
        $user = session('id'); 
        

        // Fetch the necessary data from the database
        $results = DB::table('selection_store')
            ->leftJoin('preference_table', function($join) {
                $join->on('selection_store.idselection_store', '=', 'preference_table.selected_id')
                    ->where('preference_table.user_id', '=', 66); // Replace '66' with the actual user ID if necessary
            })
            ->join('category_store', 'selection_store.category_id', '=', 'category_store.idcategory_store')
            ->select('selection_store.*', 'preference_table.selected_id', 'preference_table.user_id', 'category_store.category_name')
            ->get();

    

        // Return a success response with the data
        return response()->json([
            'message' => 'Profile updated successfully!',
            'data' => $results, // Include the results in the response
        ]);

    }
    public function updatecategories(Request $request){

        $request->validate([
            'category' => 'required|array',
            'category.*.selection_name' => 'required|exists:selection_store,selection_name', // Adjust as per your DB schema
        ]);
        
        // Get user ID from the session
        $userId = session('id');
        
        // Check if user ID is available
        if (!$userId) {
            return response()->json(['message' => 'User not found in session'], 404);
        }
        
        // Iterate over the categories and update or create preferences
        foreach ($request->category as $categoryName => $selection) {
            // Find the corresponding selection ID
            $selectionId = DB::table('selection_store')
                ->where('selection_name', $selection['selection_name'])
                ->value('idselection_store'); // Adjust the field names as necessary
        
            // Check if a preference already exists for the user
            $existingPreference = DB::table('preference_table')
                ->where('user_id', $userId)
                ->where('selected_id', $selectionId)
                ->first();
        
            // If preference exists, update it
            if ($existingPreference) {
                DB::table('preference_table')
                    ->where('idpreference', $existingPreference->idpreference)
                    ->update(['selected_id' => $selectionId, 'updated_at' => now()]);
            } else {
                // If preference does not exist, create a new one
                DB::table('preference_table')->insert([
                    'user_id' => $userId,
                    'selected_id' => $selectionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Optionally, return a success response
        return response()->json(['message' => 'Preferences updated successfully'], 200);
        }
        
    public function edit()
    {
       
        $user = session('id');
       
        // Retrieve the user from the database using raw SQL query
        $user = User::where('id', $user)->first();

    
        // Check if the user exists
        if (!$user) {
            abort(404); // Or handle the case where the user doesn't exist
        }
    
        // Return the view with the user data
        return view('home.UpdateProfile', compact('user'));
    }

}

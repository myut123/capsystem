<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditCategory extends Controller
{
    public function viewUpdateCategory()
    {
        // Retrieve the user ID from the session
        $userId = session('id'); // Fetch the user's ID stored in session

        // Retrieve the user data from the database
        $user = DB::table('users')
            ->join('usertype', 'users.idusertype', '=', 'usertype.idusertype')
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.is_online', 'usertype.userRole as role')
            ->where('users.id', $userId)
            ->first();
        
        // Retrieve all categories
        $categories = DB::table('category_Store')->select('idcategory_store', 'category_name')->get(); // Adjust field names as necessary
        
        if ($user) {
            // Return the view and pass the user data and categories to it
            return view('Admin.categoryedit', ['user' => $user, 'categories' => $categories]);
        } else {
            // If user not found, redirect to the login page with an error message
            return redirect()->route('login.view')->withErrors(['error' => 'User not found. Please login again.']);
        }
    }

    // Get analytics data
    public function getAnalyticsData()
    {
        // Count total users
       // Count users with preferences
        $usersWithPreferences = DB::table('users')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('preference_table')
                ->whereColumn('users.id', 'preference_table.user_id');
        })
        ->count();

        // Count users without preferences
        $usersWithoutPreferences = DB::table('users')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('preference_table')
                ->whereColumn('users.id', 'preference_table.user_id');
        })
        ->count();

        // Return the counts in a JSON response
        return response()->json([
        'usersWithPreferences' => $usersWithPreferences,
        'usersWithoutPreferences' => $usersWithoutPreferences,
        ]);


    }

    // Add a new category and selection

    public function addCategoryAndSelections(Request $request)
    {
      // Validate category and selections input
      Log::info('Starting addCategoryWithSelections method');

      // Validate category and selections input
      $request->validate([
          'category_name' => 'required|string|max:255',
          'category_description' => 'nullable|string|max:1000',
          'selections' => 'nullable|array',
          'selections.*' => 'required|string|max:255',
          'selection_choices' => 'nullable|array',
          'selection_choices.*' => 'required|string|max:255',
          'selection_images' => 'nullable|array',
          'selection_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);
  
      DB::beginTransaction();
      try {
          Log::info('Validation passed. Inserting category.');
  
          // Insert the new category and get its ID
          $categoryId = DB::table('category_store')->insertGetId([
              'category_name' => $request->input('category_name'),
              'category_description' => $request->input('category_description'),
              'created_at' => now(),
              'updated_at' => now(),
          ]);
          Log::info("Category inserted with ID: $categoryId");
  
          // If selections are provided, insert them for the category
          if ($request->filled('selections')) {
              Log::info('Selections are provided. Processing selections.');
  
              foreach ($request->input('selections') as $index => $selection) {
                  Log::info("Processing selection: $selection at index $index");
  
                  // Insert selection into the database
                  $selectionId = DB::table('selection_store')->insertGetId([
                      'category_id' => $categoryId,
                      'selection_name' => $selection,
                      'created_at' => now(),
                      'updated_at' => now(),
                  ]);
                  Log::info("Selection inserted with ID: $selectionId");
  
                  // Handle selection choice
                  if (isset($request->input('selection_choices')[$index])) {
                      $choice = $request->input('selection_choices')[$index];
                      Log::info("Updating selection choice for selection ID: $selectionId with choice: $choice");
  
                      DB::table('selection_store')->where('idselection_store', $selectionId)->update([
                          'choice' => $choice,
                      ]);
                  }
  
                  // Handle image upload
                  if ($request->hasFile('selection_images.' . $index)) {
                      Log::info("Uploading image for selection ID: $selectionId");
  
                      $image = $request->file('selection_images.' . $index);
                      $imagePath = $image->store('selection_images', 'public');
                      Log::info("Image uploaded to: $imagePath");
  
                      DB::table('selection_store')->where('idselection_store', $selectionId)->update([
                          'img' => $imagePath,
                      ]);
                  }
              }
          }
  
          DB::commit();
          Log::info('Transaction committed successfully.');
  
          return response()->json([
              'message' => 'Category and selections added successfully!',
              'category_id' => $categoryId,
          ]);
      } catch (\Exception $e) {
          DB::rollBack();
          Log::error('Error in addCategoryWithSelections: ' . $e->getMessage());
  
          return response()->json([
              'message' => 'Failed to add category and selections.',
              'error' => $e->getMessage(),
          ], 500);
      }
    }

    // Update a category
    public function updateCategory(Request $request)
    {

        try {
            // Log incoming request data
            Log::info('Update Selection Request:', $request->all());
        
            // Validate the incoming request
            $validatedData = $request->validate([
                'update_selection_ids.*' => 'sometimes|nullable|integer|exists:selection_store,idselection_store',
                'update_selection_names.*' => 'required|string|max:255',
                'update_selection_choices.*' => 'required|string|max:255',
                'update_selection_category' => 'required|integer|exists:category_store,idcategory_store',
                'update_category_name' => 'sometimes|string|max:255',
                'update_category_description' => 'sometimes|string|max:255',
            ], [
                'update_selection_ids.*.exists' => 'Selected ID must exist in the database.',
                'update_selection_category.exists' => 'The selected category does not exist.',
            ]);
        
            // Initialize arrays to store updated and new selections
            $updatedSelections = [];
            $newSelections = [];
        
            // Check if the user wants to keep the current category name and description
            $keepCurrentName = $request->has('keep_current_category');
            $keepCurrentDescription = $request->has('keep_current_description');
        
            // Prepare timestamp for updates
            $timestamp = now();
        
            // Update category name if the checkbox is not checked
            if (!$keepCurrentName) {
                DB::table('category_store')
                    ->where('idcategory_store', $validatedData['update_selection_category'])
                    ->update([
                        'category_name' => $validatedData['update_category_name'],
                        'updated_at' => $timestamp,
                    ]);
            }
        
            // Update category description if the checkbox is not checked
            if (!$keepCurrentDescription) {
                DB::table('category_store')
                    ->where('idcategory_store', $validatedData['update_selection_category'])
                    ->update([
                        'category_description' => $validatedData['update_category_description'],
                        'updated_at' => $timestamp,
                    ]);
            }
        
            // Loop through each selection name and choice
            foreach ($validatedData['update_selection_names'] as $index => $selectionName) {
                $selectionId = $validatedData['update_selection_ids'][$index] ?? null;
                $selectionChoice = $validatedData['update_selection_choices'][$index];
        
                // If selection ID exists, update it
                if ($selectionId !== null) {
                    $selection = DB::table('selection_store')
                        ->where('idselection_store', $selectionId)
                        ->first();
        
                    // Check if selection was found
                    if (!$selection) {
                        return response()->json(['error' => 'Selection not found.'], 404);
                    }
        
                    // Prepare data for update
                    $updateData = [
                        'selection_name' => $selectionName,
                        'category_id' => $validatedData['update_selection_category'],
                        'updated_at' => $timestamp,
                    ];
        
                    // Only update 'choice' if a valid value is provided (not 'undefined' or empty)
                    if ($selectionChoice !== 'undefined' && !empty($selectionChoice)) {
                        $updateData['choice'] = $selectionChoice;
                    }
        
                    // Update the selection
                    DB::table('selection_store')
                        ->where('idselection_store', $selectionId)
                        ->update($updateData);
        
                    // Store the updated selection result
                    $updatedSelections[] = [
                        'selection_id' => $selectionId,
                        'new_selection_name' => $selectionName,
                        'new_selection_choice' => $updateData['choice'] ?? $selection->choice,
                    ];
                } else {
                    // Check if the selection name already exists in the same category
                    $existingSelection = DB::table('selection_store')
                        ->where('selection_name', $selectionName)
                        ->where('category_id', $validatedData['update_selection_category'])
                        ->first();
        
                    if ($existingSelection) {
                        // Prepare data for update
                        $updateData = [
                            'selection_name' => $selectionName,
                            'updated_at' => $timestamp,
                        ];
        
                        // Only update 'choice' if a valid value is provided
                        if ($selectionChoice !== 'undefined' && !empty($selectionChoice)) {
                            $updateData['choice'] = $selectionChoice;
                        }
        
                        // Update the existing selection
                        DB::table('selection_store')
                            ->where('idselection_store', $existingSelection->idselection_store)
                            ->update($updateData);
        
                        // Store the updated selection result
                        $updatedSelections[] = [
                            'selection_id' => $existingSelection->idselection_store,
                            'new_selection_name' => $selectionName,
                            'new_selection_choice' => $updateData['choice'] ?? $existingSelection->choice,
                        ];
                    } else {
                        // Prepare data for insertion
                        $insertData = [
                            'selection_name' => $selectionName,
                            'category_id' => $validatedData['update_selection_category'],
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];
        
                        // Only insert 'choice' if a valid value is provided
                        if ($selectionChoice !== 'undefined' && !empty($selectionChoice)) {
                            $insertData['choice'] = $selectionChoice;
                        }
        
                        // Insert a new selection
                        $newSelectionId = DB::table('selection_store')->insertGetId($insertData);
        
                        // Store the new selection result
                        $newSelections[] = [
                            'selection_id' => $newSelectionId,
                            'new_selection_name' => $selectionName,
                            'new_selection_choice' => $insertData['choice'] ?? '',
                        ];
                    }
                }
            }
        
            // Log the successful processing of selections
            Log::info('Selections processed successfully.', [
                'updated' => $updatedSelections,
                'new' => $newSelections,
            ]);
        
            return response()->json(['message' => 'Selections processed successfully.', 'updated' => $updatedSelections, 'new' => $newSelections]);
        } catch (ValidationException $e) {
            Log::error('Validation failed:', $e->validator->errors()->toArray());
            return response()->json(['error' => 'Validation failed.', 'details' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error processing selection:', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return response()->json(['error' => 'Unable to process selection.'], 500);
        }
        
        
    }
    // Delete a category
    public function deleteCategory(Request $request)
    {
        $categoryId = $request->input('category_id');

        if (!$categoryId) {
            return response()->json(['message' => 'Category ID is required'], 400);
        }
        
        $request->validate([
            'category_id' => 'required|integer|exists:category_store,idcategory_store',
        ]);
        
        // Perform the soft delete by updating the deleted_at column
        $category = DB::table('category_store')
            ->where('idcategory_store', $categoryId)
            ->update(['delete_at' => Carbon::now()]);
        
        if ($category) {
            return response()->json(['message' => 'Category soft deleted successfully!']);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function updateSelection(Request $request){

        try {
        $request->validate([
            'update_selection_id' => 'required|integer',
            'new_selection_name' => 'required|string|max:255',
            'update_selection_category' => 'required|integer|exists:category_store,idcategory_store',
        ], [
            'update_selection_id.required' => 'Selection ID is required.',
            'new_selection_name.required' => 'Selection name cannot be empty.',
            'update_selection_category.exists' => 'The selected category does not exist.',
        ]);
        

        // Check if the selection belongs to the selected category
        $selection = DB::table('selection_store')
            ->where('idselection_store', $request->update_selection_id)
            ->first();

        if (!$selection || $selection->idcategory_store !== $request->update_selection_category) {
            return redirect()->back()->withErrors(['error' => 'The selected selection does not belong to the chosen category.']);
        }

        // Update the selection name based on the provided ID
        DB::table('selection_store')
            ->where('idselection_store', $request->update_selection_id)
            ->update(['selection_name' => $request->new_selection_name]);

            return response()->json(['message' => 'Category updated successfully.']);
        } catch (\Exception $e) {
            // Log the error if needed
            return response()->json(['error' => 'Unable to update category.'], 500);
        }
    }
    public function searchCategories(Request $request)
    {
        $query = $request->input('query');

        Log::info('Searching categories for query:', ['query' => $query]);
        
        $categories = DB::table('category_store')
            ->where('category_name', 'LIKE', '%' . $query . '%')
            ->whereNull('delete_at') // Exclude soft-deleted categories
            ->get();
        
        Log::info('Categories found:', ['categories' => $categories]);
        
        return response()->json(['categories' => $categories])->header('Content-Type', 'application/json');
        
    }

    public function getSelections(Request $request)
    {
        $categoryId = $request->query('categoryId');

        // Validate the categoryId (optional but recommended)
        if (!$categoryId) {
            return response()->json(['error' => 'Category ID is required'], 400);
        }

        // Fetch selections associated with the given category ID, excluding those with a non-null deleted_at (soft deleted)
        $selections = DB::table('selection_store')
            ->where('category_id', $categoryId)
            ->whereNull('delete_at') // Only include selections where deleted_at is NULL
            ->select('idselection_store', 'selection_name', 'choice') // Adjust fields as needed
            ->get();

        // Return the selections as JSON
        return response()->json($selections);
    }
    public function deleteSelection(Request $request)
    {
            // Log the incoming request for debugging purposes
            Log::info('Incoming delete selection request:', $request->all());

            // Validate the incoming request
            $validatedData = $request->validate([
                'id' => 'required|integer|exists:selection_store,idselection_store', // Ensure the ID exists in the selection_store table
            ]);
            
            $id = $validatedData['id']; // Get the validated ID from the request
            
            // Log the validated ID
            Log::info('Delete selection request received', ['id' => $id]);
            
            // Perform the soft delete by updating the deleted_at column
            $updated = DB::table('selection_store')
                ->where('idselection_store', $id)
                ->update(['delete_at' => Carbon::now()]);
            
            if ($updated) {
                Log::info('Selection soft deleted successfully', ['id' => $id]);
                return response()->json(['message' => 'Selection soft deleted successfully.'], 200);
            }
            
            Log::warning('Selection not found for soft deletion', ['id' => $id]);
            return response()->json(['message' => 'Selection not found.'], 404);
        }
        public function restoreCategory(Request $request)
    
{
    $categoryId = $request->input('restore_category_id');
    $selectionId = $request->input('restore_selection_id');

    // Restore category if category ID is provided
    if ($categoryId) {
        $category = DB::table('category_store')->where('idcategory_store', $categoryId)->first();

        if ($category && $category->delete_at) {  // Check if the category is soft-deleted
            // Update `delete_at` to null to restore the category
            DB::table('category_store')->where('idcategory_store', $categoryId)->update(['delete_at' => null]);
            return response()->json(['message' => 'Category restored successfully.']);
        }

        return response()->json(['error' => 'Category not found or already restored'], 404);
    }

    // Restore selection if selection ID is provided
    if ($selectionId) {
        $selection = DB::table('selection_store')->where('idselection_store', $selectionId)->first();

        if ($selection && $selection->deleted_at) {  // Check if the selection is soft-deleted
            // Update `deleted_at` to null to restore the selection
            DB::table('selection_store')->where('idselection_store', $selectionId)->update(['deleted_at' => null]);
            return response()->json(['message' => 'Selection restored successfully.']);
        }

        return response()->json(['error' => 'Selection not found or already restored'], 404);
    }

    return response()->json(['error' => 'No category or selection ID provided'], 400);
}

        public function searchDeletedCategories(Request $request)
        {
            $query = $request->input('query');

            Log::info('Searching soft-deleted categories for query:', ['query' => $query]);

            // Fetch categories that have a non-null `deleted_at` (soft-deleted)
            $deletedCategories = DB::table('category_store')
                ->where('category_name', 'LIKE', '%' . $query . '%')
                ->whereNotNull('delete_at') // Include only soft-deleted categories
                ->get();

            Log::info('Soft-deleted categories found:', ['deletedCategories' => $deletedCategories]);

            return response()->json(['categories' => $deletedCategories])->header('Content-Type', 'application/json');
        }
        public function getDeletedSelections(Request $request)
        {
            $categoryId = $request->query('categoryId');

            // Validate the categoryId (optional but recommended)
            if (!$categoryId) {
                return response()->json(['error' => 'Category ID is required'], 400);
            }

            // Fetch soft-deleted selections associated with the given category ID
            $deletedSelections = DB::table('selection_store')
                ->where('category_id', $categoryId)
                ->whereNotNull('delete_at') // Only include selections where deleted_at is NOT NULL (soft-deleted)
                ->select('idselection_store', 'selection_name', 'choice') // Adjust fields as needed
                ->get();

            // Return the soft-deleted selections as JSON
            return response()->json($deletedSelections);
        }
    }

    // Get selections for a category
   
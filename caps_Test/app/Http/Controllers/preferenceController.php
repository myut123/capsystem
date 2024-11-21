<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class preferenceController extends Controller
{
    public function showWelcome()
    {
        $firstCategory = DB::table('category_store')->orderBy('idcategory_store', 'asc')->first();

        // Return the view with the first category
        return view('Preference.userWelcome', compact('firstCategory'));
    }

    
    public function showCategories($id)
    {
        // Fetch the specified category by ID
        $category = DB::table('category_store')->where('idcategory_store', $id)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        // Fetch related selections
        $selections = DB::table('selection_store')
            ->where('category_id', $category->idcategory_store)
            ->whereNull('delete_at')
            ->get();

        // Get all categories with progress calculated
        $categories = DB::table('category_store')->get()->map(function ($categoryItem) {
            $totalSelections = DB::table('selection_store')->where('category_id', $categoryItem->idcategory_store)->count();
            $completedSelections = DB::table('preference_table')
                ->where('selected_id', $categoryItem->idcategory_store)
                ->count();

            // Add progress property to each category item
            $categoryItem->progress = $totalSelections > 0 ? ($completedSelections / $totalSelections) * 100 : 0;

            return $categoryItem;
        });

        // Get the next and previous categories
        $nextCategory = DB::table('category_store')
            ->where('idcategory_store', '>', $category->idcategory_store)
            ->orderBy('idcategory_store', 'asc')
            ->first();

        $prevCategory = DB::table('category_store')
            ->where('idcategory_store', '<', $category->idcategory_store)
            ->orderBy('idcategory_store', 'desc')
            ->first();

        // Calculate total progress for the current step
        $completedSteps = $categories->filter(fn($cat) => $cat->progress == 100)->count();

        // Prepare chart data
        $chartData = $this->prepareChartData($selections);

        // Pass all data to the view
        return view('Preference.categories', [
            'category' => $category,
            'selections' => $selections,
            'nextCategory' => $nextCategory,
            'prevCategory' => $prevCategory,
            'categories' => $categories, // Pass categories with progress to the view
            'completedSteps' => $completedSteps, // Total completed steps
            'progress' => ($completedSteps / $categories->count()) * 100,
            'labels' => $chartData['labels'],
            'data' => $chartData['data'],
        ]);
    }
    public function storeSelection(Request $request)
    {
        // Validate the request
        $request->validate([
            'selection_id' => 'required|exists:selection_store,idselection_store',
        ]);
        
        // Get the user ID from session
        $userId = session('id'); // Assuming you've stored user ID in the session
        
        // Check if user ID is available
        if (!$userId) {
            return response()->json(['message' => 'User not found in session'], 404);
        }
        
        // Check for an existing preference for the user and selection
        $existingPreference = DB::table('preference_table')
            ->where('user_id', $userId)
            ->where('selected_id', $request->selection_id)
            ->first();
        
        // If a preference exists, update it
        if ($existingPreference) {
            DB::table('preference_table')
                ->where('idpreference', $existingPreference->idpreference) // Assuming your preference_table has an 'id' column
                ->update([
                    'selected_id' => $request->selection_id,
                    'updated_at' => now(),
                ]);

            return response()->json(['message' => 'Preference updated successfully']);
        }
        
        // If no preference exists, insert a new record
        DB::table('preference_table')->insert([
            'user_id' => $userId,
            'selected_id' => $request->selection_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return response()->json(['message' => 'Selection stored successfully']);
    }
    private function getCategoryProgress($categoryId)
    {
        $totalSelections = DB::table('selection_store')->where('category_id', $categoryId)->count();
        $completedSelections = DB::table('preference_table')
            ->where('selected_id', $categoryId)
            ->count();  // Assuming user selected the category

        // Return the progress as a percentage
        return $totalSelections > 0 ? ($completedSelections / $totalSelections) * 100 : 0;
    }
    private function fetchCategoryAndSelections($categoryId)
    {
        // Fetch the first category
        $firstCategory = DB::table('category_store')->orderBy('idcategory_store', 'asc')->first();

        // Ensure $firstCategory is not null to avoid errors
        if (!$firstCategory) {
            return null; // Return null if no category found
        }

        // Use the ID of the first category
        $categoryId = $firstCategory->idcategory_store;

        // Fetch selections that belong to the specified category
        $selections = DB::table('selection_store')
            ->select('idselection_store', 'selection_name')
            ->where('category_id', $categoryId) // Filter by category_id
            ->get();

        return ['firstCategory' => $firstCategory, 'selections' => $selections];
    }

    private function prepareChartData($selections)
    {
        $labels = [];
        $data = [];

        // Fetch preferences for the retrieved selections
        foreach ($selections as $selection) {
            $totalPreferences = DB::table('preference_table')
                ->where('selected_id', $selection->idselection_store) // Match selection_id
                ->count(); // Count preferences for this selection

            // Prepare data for the chart
            $labels[] = $selection->selection_name; // Get the selection name
            $data[] = $totalPreferences; // Count of preferences
        }

   
        return ['labels' => $labels, 'data' => $data];

      
    }

}

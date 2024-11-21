<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class petUpload extends Controller
{
    public function showstaffPage(Request $request)
    {
        $categories = DB::table('category_store')
        ->leftJoin('selection_store', function($join) {
            $join->on('category_store.idcategory_store', '=', 'selection_store.category_id')
                 ->whereNull('selection_store.delete_at'); // Exclude soft-deleted records from selection_store
        })
        ->select('category_store.idcategory_store as category_id', 
                 'category_store.category_name as category_name', 
                 'selection_store.idselection_store as selection_id', 
                 'selection_store.choice as choice')
        ->get()
        ->groupBy('category_id'); // Grouping by category_id to structure the data
    
        
        // Check if categories are found
        if ($categories->isEmpty()) {
            return redirect()->back()->with('error', 'No categories or selections found.');
        }
        
        // Return view with categories and selections
        return view('home.staffPage', compact('categories'));
    }
    

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'pet_name' => 'required|string|max:255',
                'pet_desc' => 'required|string',
                'pet_img' => 'required|image', // Ensure pet_img is an image
                'pet_imgs' => 'array', // Additional images are optional but can be an array
                'pet_videos' => 'array|nullable', // Allow pet_videos to be nullable (optional)
                'pet_videos.*' => 'mimes:mp4,avi,mov|max:10240', // Validate video types and max size (10MB)
            ]);
    
            // Handle the thumbnail image upload
            $imagePath = null;
            if ($request->hasFile('pet_img') && $request->file('pet_img')->isValid()) {
                $imagePath = $request->file('pet_img')->store('pet_images', 'public'); // Store thumbnail image
            }
    
            // Insert the pet data into the pet table
            $petId = DB::table('pet')->insertGetId([
                'name' => $request->pet_name,
                'description' => $request->pet_desc, // Save the pet description to the database
                'img' => $imagePath, // Save the thumbnail image path to the database
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Insert the pet category into the pet_categories table
            foreach ($request->selection_id as $selectionId) {
                DB::table('pet_categories')->insert([
                    'pet_id' => $petId,
                    'selected_id' => $selectionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Insert additional images into the pet_image table
            if ($request->hasFile('pet_imgs')) {
                foreach ($request->file('pet_imgs') as $image) {
                    // Skip empty files and check if file is valid
                    if ($image && $image->isValid()) {
                        $additionalImagePath = $image->store('pet_images', 'public');
                        DB::table('pet_image')->insert([
                            'pet_id' => $petId,
                            'image_path' => $additionalImagePath,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
    
            // Insert videos into the pet_video table
            if ($request->hasFile('pet_videos')) {
                foreach ($request->file('pet_videos') as $video) {
                    // Skip empty files and check if file is valid
                    if ($video && $video->isValid()) {
                        $videoPath = $video->store('pet_videos', 'public'); // Store each video
                        DB::table('pet_video')->insert([
                            'pet_id' => $petId,
                            'video_path' => $videoPath,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
    
            return response()->json(['success' => 'Pet uploaded successfully with a thumbnail, images, and videos!']);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Pet upload error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'stack' => $e->getTraceAsString(),
            ]);
    
            // Return a response indicating an error occurred
            return response()->json(['error' => 'An error occurred while uploading the pet. Please try again.'], 500);
        }
    }
    
    


    private function getCategoryId($selectionId)
    {
        // Fetch the category_id associated with the given selection_id
        return DB::table('selection_store')
            ->where('idselection_store', $selectionId)
            ->value('category_id');
    }
}

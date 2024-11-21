<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditContent extends Controller
{
    public function viewCampaign()
    {
        $userId = session('id'); // This should fetch the user's ID stored in session

        // Retrieve the user data from the database
        $user = DB::table('users')
            ->join('usertype', 'users.idusertype', '=', 'usertype.idusertype')
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.is_online', 'usertype.userRole as role') // Adjust fields as necessary
            ->where('users.id', $userId)
            ->first();
        
        if ($user) {
            Log::info('User retrieved successfully.', ['userId' => $userId]);
            return view('Admin.editcontent', ['user' => $user]);
        } else {
            Log::warning('User not found for ID: ' . $userId);
            return redirect()->route('Admin.editcontent')->withErrors(['error' => 'User not found. Please login again.']);
        }
    }

    public function storeCampaign(Request $request)
    {
        // Validate form inputs
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Restricting to 2MB image
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaign_images', 'public');
            Log::info('Image uploaded successfully.', ['path' => $imagePath]);
        }

        // Insert campaign data using Query Builder
        $campaignId = DB::table('campaign')->insertGetId([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'content' => $validatedData['content'],
            'img' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Store the campaign ID in the session
        session(['campaign_id' => $campaignId]);

        Log::info('Campaign created successfully.', ['campaignId' => $campaignId]);

        // Redirect to a success page (or wherever you prefer)
        return redirect()->back()->with('success', 'Campaign created successfully!');
    }

    public function update(Request $request)
    {
        // Validate form inputs
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Get the campaign ID from the session or the request
        $campaignId = $request->input('campaign_id'); // Ensure to include this field in your form

        // Prepare the data for updating
        $updateData = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'content' => $validatedData['content'],
        ];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Store the new image and update the path
            $imagePath = $request->file('image')->store('campaign_images', 'public');
            $updateData['img'] = $imagePath; // Update 'img' field with the new image path
            Log::info('New image uploaded for campaign.', ['campaignId' => $campaignId, 'path' => $imagePath]);
        }

        // Update the campaign data using Query Builder
        DB::table('campaign')->where('idcampaign', $campaignId)->update($updateData);

        Log::info('Campaign updated successfully.', ['campaignId' => $campaignId]);

        // Redirect to a success page (or wherever you prefer)
        return redirect()->route('view.campaign')->with('success', 'Campaign updated successfully!');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('title');
        Log::info('Search initiated.', ['searchTerm' => $searchTerm]);
    
        // Fetch campaigns from the database
        $campaigns = DB::table('campaign')
            ->where('title', 'like', '%' . $searchTerm . '%')
            ->get();
    
        Log::info('Search results retrieved.', ['resultsCount' => $campaigns->count()]);
    
        return response()->json($campaigns);
    }
}

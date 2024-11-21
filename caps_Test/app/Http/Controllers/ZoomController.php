<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ZoomController extends Controller
{
    public function showZoom(){
        return view('staffpages.authorize');
    }
    public function listMeetings(Request $request)
    {
        // Retrieve the access token from the session
        $token = session('zoom_access_token');
    
        // Check if the token exists
        if (!$token) {
            return redirect('/oauth/zoom')->withErrors(['error' => 'Access token not found. Please authenticate first.']);
        }
    
        // Fetch meetings using the access token
        $response = Http::withToken($token)->get('https://api.zoom.us/v2/users/me/meetings');
    
        // Check if the response was successful
        if ($response->successful()) {
            // Get meetings from the response, default to an empty array if none
            $meetings = $response->json()['meetings'] ?? []; // Initialize as an empty array if 'meetings' key is missing
            return view('zoom.meetings', ['meetings' => $meetings]);
        }
    
        // Log the error response for debugging purposes
        Log::error('Failed to fetch meetings: ' . $response->body());
    
        // Return error message to the user
        return back()->withErrors(['error' => 'Unable to fetch meetings: ' . $response->body()]);
    }
    
    public function showMeetings(Request $request)
    {
        // Retrieve the meetings from the session
        $meetings = session('zoom_meetings');
    
        // Check if meetings exist
        if (!$meetings) {
            return 'No meetings found. Please authorize the app first.';
        }
    
        return view('staffpages.meetings', ['meetings' => $meetings]);
    }
    //Schedulemeeting
    public function scheduleMeeting(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'timezone' => 'required|string|max:255',
        ]);
        
        // Retrieve access token from session
        $accessToken = session('zoom_access_token');
        
        // Log the access token for debugging
        Log::info('Zoom Access Token: ' . $accessToken);
        
        // Retrieve applicant ID from session
        $applicantId = session('applicant_id');
        
        // You might want to fetch the applicant's details using the applicant ID
        $applicant = DB::table('adoption_application')
            ->join('users', 'adoption_application.id', '=', 'users.id') // Join with the users table
            ->select('adoption_application.*', 'users.email') // Select all fields from adoption_application and the email from users
            ->where('adoption_application.idadoption_application', $applicantId) // Filter by idadoption_application
            ->first();
        
        if (!$applicant) {
            // Handle case where applicant is not found
            Log::error('Applicant not found for ID: ' . $applicantId);
            return redirect('/home')->with('error', 'Applicant not found.');
        }
        
        // Meeting data to send to Zoom API
        $meetingData = [
            'topic' => $validatedData['topic'],
            'type' => 2, // Scheduled meeting
            'start_time' => $validatedData['start_time'] . ':00Z', // Zoom API expects UTC time
            'duration' => 30, // Default duration in minutes
            'timezone' => 'UTC', // Set timezone to UTC
            'agenda' => 'Meeting scheduled via Laravel app',
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'join_before_host' => true,
                'mute_upon_entry' => false,
                'watermark' => false,
                'use_pmi' => false,
                'approval_type' => 0,
                'registration_type' => 1,
                'audio' => 'both',
                'auto_recording' => 'cloud',
                'enforce_login' => false,
            ],
        ];
        
        // Create the meeting using the Zoom API
        $response = Http::withToken($accessToken)->post('https://api.zoom.us/v2/users/me/meetings', $meetingData);
        
        // Log the response for debugging
        Log::info('Response from Zoom API: ' . $response->body());
        
        if ($response->successful()) {
            $meetingInfo = $response->json();
        
            // Convert the start_time to a format compatible with MySQL
            $startTime = Carbon::parse($meetingInfo['start_time'])->format('Y-m-d H:i:s');
        
            // Insert the meeting information into the database
            DB::table('meetings')->insert([
                'topic' => $meetingInfo['topic'],
                'start_time' => $startTime, // Use the formatted start time
                'duration' => $meetingInfo['duration'],
                'join_url' => $meetingInfo['join_url'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
            // Send the email
            Mail::raw("Meeting scheduled successfully!\nMeeting ID: " . $meetingInfo['id'] . "\nJoin URL: " . $meetingInfo['join_url'], function ($message) use ($applicant) {
                $message->to($applicant->email) // Assuming the applicant's email is in the $applicant object
                        ->subject('Your Zoom Meeting Details');
            });
        
            return redirect('/zoom/meetings')->with('success', 'Meeting scheduled successfully! Meeting ID: ' . $meetingInfo['id'] . ' Join URL: ' . $meetingInfo['join_url']);
        } else {
            // Log the error response for debugging
            Log::error('Failed to schedule meeting: ' . $response->body());
            
            return redirect('/home')->with('error', 'Failed to schedule meeting: ' . $response->json()['message']);
        }
    }
    // Schedule Form
    public function showScheduleForm()
    {
        return view('staffpages.sched');
    }
    // Created MEETING
    public function showMeetingForm(){
        $meetings = DB::table('meetings')->get(); // Retrieve all meetings from the database

        return view('staffpages.meetings', compact('meetings')); 
    }
}

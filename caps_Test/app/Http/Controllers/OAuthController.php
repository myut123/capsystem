<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OAuthController extends Controller
{
    // Hardcoded Zoom credentials
    private $clientId = '2Diyr89lQgi9PIHWag71eQ';
    private $clientSecret = '8iXd1bjt1z05oENwtd79ZERkAI76TM27';
    private $redirectUri = 'http://127.0.0.1:8000/oauth/callback'; // Make sure this is the same in Zoom app settings

    // Redirect user to Zoom's authorization page
    public function redirectToProvider()
    {
        $url = "https://zoom.us/oauth/authorize?client_id={$this->clientId}&response_type=code&redirect_uri=" . urlencode($this->redirectUri);
        
        // Log the URL to which the user is being redirected
        Log::info('Redirecting to Zoom authorization: ' . $url);
        
        return redirect($url);
    }

    // Handle the OAuth callback from Zoom
    public function handleProviderCallback(Request $request)
    {
        // Log the received request
        Log::info('Handling provider callback.', ['request' => $request->all()]);

        // Check if the 'code' parameter is present
        if (!$request->has('code')) {
            Log::warning('Authorization code not provided in the callback.');
            return redirect('/oauth/zoom')->withErrors(['error' => 'Authorization code not provided.']);
        }

        // Exchange the authorization code for an access token
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
            'redirect_uri' => $this->redirectUri, // Use hardcoded redirect URI
            'client_id' => $this->clientId, // Add client ID
            'client_secret' => $this->clientSecret, // Add client secret
        ]);

        // Check if the response was successful
        if ($response->successful()) {
            $tokenData = $response->json();

            // Log the received access token data
            Log::info('Access token received successfully.', ['access_token' => $tokenData['access_token']]);

            // Store the access token in the session
            session(['zoom_access_token' => $tokenData['access_token']]);

            // Redirect to the schedule meeting page
            return redirect('/zoom/schedule'); // Redirect to the schedule meeting page
        }

        // Log the error response for debugging purposes
        Log::error('Failed to obtain access token: ' . $response->body(), ['response' => $response->json()]);

        // Return error message to the user
        return redirect('/oauth/zoom')->withErrors(['error' => 'Unable to obtain access token: ' . $response->body()]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class viewApplicant extends Controller
{
    public function show($id)
    {
        
        // Fetch applicant details
        $applicant = DB::table('adoption_application as aa')
            ->join('pet as p', 'aa.idpet', '=', 'p.idpet')
            ->join('addresses as a', 'aa.id_address', '=', 'a.idaddresses')
            ->select(
                'aa.idadoption_application',
                'aa.id', 
                'aa.idpet', 
                'aa.application_date', 
                'aa.status', 
                'aa.first_name', 
                'aa.last_name', 
                'aa.transportation_time', 
                'aa.transportation_date', 
                'aa.meridiem', 
                'aa.id_address', 
                'p.name as name', // Rename for clarity
                'a.street',
                'a.city',
                'a.barangay',
                'a.postalCode',
                'a.region'
            )
            ->where('aa.idadoption_application', $id) // Pass the applicant ID here
            ->first(); // Use first() to get a single result
    
        // Check if applicant exists
        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found'], 404);
        }
    
        // Return the view with applicant data
        return view('staffpages.viewAppli', compact('applicant'));
    }
    
    
}

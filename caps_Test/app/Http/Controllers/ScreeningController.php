<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreeningController extends Controller
{
    public function applicant()
    {
        $applicants = DB::table('adoption_application')
            ->where('status', 'pending')
            ->get();

        return view('staffpages.Screening', compact('applicants'));

    }

  public function acceptApplicant($id)
{
    // Update the status of the adoption application to 'Approved'
    DB::table('adoption_application')
        ->where('idadoption_application', $id)
        ->update([
            'status' => 'Approved',
            'updated_at' => DB::raw('NOW()')
        ]);

    // Store the applicant ID in the session
    session(['applicant_id' => $id]);


    
    // Redirect to the show zoom route with a success message
    return redirect()->route('show.zoom')->with('message', 'Application Accepted');


}

    public function rejectApplicant($id)
    {
        DB::table('adoption_application')
            ->where('idadoption_application', $id)
            ->update([
                'status' => 'Rejected',
                'updated_at' => DB::raw('NOW()')
            ]);

        return redirect()->route('applicant')->with('error', 'Application Rejected');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlParameter extends Controller
{
    public function getAdoptionApplication($idadop)
    {   

        //dd($idadop);
        // Fetch adoption application data from the database based on $idadop
        $application = DB::table('adoption_application as aa')
        ->join('users as u', 'aa.id', '=', 'u.id')
        ->join('pet as p', 'aa.idpet', '=', 'p.idpet')
        ->where('aa.idadoption_application', $idadop)
        ->select('aa.*', 'p.*','u.*')
        ->first();

        //$application = Adoption::where('idadoption_application', $idadop)->first();

        // Check if application exists
        if (!$application) {
            return response()->json(['error' => 'Adoption application not found'], 404);
        }

        // Return the application data
        return response()->json($application);
    }
}

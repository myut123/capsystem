<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function showHome()
    {
        return view('home.homepage');
    }
    public function fetchcampaign(){
        // Retrieve data from the database
        $data = DB::table('campaign')->get(); // Replace 'your_table_name' with your actual table name

        return response()->json($data); // Return data as JSON
    }
}

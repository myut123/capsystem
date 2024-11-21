<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedMeeting extends Controller
{
    public function sched(){
        $userId = session('id'); 
    }
}

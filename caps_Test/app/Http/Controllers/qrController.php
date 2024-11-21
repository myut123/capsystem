<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;




class qrController extends Controller
{
    public function qrView(){
        $adopteds = DB::table('adoption_application')
        ->where('status','Approved')
        ->get();
        return view('QR.Generate',compact('adopteds'));
    }
    
    public function qrGenerate(Request $request){

        $adoptionApplicationId = $request->input('id');

        // Fetch the data for the specific adoption application that matches the given ID
        $data = DB::table('adoption_application as aa')
            ->join('users as u', 'aa.id', '=', 'u.id')
            ->join('pet as p', 'aa.idpet', '=', 'p.idpet')
            ->where('aa.idadoption_application', $adoptionApplicationId) // Match only the specific application ID
            ->where('aa.status', 'Approved') // Additional condition for status 'Approved'
            ->select('u.first_name', 'aa.idadoption_application as idaa', 'u.email as emailshow', 'p.idpet as idpet', 'p.name as name')
            ->get();
        
        // Prepare the data for the QR code
        $qrData = '';
        if ($data->isNotEmpty()) {
            $idadop = $data[0]->idaa; // Get the first idaa (which should be the only one since we matched by ID)
        
            // Create the redirect URL using the specific adoption application ID
            $redirectUrl = "http://127.0.0.1:8000/map?Id=$idadop";
        
            // Prepare the data for the QR code
            $qrData = "URI:$redirectUrl";
        }
        
        // Generate the QR code image
        $renderer = new ImageRenderer(
            new RendererStyle\RendererStyle(400),
            new SvgImageBackEnd()
        );
        
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($qrData);
        
        // Return the view with the QR code image
        return view('Qr.qrCode', ['qrCode' => $qrCode]);
         

    }

    
}

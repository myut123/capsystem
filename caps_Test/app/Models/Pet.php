<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pet'; // Specify the table name
    
    // Define fillable columns if needed
    protected $fillable = ['idpet','species','name', 'age', 'color','size','attitude','gender','special_care','description'];
    
}

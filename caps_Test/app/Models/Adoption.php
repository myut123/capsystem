<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    protected $table = 'adoption_application'; // Specify the table name if it differs from the default convention
    
    protected $fillable = ['idadoption_application', 'id','idpet','application_date','status']; // Specify the fields that can be mass-assigned
    
    // Add any additional logic, relationships, or configuration here
}

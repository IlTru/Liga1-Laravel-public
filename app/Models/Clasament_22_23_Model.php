<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasament_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'Clasament_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'faza',
                        'echipaID',
                        'pozitie',
                        'meciuriJucate',
                        'victorii',
                        'egaluri',
                        'infrangeri',
                        'punctaj'
                        ];
}

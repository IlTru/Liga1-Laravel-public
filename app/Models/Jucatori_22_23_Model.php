<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jucatori_22_23_Model extends Model
{
    protected $table = 'Jucatori_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'numeJucator',
                        'echipaID',
                        'numar',
                        'varsta',
                        'pozitie',
                        'inaltime',
                        'greutate',
                        'nationalitate',
                        'echipaActuala'
                    ];
}

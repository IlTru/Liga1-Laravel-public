<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meciuri_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'Meciuri_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'faza',
                            'nrEtapa',
                            'disputat',
                            'data',
                            'echipaGazdaID',
                            'echipaOaspeteID',
                            'goluriEG',
                            'goluriEO'
                        ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meciuri_Statistici_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'MeciuriStatistici_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'ID_Meci',
                        'SuturiEG',
                        'SuturiEO',
                        'SuturiPePoartaEG',
                        'SuturiPePoartaEO',
                        'PosesieEG',
                        'PosesieEO',
                        'CartonaseGalbeneEG',
                        'CartonaseGalbeneEO',
                        'CartonaseRosiiEG',
                        'CartonaseRosiiEO',
                        'TotalPaseEG',
                        'TotalPaseEO', 
                        'FaulturiEG',
                        'FaulturiEO',
                        'DeposedariEG',
                        'DeposedariEO',
                        'CornereEG',
                        'CornereEO'
                        ];
}

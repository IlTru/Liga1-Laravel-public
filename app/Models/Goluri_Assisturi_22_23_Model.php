<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goluri_Assisturi_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'GoluriAssisturi_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'golSauAssist',
                        'meciID',
                        'jucatorID',
                        'echipaID',
                        'minut',
                        'tip'
                        ];
}
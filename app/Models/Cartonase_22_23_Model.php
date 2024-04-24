<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartonase_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'Cartonase_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'culoareCartonas',
                        'meciID',
                        'jucatorID',
                        'echipaID',
                        'minut'
                        ];
}

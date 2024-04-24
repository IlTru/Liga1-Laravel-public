<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loturi_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'Loturi_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'meciID',
                        'echipaID',
                        'jucatorID',
                        'situatie'
                        ];
}

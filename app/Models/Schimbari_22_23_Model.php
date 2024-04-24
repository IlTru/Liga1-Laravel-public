<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schimbari_22_23_Model extends Model
{
    // use HasFactory;
    protected $table = 'Schimbari_22_23';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'meciID',
                        'jucatorSchimbatID',
                        'jucatorIntratID',
                        'minut',
                        ];
}

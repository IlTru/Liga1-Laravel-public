<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tari_Model extends Model
{
    // use HasFactory;
    protected $table = 'Tari';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'denumire', 
                        'prescurtare',
                        ];
}

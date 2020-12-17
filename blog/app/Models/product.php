<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    const TYPE_ACC = 'Priedas';
    const TYPE_BASE = 'Base';
    const TYPE_BRAKE = 'Stabdis';
    const TYPE_SADDLE = 'Sedynė';
    const TYPE_TYRE = 'Ratas';


}

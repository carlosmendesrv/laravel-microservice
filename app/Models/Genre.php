<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use Uuid;

    protected $casts = ['id' => 'string'];
    protected $fillable = ['name', 'is_active'];
}

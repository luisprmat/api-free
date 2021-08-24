<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory, ApiTrait;

    /** RELATIONSHIPS */
    // Polymorphic
    public function imageable()
    {
        return $this->morphTo();
    }
}

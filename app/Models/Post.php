<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, ApiTrait;

    const DRAFT = 1;
    const PUBLISHED = 2;

    /** RELATIONSHIPS */
    // One To Many (Inverse)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One To Many (Inverse)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many To Many
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // One To Many (polymorphic)
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}

<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable = ['name', 'slug'];

    protected $allowIncluded = ['posts', 'posts.user'];
    protected $allowFilters = ['id', 'name', 'slug'];
    protected $allowSorts = ['id', 'name', 'slug'];

    /** RELATIONSHIPS */
    // One To Many
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_city',
    'dt_city',
    'country_id',

    ];



    /**
     * Get the post that owns the comment.
     *
     * Syntax: return $this->belongsTo(Post::class, 'foreign_key', 'owner_key');
     *
     * Example: return $this->belongsTo(Post::class, 'post_id', 'id');
     *
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

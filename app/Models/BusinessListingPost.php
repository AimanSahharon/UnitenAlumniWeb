<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessListingPost extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'image', 'user_id'];


    public function comments()
    {
        return $this->hasMany(BusinessListingComment::class);
    }

    public function likes()
    {
        return $this->hasMany(BusinessListingLike::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['likes_count'];

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}

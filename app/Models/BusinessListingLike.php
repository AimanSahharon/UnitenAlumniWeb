<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessListingLike extends Model
{
    use HasFactory;
    protected $fillable = ['business_listing_post_id', 'user_id'];

    public function post()
    {
        return $this->belongsTo(BusinessListingPost::class);
    }
}

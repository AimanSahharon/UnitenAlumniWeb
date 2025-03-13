<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';

    protected $fillable = [
        'ic_passport',
        'full_name',
        'student_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ic_passport', 'ic_passport');
    }
}

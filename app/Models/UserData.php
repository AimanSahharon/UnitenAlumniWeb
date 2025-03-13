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
        'year_of_graduation',
        'email_address',
        'mobile_number',
        'permanent_address',
        'college',
        'education_level',
        'name_of_programme',
        'current_employment_status',
        'employment_level',
        'employment_sector',
        'occupational_field',
        'range_of_salary',
        'position_designation',
        'name_of_organisation',
        'location_of_workplace',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ic_passport', 'ic_passport');
    }
}

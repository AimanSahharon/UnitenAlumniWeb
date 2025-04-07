<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ic_passport',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //This user data can only have one user data (e.g their name, education level etc...)
    public function userData()
    {
        return $this->hasOne(UserData::class, 'ic_passport', 'ic_passport');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*protected static function boot() //Once user register, insert some data into user_data table
    {
        parent::boot();

        static::created(function ($user) {
            UserData::create([
                'ic_passport' => $user->ic_passport, // Ensure this value exists
                'full_name' => $user->name,
                'email_address' => $user->email,
            ]);
        });
    } */

    protected static function boot() //Once user register, insert some data into user_data table
    {
        parent::boot();

        static::created(function ($user) {
            // Check if the ic_passport already exists in user_data
            if (!UserData::where('ic_passport', $user->ic_passport)->exists()) {
                UserData::create([
                    'ic_passport' => $user->ic_passport, // Only insert ic_passport
                ]);
            }
        });

        /* Code below is to insert IC, name and email data from registration page into profile page
        
        static::created(function ($user) {
             UserData::create([
                 'ic_passport' => $user->ic_passport, // Ensure this value exists
                 'full_name' => $user->name,
                 'email_address' => $user->email,
             ]);
         });
        
        */
    }

}

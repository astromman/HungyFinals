<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class UserProfile extends Model 
{
    use HasFactory;

    protected $fillable = [
        'google_id',
        'user_type_id',
        'picture',
        'first_name',
        'last_name',
        'contact_num',
        'username',
        'email',
    ];

    public function userType()
    {
        return $this->hasOne(UserType::class, 'id', 'user_type_id');
    }
}

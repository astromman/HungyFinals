<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserProfile extends Model
{
    use HasFactory;

    public function userType()
    {
        return $this->hasOne(UserType::class, 'id', 'user_type_id');
    }
}

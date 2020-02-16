<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['user_id', 'website', 'github_link', 'facebook_link'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

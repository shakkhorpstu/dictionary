<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use SoftDeletes, Notifiable;

    protected $with = ['adminRole'];

    protected $fillable = [
        'user_id', 'admin_role_id'
    ];

    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class);
    }
}

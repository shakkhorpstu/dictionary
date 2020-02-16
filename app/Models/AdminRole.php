<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRole extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];
    protected $with = ['adminPermission'];

    public function adminPermission()
    {
        return $this->hasMany(AdminPermission::class, 'admin_role_id');
    }
}

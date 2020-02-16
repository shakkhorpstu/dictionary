<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPermission extends Model
{
    use SoftDeletes;

    protected $fillable = ['admin_role_id', 'admin_menu_id'];

    protected $with = ['adminMenu'];

    public function adminMenu()
    {
        return $this->belongsTo(AdminMenu::class, 'admin_menu_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'slug', 'featured_image', 'body'];

    public function translations()
    {
        return $this->hasMany(Translation::class, 'model_id')->where('model_name', 'Page');
    }
}

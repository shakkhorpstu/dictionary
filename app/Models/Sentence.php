<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'chapter_id', 'slug', 'description'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'model_id')->where('model_name', 'Sentence');
    }
}

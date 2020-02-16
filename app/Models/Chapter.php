<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description', 'parent_chapter_id', 'image', 'keywords', 'meta_description'];

    public function parentChapter()
    {
        return $this->belongsTo(Chapter::class, 'parent_chapter_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'model_id')->where('model_name', 'Chapter');
    }
}

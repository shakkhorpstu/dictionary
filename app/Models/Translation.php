<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['model_name', 'language_id', 'model_id', 'value_1', 'value_2'];
	protected $with = ['language'];

	public function language()
	{
		return $this->belongsTo(Language::class);
	}
}

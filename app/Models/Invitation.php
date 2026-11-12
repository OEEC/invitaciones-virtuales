<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = [];
    protected $casts = ['data' => 'array'];

    public function template() { return $this->belongsTo(Template::class); }
    public function guests() { return $this->hasMany(Guest::class); }
}

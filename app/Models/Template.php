<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];
    protected $casts = ['fields' => 'array', 'active' => 'boolean'];

    public function invitations() { return $this->hasMany(Invitation::class); }
}

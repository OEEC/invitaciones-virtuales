<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $guarded = [];
    protected $casts = ['responded_at' => 'datetime'];

    protected static function booted(): void
    {
        static::creating(fn ($g) => $g->token ??= Str::random(24));
    }

    public function invitation() { return $this->belongsTo(Invitation::class); }
}

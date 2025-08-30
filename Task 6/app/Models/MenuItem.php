<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['title', 'url', 'is_visible', 'order', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

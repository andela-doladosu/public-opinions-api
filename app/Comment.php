<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opinion_id', 'text', 'user_id',
    ];

    public function opinion()
    {
        return $this->belongsTo(\App\Opinion::class);
    }

    public function comments()
    {
        return $this->belongsTo(\App\User::class);
    }
}

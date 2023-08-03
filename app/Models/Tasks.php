<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tasks extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'todo',
        'completed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'todo' => 'string',
        'completed' => 'boolean'
    ];

    /**
     * Get the parent list.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function list(): BelongsTo
    {
        return $this->belongsTo('App\Models\Lists');
    }

    /**
     * Get the parent user.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}

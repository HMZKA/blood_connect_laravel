<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    protected $fillable=[
        'age',
        'weight',
        'last_time',
        'blood_type',
        'user_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

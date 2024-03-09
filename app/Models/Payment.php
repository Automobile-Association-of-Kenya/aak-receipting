<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['members_id', 'ref_no', 'amount', 'date', 'method', 'description'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(members::class, 'members_id');
    }
}

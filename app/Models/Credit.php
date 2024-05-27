<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_no',
        'customer_no',
        'customer_name',
        'amount',
        'reasons'
    ];
}

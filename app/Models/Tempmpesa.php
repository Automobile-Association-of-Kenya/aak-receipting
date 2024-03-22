<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempmpesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'members_id',
        'invoice_id',
        'phone',
        'amount',
        'description',
        'checkoutid',
        'mpesareference',
        'status',
    ];
}

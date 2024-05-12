<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sales_code',
    ];
}

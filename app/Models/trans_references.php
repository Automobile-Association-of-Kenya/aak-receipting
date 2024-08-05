<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_references extends Model
{
    use HasFactory;

    protected $fillable = ['MSISDN', 'TransID','TransAmount','BillRefNumber'];
}

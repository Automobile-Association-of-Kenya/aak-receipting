<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class members extends Model
{
    use HasFactory;
    protected $fillable = [
        'idNo',
        'surNameName',
        'firstName',
        'secondName',
        'emailAddress',
        'mobilePhoneNumber',
    ];

    /**
     * Get all of the invoices for the members
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'members_id', 'id');
    }
}

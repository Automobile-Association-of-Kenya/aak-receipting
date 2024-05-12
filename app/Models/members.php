<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class members extends Model
{
    use HasFactory;
    protected $fillable = [
        'MembershipNumber',
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

    /**
     * Get all of the payments for the members
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'members_id', 'id');
    }
}

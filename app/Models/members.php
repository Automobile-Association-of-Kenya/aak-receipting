<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class members extends Model
{
    use HasFactory;
    protected $fillable = [
<<<<<<< HEAD
        'MembershipNumber',
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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

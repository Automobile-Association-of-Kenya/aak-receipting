<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'branch_code',
        'created_by_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by_id');
    }

    /**
     * Get all of the invoices for the Branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'branch_id', 'id');
    }
<<<<<<< HEAD

    /**
     * Get all of the payments for the Branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'branch_id', 'id');
    }
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
}

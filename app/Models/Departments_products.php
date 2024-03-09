<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments_products extends Model
{
    use HasFactory;

    protected $fillable = ['departments_id', 'name', 'amount'];

    /**
     * Get all of the invoices for the Departments_products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'department_product_id', 'departments_products');
    }

    /**
     * Get the department that owns the Departments_products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Departments::class, 'departments_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments_products extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['departments_id', 'name', 'amount', 'vatable', 'GlNo'];
=======
    protected $fillable = ['departments_id', 'name', 'amount','Vatable'];
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

    /**
     * Get all of the invoices for the Departments_products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
<<<<<<< HEAD
    public function invoiceproducts(): HasMany
    {
        return $this->hasMany(InvoiceProduct::class, 'departments_products_id', 'id');
=======
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'departments_products_id', 'id');
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

class Invoice extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['invoice_no','branch_id','members_id', 'amount', 'date'];
=======
    protected $fillable = ['invoice_no','branch_id','members_id', 'departments_products_id', 'amount', 'date'];
    /**
     * Get the product that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Departments_products::class, 'departments_products_id');
    }
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

    /**
     * Get the member that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(members::class, 'members_id');
    }

    /**
     * Get the branch that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
<<<<<<< HEAD

    /**
     * Get all of the products for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceProduct::class, 'invoice_id', 'id');
    }

    /**
     * Get all of the payments for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id', 'id');
    }
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
}

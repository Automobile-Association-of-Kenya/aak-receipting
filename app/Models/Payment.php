<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['receipt_no','invoice_id','members_id', 'ref_no', 'amount', 'date', 'method', 'description','user_id'];
=======
    protected $fillable = ['receipt_no','invoice_id','members_id', 'ref_no', 'amount', 'date', 'method', 'description'];
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

    public function member(): BelongsTo
    {
        return $this->belongsTo(members::class, 'members_id');
    }

    /**
     * Get all of the invoices for the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
<<<<<<< HEAD

    /**
     * Get the user that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the branch that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'owners_expenses';

    protected $fillable = [
        'owner_id',
        'user_id',
        'payment_method_id',
        'amount',
        'about',
        'expense_date',
        'image',
        'notes',
        'check_number'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}

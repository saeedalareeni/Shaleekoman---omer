<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnersExpense extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function User()
    {
        return $this->belongsTo(User::class);
    }


    public function Owner()
    {
        return $this->belongsTo(Owner::class, );
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }


    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function Assets()
    {
        return $this->hasMany(Asset::class);
    }


    public function Incomes()
    {
        return $this->hasMany(Income::class);
    }



    public function Expense()
    {
        return $this->hasMany(Expense::class);
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'user_id',
        'credit_type_id',
        'expirationDate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function credittype()
    {
        return $this->belongsTo(CreditType::class);
    }

}

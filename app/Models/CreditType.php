<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
    ];

    public function creditcards()
    {
        return $this->hasMany(CreditCard::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use function PHPUnit\Framework\isNull;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'address',
        'checked',
        'description',
        'interest',
        'date_of_birth',
        'email',
        'account',
        'created_card_id'
    ];


    public function creditcard()
    {
        return $this->hasOne(CreditCard::class);
    }

    protected function dateOfBirth(): Attribute
    {
        return new Attribute(
            null,
            function ($value) {
                if (is_null($value)) {
                    return;
                }
                return strpos($value, '/') ?
                    Carbon::createFromFormat('d/m/Y', $value)->toDate() :
                    Carbon::parse($value)->toDate();
            });
    }

    protected function interest(): Attribute
    {
        return new Attribute(
            null,
            fn($value) => is_null($value) ? $value : str_replace(' ', ',', $value),
        );
    }


}

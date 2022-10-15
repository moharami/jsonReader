<?php

namespace App\Sterategy\Driver;

use App\Models\CreditCard;
use App\Models\CreditType;
use App\Models\User;
use App\Sterategy\Pointer;
use Illuminate\Support\Facades\DB;
use JsonMachine\Items;

class JsonTransfer
{

    private $users;
    private $last;

    public function __construct(public $file)
    {
        $this->setUsers();
        $this->last = Pointer::getPointer();
    }

    public function transfer()
    {
        foreach ($this->users as $key => $user) {
            if ($this->needToSave()) {
                $this->saveRecord($user);
            }
        }
    }

    protected function setUsers()
    {
        $this->users = Items::fromFile($this->file, ['debug' => true]);
    }

    private function saveRecord($user)
    {
        DB::transaction(function () use ($user) {
            $creditCard = $user->credit_card;
            $creditCard->credit_type_id = CreditType::firstOrCreate(['type' => $user->credit_card->type])->id;
            CreditType::firstOrCreate(['type' => $user->credit_card->type])->id;
            $creditCard->user_id = User::create(get_object_vars($user))->id;
            CreditCard::create(get_object_vars($creditCard));
            return Pointer::setPointer($this->users->getPosition());
        });
    }


    protected function needToSave(): bool
    {
        return $this->users->getPosition() > $this->last;
    }
}

<?php

namespace App\Sterategy\Driver;

interface TransferInterface
{
    public function setUsers();

    public function saveRecord($user);

    public function needToSave();

    public function transfer();

}

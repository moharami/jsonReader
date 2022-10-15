<?php

namespace App\Sterategy;

use App\Sterategy\Driver\JsonTransfer;
use Illuminate\Support\Manager;

class FileManager extends Manager
{
    private $extention;

    public function __construct(public $fileName)
    {
        $this->extention = pathinfo($this->fileName, PATHINFO_EXTENSION);
    }

    public function getDefaultDriver()
    {
        return ucfirst($this->extention) . 'Transfer';
    }

    protected function CreateJsonTransferDriver()
    {
        return new JsonTransfer($this->fileName);
    }


}

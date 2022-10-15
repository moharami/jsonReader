<?php

namespace App\Sterategy;

use Illuminate\Support\Facades\Storage;

class Pointer
{
    public static $fileName = 'lastPosition.txt';


    protected static function Disk()
    {
        return Storage::disk('local');
    }

    public static function getPointer()
    {
        return self::Disk()->get(self::$fileName);
    }

    public static function setPointer($pointer)
    {
        return self::Disk()->put(self::$fileName, $pointer);
    }

    public static function resetPointer()
    {
        return self::Disk()->put(self::$fileName, 0);

    }
}

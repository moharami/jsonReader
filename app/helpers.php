<?php


function files($file)
{
    return resolve('file', ['fileName' => storage_path($file)]);
}

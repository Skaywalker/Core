<?php

namespace Modules\Main\Exceptions;

use Exception;

class ModuleNotExist extends Exception
{
    public static function make(string $name): self
    {
        return new static("Module {$name} does not exist.");
    }
}

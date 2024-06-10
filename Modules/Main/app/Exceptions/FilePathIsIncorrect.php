<?php

namespace Modules\Main\Exceptions;

use Exception;

class FilePathIsIncorrect extends Exception
{
    public static function make($path): self
    {
        return new static("Vue file from path {$path} does not exist.");
    }
}

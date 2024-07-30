<?php

namespace Modules\Main\Class;

class FleshMessages
{
 public static function alertMessage(
     string $title='', string $message='', string $type='success',bool $closable=false, string|false $customIcon=false,)
 {
     if (!in_array($type, ['error', 'success','info','warning'])) {
         throw new \InvalidArgumentException("Type must be 'error' or 'success' or 'info' or 'warning'.");
     }
        session()->flash('alertMessage', [
            'title' =>strip_tags($title) ,
            'message' => strip_tags($message),
            'type' => $type,
            'closable' => $closable,
            'customIcon' => $customIcon,
        ]);
 }
}
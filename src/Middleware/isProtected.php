<?php

namespace Middleware;

class IsProtected{

    public static function isApproved($value, $lenght = 65535){
        $value = htmlspecialchars(trim($value));
        // if (strlen($value) > $lenght){
        //     return $error = "Текст слишоком длинный";
        // }
        return $value;
    }

}
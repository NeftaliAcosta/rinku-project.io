<?php

namespace App\Libs;

class Random
{
    public static function EmployeeCode(int $length = 5): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';

        // Generating code
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $random_string;
    }
}

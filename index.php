<?php
    function sanitizeOutput($buffer): array|string|null
    {
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        return preg_replace($search, $replace, $buffer);
    }
    ob_start("sanitizeOutput");
    //ob_start();
    ob_get_contents();
    include "public/index.php";
    ob_end_flush();

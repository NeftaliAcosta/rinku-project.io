<?php

namespace App\Core;

use Exception;

/**
 * SystemException
 * Manage exceptions in a personalized way
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class SystemException extends Exception
{
    /**
     * Get error message exception in an array
     *
     * @access public
     * @return array
     */
    public function exceptionMessage(): array
    {
        $exception = explode('\\', get_class($this));
        return [
            'Exception' => [
                end($exception) => $this->errorMessage()
            ]
        ];
    }

    /**
     * Get error message in string
     *
     * @access public
     * @return string
     */
    public function errorMessage(): string
    {
        return $this->getMessage();
    }

}

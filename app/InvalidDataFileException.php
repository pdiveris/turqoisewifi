<?php

namespace App;

class InvalidDataFileException extends \Exception
{
    public function errorMessage()
    {
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> is not a valid datafile';
        return $errorMsg;
    }
}

<?php

namespace App;

class InvalidDataFileEntryException extends \Exception
{
    public function errorMessage()
    {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> BAD DATA!!!';
        return $errorMsg;
    }
}

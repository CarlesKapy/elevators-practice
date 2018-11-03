<?php

namespace App\Exception;


/**
 * Class NoAvailableElevatorsException
 * @package App\Exception
 */
class NoAvailableElevatorsException extends \Exception
{
    protected $message = "There are no available elevators";
}
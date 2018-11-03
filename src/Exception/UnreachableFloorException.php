<?php

namespace App\Exception;

/**
 * Class UnreachableFloorException
 * @package App\Exception
 */
class UnreachableFloorException extends \InvalidArgumentException
{

    /**
     * FloorOutOfBoundsException constructor.
     * @param int $floor
     */
    public function __construct(int $floor)
    {
        parent::__construct("Floor $floor is not reachable by the elevator");
    }
}
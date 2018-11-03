<?php

namespace App\Strategy;


use App\Entity\Elevator\IElevator;

/**
 * Interface IElevatorSelectionStrategy
 * @package App\Strategy
 */
interface IElevatorSelectionStrategy
{
    /**
     * Returns the elevator that has to attend the request
     * @param \Iterator $elevators
     * @param int $floor
     * @return IElevator
     */
    public function getSuitableElevator(\Iterator $elevators, int $floor): IElevator;

}
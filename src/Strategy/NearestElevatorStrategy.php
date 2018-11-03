<?php

namespace App\Strategy;


use App\Entity\Elevator\IElevator;

/**
 * Class NearestElevatorStrategy
 * @package App\Strategy
 */
class NearestElevatorStrategy implements IElevatorSelectionStrategy
{
    /**
     * Returns the nearest elevator to the floor
     *
     * @param \Iterator $elevators
     * @param int $floor
     * @return IElevator
     */
    public function getSuitableElevator(\Iterator $elevators, int $floor): IElevator
    {
        $minDistance = null;
        $selectedElevator = null;

        foreach($elevators as $elevator) {

            if ($elevator instanceof IElevator && $elevator->isFloorReachable($floor)) {

                if (is_null($selectedElevator)) {
                    $selectedElevator = $elevator;
                    $minDistance = $selectedElevator->distanceToFloor($floor);
                } else if ($minDistance > $elevator->distanceToFloor($floor)){
                    $selectedElevator = $elevator;
                    $minDistance = $selectedElevator->distanceToFloor($floor);
                }

                if ($minDistance === 0) break;

            }

        }

        return $selectedElevator;
    }

}
<?php

namespace App\Strategy;


use App\Entity\Elevator\IElevator;

/**
 * Class NearestAndLessUsedElevatorStrategy
 * @package App\Strategy
 */
class NearestAndLessUsedElevatorStrategy implements IElevatorSelectionStrategy
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
        $arrayElevators = iterator_to_array($elevators);
        usort($arrayElevators, function ($elevatorA, $elevatorB) use ($floor) {
            /** @var $elevatorA IElevator */
            /** @var $elevatorB IElevator */
            return $elevatorA->distanceToFloor($floor) - $elevatorB->distanceToFloor($floor);
        });

        $minDistance = $arrayElevators[0]->distanceToFloor($floor);
        $nearestElevators = array_filter($arrayElevators, function($elevator) use ($floor, $minDistance) {
            /** @var $elevator IElevator */
            return $elevator->distanceToFloor($floor) === $minDistance;
        });

        usort($nearestElevators, function ($elevatorA, $elevatorB) {
        /** @var $elevatorA IElevator */
        /** @var $elevatorB IElevator */
            return $elevatorA->getAccumulatedFloors() - $elevatorB->getAccumulatedFloors();
        });

        return $nearestElevators[0];
    }

}
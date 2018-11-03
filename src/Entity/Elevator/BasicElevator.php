<?php

namespace App\Entity\Elevator;


use App\Exception\UnreachableFloorException;

/**
 * Class BasicElevator
 * @package App\Entity\Elevator
 */
class BasicElevator implements IElevator
{
    /**
     * @var int
     */
    protected $currentFloor;

    /**
     * @var int
     */
    protected $accumulatedFloors;

    /**
     * @var array
     */
    protected $reachableFloors;

    /**
     * Elevator constructor.
     */
    public function __construct()
    {
        $this->reachableFloors = [0];
        $this->currentFloor = 0;
        $this->accumulatedFloors = 0;
    }


    /**
     * @param int $currentFloor
     */
    public function setCurrentFloor(int $currentFloor)
    {
        if (!$this->isFloorReachable($currentFloor)) {
            throw new UnreachableFloorException($currentFloor);
        }
        $this->currentFloor = $currentFloor;
    }

    /**
     * @param array $reachableFloors
     */
    public function setReachableFloors(array $reachableFloors)
    {
        $this->reachableFloors = $reachableFloors;
        $this->currentFloor = $this->reachableFloors[0];
    }


    /**
     * @return int
     */
    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }

    /**
     * @return int
     */
    public function getAccumulatedFloors(): int
    {
        return $this->accumulatedFloors;
    }

    /**
     * @return array
     */
    public function getReachableFloors(): array
    {
        return $this->reachableFloors;
    }



    /**
     * Returns distance to given floor
     *
     * @param int $floor
     * @return int
     */
    public function distanceToFloor(int $floor): int
    {
        return abs($this->currentFloor - $floor);
    }

    /**
     * Checks if floor is reachable by elevator
     *
     * @param int $floor
     * @return bool
     */
    public function isFloorReachable(int $floor): bool
    {
        return in_array($floor, $this->reachableFloors);
    }

    /**
     * @param int $destinationFloor
     * @return int
     */
    public function move(int $destinationFloor): int
    {
        if (!$this->isFloorReachable($destinationFloor)) {
            throw new UnreachableFloorException($destinationFloor);
        }

        $numberOfFloorsMovedAcross = 0;
        $numberOfFloorsMovedAcross += $this->distanceToFloor($destinationFloor);

        $this->currentFloor = $destinationFloor;
        $this->accumulatedFloors += $numberOfFloorsMovedAcross;

        return $numberOfFloorsMovedAcross;
    }


}
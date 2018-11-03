<?php

namespace App\Entity\Elevator;

/**
 * Interface IElevator
 * @package App\Entity\Elevator
 */
interface IElevator
{

    /**
     * Returns current elevator location
     *
     * @return int
     */
    public function getCurrentFloor(): int;

    /**
     * Returns how many floors elevator moved across
     *
     * @return int
     */
    public function getAccumulatedFloors(): int;

    /**
     * Returns distance to given floor
     *
     * @param int $floor
     * @return int
     */
    public function distanceToFloor(int $floor): int;

    /**
     * Checks if floor is reachable by elevator
     *
     * @param int $floor
     * @return bool
     */
    public function isFloorReachable(int $floor): bool;

    /**
     * Moves elevator to destination floor
     *
     * @param int $destinationFloor Floor where the elevator has to go
     * @return int Number of floors moved
     */
    public function move(int $destinationFloor): int;

}
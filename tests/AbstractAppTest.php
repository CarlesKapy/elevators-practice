<?php

namespace App\Tests;

use App\Entity\Elevator\BasicElevator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class AbstractAppTest
 * @package App\Tests
 */
class AbstractAppTest extends TestCase
{

    const LOBBY_FLOOR   = 0;
    const FIRST_FLOOR   = 1;
    const SECOND_FLOOR  = 2;
    const THIRD_FLOOR   = 3;

    const UNREACHABLE_FLOOR = 99;

    /**
     * Helper function to return all floors as array
     *
     * @return array
     */
    protected function getAllFloors()
    {
        return [
            self::LOBBY_FLOOR,
            self::FIRST_FLOOR,
            self::SECOND_FLOOR,
            self::THIRD_FLOOR,
        ];
    }

    /**
     * Helper function to generate a Basic Elevator located on given floor
     *
     * @param int $floor
     * @return BasicElevator
     */
    protected function generateElevatorOnFloor(int $floor)
    {
        $elevator = new BasicElevator();
        $elevator->setReachableFloors($this->getAllFloors());
        $elevator->setCurrentFloor($floor);

        return $elevator;
    }

}
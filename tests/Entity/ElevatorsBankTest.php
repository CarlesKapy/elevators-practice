<?php

namespace App\Tests\Entity;


use App\Entity\ElevatorsBank\ElevatorsBank;
use App\Entity\Elevator\BasicElevator;
use App\Exception\UnreachableFloorException;
use App\Exception\NoAvailableElevatorsException;
use App\Strategy\NearestElevatorStrategy;
use App\Tests\AbstractAppTest;

/**
 * Class ElevatorsBankTest
 * @package App\Tests\Entity
 */
class ElevatorsBankTest extends AbstractAppTest
{

    /**
     *
     */
    public function testShouldThrowNoElevatorsAvailable()
    {
        $this->expectException(NoAvailableElevatorsException::class);

        $elevatorsBank = new ElevatorsBank();
        $elevatorsBank->processRequest(self::LOBBY_FLOOR, self::THIRD_FLOOR);
    }

    /**
     *
     */
    public function testShouldThrowInvalidFloor()
    {
        $this->expectException(UnreachableFloorException::class);

        $elevatorsBank = new ElevatorsBank();
        $elevatorsBank->setElevators($this->generateElevatorsIterator());
        $elevatorsBank->processRequest(self::LOBBY_FLOOR, self::UNREACHABLE_FLOOR);
    }

    /**
     *
     */
    public function testShouldReturnCorrectFloorsMoved()
    {
        $elevatorsBank = new ElevatorsBank();
        $elevatorsBank->setElevators($this->generateElevatorsIterator());
        $elevatorsBank->setSuitableElevatorSelectionStrategy(new NearestElevatorStrategy());
        $floorsMoved = $elevatorsBank->processRequest(self::THIRD_FLOOR, self::LOBBY_FLOOR);

        $this->assertEquals($floorsMoved, 6);
    }

    /**
     * Helper function to generate a basic elevators iterator
     *
     * @return \ArrayIterator
     */
    private function generateElevatorsIterator()
    {
        $reachableFloors = $this->getAllFloors();

        $elevator = new BasicElevator();
        $elevator->setReachableFloors($reachableFloors);

        $elevators = new \ArrayIterator();
        $elevators->append($elevator);

        return $elevators;
    }

}
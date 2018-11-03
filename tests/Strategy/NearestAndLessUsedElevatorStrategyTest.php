<?php

namespace App\Tests\Strategy;


use App\Strategy\NearestAndLessUsedElevatorStrategy;
use App\Tests\AbstractAppTest;

/**
 * Class NearestAndLessUsedElevatorStrategyTest
 * @package App\Tests\Strategy
 */
class NearestAndLessUsedElevatorStrategyTest extends AbstractAppTest
{

    /**
     * @dataProvider elevatorsProvider
     *
     * @param $elevators
     * @param $floor
     * @param $suitableElevator
     */
    public function testShouldReturnNearestAndLessUsedElevator($elevators, $floor, $suitableElevator)
    {
        $strategy = new NearestAndLessUsedElevatorStrategy();
        
        $selectedElevator = $strategy->getSuitableElevator($elevators, $floor);

        $this->assertEquals($selectedElevator, $suitableElevator);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function elevatorsProvider()
    {
        $elevatorOnLobbyMoreUsed = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);
        $elevatorOnLobbyLessUsed = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);

        $elevatorOnLobbyMoreUsed->move(self::THIRD_FLOOR);
        $elevatorOnLobbyMoreUsed->move(self::LOBBY_FLOOR);

        $allElevatorsAreOnLobbyFloor = new \ArrayIterator();
        $allElevatorsAreOnLobbyFloor->append($elevatorOnLobbyMoreUsed);
        $allElevatorsAreOnLobbyFloor->append($elevatorOnLobbyLessUsed);

        return [
            [$allElevatorsAreOnLobbyFloor,      self::SECOND_FLOOR, $elevatorOnLobbyLessUsed],
            [$allElevatorsAreOnLobbyFloor,      self::THIRD_FLOOR,  $elevatorOnLobbyLessUsed]
        ];
    }
    
}
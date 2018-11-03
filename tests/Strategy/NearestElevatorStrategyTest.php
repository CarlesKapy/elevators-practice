<?php

namespace App\Tests\Strategy;


use App\Strategy\NearestElevatorStrategy;
use App\Tests\AbstractAppTest;

/**
 * Class NearestElevatorStrategyTest
 * @package App\Tests\Strategy
 */
class NearestElevatorStrategyTest extends AbstractAppTest
{

    /**
     * @dataProvider elevatorsProvider
     *
     * @param $elevators
     * @param $floor
     * @param $suitableElevator
     */
    public function testShouldReturnNearestElevator($elevators, $floor, $suitableElevator)
    {
        $strategy = new NearestElevatorStrategy();
        
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
        $elevatorOnLobby1 = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);
        $elevatorOnLobby2 = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);
        $elevatorOnFirstFloor = $this->generateElevatorOnFloor(self::FIRST_FLOOR);
        $elevatorOnSecondFloor = $this->generateElevatorOnFloor(self::SECOND_FLOOR);
        $elevatorOnThirdFloor = $this->generateElevatorOnFloor(self::THIRD_FLOOR);

        $thereIsAnElevatorOnEveryFloor = new \ArrayIterator();
        $thereIsAnElevatorOnEveryFloor->append($elevatorOnLobby1);
        $thereIsAnElevatorOnEveryFloor->append($elevatorOnFirstFloor);
        $thereIsAnElevatorOnEveryFloor->append($elevatorOnSecondFloor);
        $thereIsAnElevatorOnEveryFloor->append($elevatorOnThirdFloor);

        $allElevatorsAreOnLobbyFloor = new \ArrayIterator();
        $allElevatorsAreOnLobbyFloor->append($elevatorOnLobby1);
        $allElevatorsAreOnLobbyFloor->append($elevatorOnLobby2);

        return [
            [$thereIsAnElevatorOnEveryFloor,    self::LOBBY_FLOOR,  $elevatorOnLobby1],
            [$thereIsAnElevatorOnEveryFloor,    self::SECOND_FLOOR, $elevatorOnSecondFloor],
            [$allElevatorsAreOnLobbyFloor,      self::LOBBY_FLOOR,  $elevatorOnLobby1],
            [$allElevatorsAreOnLobbyFloor,      self::THIRD_FLOOR,  $elevatorOnLobby1]
        ];
    }
    
}
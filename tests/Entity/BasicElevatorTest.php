<?php

namespace App\Tests\Entity;


use App\Exception\UnreachableFloorException;
use App\Tests\AbstractAppTest;

/**
 * Class BasicElevatorTest
 * @package App\Tests\Entity
 */
class BasicElevatorTest extends AbstractAppTest
{
    /**
     *
     */
    public function testShouldNotReachUnreachableFloor()
    {
        $elevator = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);
        $isReachable = $elevator->isFloorReachable(self::UNREACHABLE_FLOOR);

        $this->assertFalse($isReachable);
    }

    /**
     *
     */
    public function testShouldThrowExceptionWhenSettingUnreachableCurrentFloor()
    {
        $this->expectException(UnreachableFloorException::class);
        $elevator = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);
        $elevator->setCurrentFloor(self::UNREACHABLE_FLOOR);
    }

    /**
     * @dataProvider singleFloorMoveProvider
     *
     * @param int   $initialFloor       Elevator initial floor
     * @param int   $destinationFloor   Floor where the elevator has to go
     * @param int   $numberOfFloorsMoved    Expected floors moved across by elevator
     */
    public function testShouldReturnDistanceToFloor(
        int $initialFloor,
        int $destinationFloor,
        int $numberOfFloorsMoved
    )
    {
        $elevator = $this->generateElevatorOnFloor($initialFloor);
        $distanceToFloor = $elevator->distanceToFloor($destinationFloor);

        $this->assertEquals($distanceToFloor, $numberOfFloorsMoved);
    }

    /**
     * @dataProvider singleFloorMoveProvider
     *
     * @param int   $initialFloor       Elevator initial floor
     * @param int   $destinationFloor   Floor where the elevator has to go
     */
    public function testShouldMoveToDestinationFloorSingleMove(
        int $initialFloor,
        int $destinationFloor
    )
    {
        $elevator = $this->generateElevatorOnFloor($initialFloor);
        $elevator->move($destinationFloor);

        $this->assertEquals($elevator->getCurrentFloor(), $destinationFloor);
    }

    /**
     *
     */
    public function testShouldThrowExceptionWhenTriesToMoveToUnreachableFloor()
    {
        $this->expectException(UnreachableFloorException::class);

        $elevator = $this->generateElevatorOnFloor(self::LOBBY_FLOOR);
        $elevator->move(self::UNREACHABLE_FLOOR);
    }

    /**
     * @dataProvider singleFloorMoveProvider
     *
     * @param int   $initialFloor           Elevator initial floor
     * @param int   $destinationFloor       Floor where the elevator has to go
     * @param int   $numberOfFloorsMoved    Expected floors moved across by elevator
     */
    public function testShouldReturnNumberOfFloorsMovedAcross(
        int $initialFloor,
        int $destinationFloor,
        int $numberOfFloorsMoved
    )
    {
        $elevator = $this->generateElevatorOnFloor($initialFloor);

        $numberOfFloorsMovedAcross = $elevator->move($destinationFloor);

        $this->assertEquals($numberOfFloorsMovedAcross, $numberOfFloorsMoved);
    }

    /**
     * @dataProvider singleFloorMoveProvider
     *
     * @param int   $initialFloor       Elevator initial floor
     * @param int   $destinationFloor   Floor where the elevator has to go
     * @param int   $numberOfFloorsMoved    Expected floors moved across by elevator
     */
    public function testShouldAccumulateFloorsMovedAcross(
        int $initialFloor,
        int $destinationFloor,
        int $numberOfFloorsMoved
    )
    {
        $elevator = $this->generateElevatorOnFloor($initialFloor);

        $elevator->move($destinationFloor);

        $this->assertEquals($elevator->getAccumulatedFloors(), $numberOfFloorsMoved);
    }

    /**
     * Data provider for single moves
     *
     * @return array
     */
    public function singleFloorMoveProvider()
    {
        return [
            [self::LOBBY_FLOOR, self::THIRD_FLOOR, 3],
            [self::THIRD_FLOOR, self::LOBBY_FLOOR, 3],
            [self::LOBBY_FLOOR, self::THIRD_FLOOR, 3]
        ];
    }

}
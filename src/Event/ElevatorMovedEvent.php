<?php

namespace App\Event;


use App\Entity\ControlSystem\ElevatorsBank;
use App\Entity\Elevator\IElevator;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ElevatorMovedEvent
 * @package App\Event
 */
class ElevatorMovedEvent extends Event
{

    const NAME = 'elevator.moved';

    /**
     * @var string
     */
    protected $time;

    /**
     * @var int
     */
    protected $originFloor;

    /**
     * @var int
     */
    protected $destinationFloor;

    /**
     * @var int
     */
    protected $floorsMoved;

    /**
     * @var \Iterator
     */
    protected $elevators;

    /**
     * ElevatorMovedEvent constructor.
     *
     * @param string    $time
     * @param int       $originFloor
     * @param int       $destinationFloor
     * @param int       $floorsMoved
     * @param \Iterator $elevators
     */
    public function __construct(
        string $time,
        int $originFloor,
        int $destinationFloor,
        int $floorsMoved,
        \Iterator $elevators
    )
    {
        $this->time = $time;
        $this->originFloor = $originFloor;
        $this->destinationFloor = $destinationFloor;
        $this->floorsMoved = $floorsMoved;
        $this->elevators = $elevators;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getOriginFloor(): int
    {
        return $this->originFloor;
    }

    /**
     * @return int
     */
    public function getDestinationFloor(): int
    {
        return $this->destinationFloor;
    }

    /**
     * @return int
     */
    public function getFloorsMoved(): int
    {
        return $this->floorsMoved;
    }

    /**
     * @return array
     */
    public function getCurrentElevatorsFloors(): array
    {
        return array_map(function($elevator) {
            /** @var $elevator IElevator */
            return $elevator->getCurrentFloor();
        }, iterator_to_array($this->elevators));
    }

    /**
     * @return array
     */
    public function getElevatorsAccumulatedFloors(): array
    {
        return array_map(function($elevator) {
            /** @var $elevator IElevator */
            return $elevator->getAccumulatedFloors();
        }, iterator_to_array($this->elevators));
    }

}
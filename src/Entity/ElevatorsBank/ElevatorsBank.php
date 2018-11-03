<?php

namespace App\Entity\ElevatorsBank;


use App\Entity\Elevator\IElevator;
use App\Exception\UnreachableFloorException;
use App\Exception\NoAvailableElevatorsException;
use App\Strategy\IElevatorSelectionStrategy;

/**
 * Class ElevatorsBank
 * @package App\Entity\ControlSystem
 */
class ElevatorsBank implements IElevatorsBank
{
    /**
     * @var \Iterator<Elevator>
     */
    protected $elevators;

    /**
     * @var IElevatorSelectionStrategy
     */
    protected $suitableElevatorSelectionStrategy;


    /**
     * ControlSystem constructor.
     */
    public function __construct()
    {
        $this->elevators = new \ArrayIterator();
    }

    /**
     * @return \Iterator
     */
    public function getElevators(): \Iterator
    {
        return $this->elevators;
    }

    /**
     * @param \Iterator $elevators
     */
    public function setElevators(\Iterator $elevators): void
    {
        $this->elevators = $elevators;
    }

    /**
     * @param IElevator $elevator
     */
    public function addElevator(IElevator $elevator): void
    {
        $this->elevators->append($elevator);
    }


    /**
     * @return IElevatorSelectionStrategy
     */
    public function getSuitableElevatorSelectionStrategy(): IElevatorSelectionStrategy
    {
        return $this->suitableElevatorSelectionStrategy;
    }

    /**
     * @param IElevatorSelectionStrategy $suitableElevatorSelectionStrategy
     */
    public function setSuitableElevatorSelectionStrategy(IElevatorSelectionStrategy $suitableElevatorSelectionStrategy)
    {
        $this->suitableElevatorSelectionStrategy = $suitableElevatorSelectionStrategy;
    }

    /**
     * Checks floor is reachable by the elevators system
     *
     * @param int $floor

     */
    public function checkFloorIsValid(int $floor): void
    {
        foreach($this->elevators as $elevator) {
            /** @var $elevator IElevator */
            if ($elevator->isFloorReachable($floor)) {
                return;
            }
        }

        throw new UnreachableFloorException($floor);
    }


    /**
     * @param int $originFloor          Origin floor
     * @param int $destinationFloor     Destination floor
     * @return int                      How many floors elevator has moved across
     *
     * @throws NoAvailableElevatorsException
     * @throws UnreachableFloorException
     */
    public function processRequest(int $originFloor, int $destinationFloor): int
    {
        if ($this->elevators->count() === 0) {
            throw new NoAvailableElevatorsException();
        }

        $this->checkFloorIsValid($originFloor);
        $this->checkFloorIsValid($destinationFloor);

        $selectedElevator = $this->suitableElevatorSelectionStrategy->getSuitableElevator($this->elevators, $originFloor);

        $floorsMoved = 0;
        $floorsMoved += $selectedElevator->move($originFloor);
        $floorsMoved += $selectedElevator->move($destinationFloor);

        return $floorsMoved;
    }


}
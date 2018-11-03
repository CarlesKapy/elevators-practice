<?php

namespace App\Entity\ElevatorsBank;


use App\Entity\Elevator\IElevator;
use App\Strategy\IElevatorSelectionStrategy;


/**
 * Interface IElevatorsBank
 * @package App\Entity\ControlSystem
 */
interface IElevatorsBank
{

    /**
     * @return \Iterator
     */
    public function getElevators(): \Iterator;

    /**
     * @param \Iterator $elevators
     */
    public function setElevators(\Iterator $elevators): void;

    /**
     * @param IElevator $elevator
     */
    public function addElevator(IElevator $elevator): void;

    /**
     * @return IElevatorSelectionStrategy
     */
    public function getSuitableElevatorSelectionStrategy(): IElevatorSelectionStrategy;

    /**
     * @param IElevatorSelectionStrategy $suitableElevatorSelectionStrategy
     */
    public function setSuitableElevatorSelectionStrategy(IElevatorSelectionStrategy $suitableElevatorSelectionStrategy);

    /**
     * @param int $originFloor          Origin floor
     * @param int $destinationFloor     Destination floor
     * @return int                      How many floors elevator has moved across
     */
    public function processRequest(int $originFloor, int $destinationFloor): int;

}
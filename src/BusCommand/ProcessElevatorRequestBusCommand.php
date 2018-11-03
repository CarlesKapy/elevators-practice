<?php

namespace App\BusCommand;


use App\Entity\ElevatorsBank\IElevatorsBank;

/**
 * Class ProcessElevatorRequestBusCommand
 * @package App\BusCommands
 */
class ProcessElevatorRequestBusCommand
{

    /**
     * @var string
     */
    private $time;

    /**
     * @var int
     */
    private $originFloor;

    /**
     * @var int
     */
    private $destinationFloor;

    /**
     * @var IElevatorsBank
     */
    private $elevatorBank;

    /**
     * ProcessElevatorRequestBusCommand constructor.
     *
     * @param string    $time
     * @param int       $originFloor
     * @param int       $destinationFloor
     * @param IElevatorsBank $elevatorBank
     */
    public function __construct(string $time, int $originFloor, int $destinationFloor, IElevatorsBank $elevatorBank)
    {
        $this->time = $time;
        $this->originFloor = $originFloor;
        $this->destinationFloor = $destinationFloor;
        $this->elevatorBank = $elevatorBank;
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
     * @return IElevatorsBank
     */
    public function getElevatorBank(): IElevatorsBank
    {
        return $this->elevatorBank;
    }

}
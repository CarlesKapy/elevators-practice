<?php

namespace App\BusHandler;


use App\Event\ElevatorMovedEvent;
use App\BusCommand\ProcessElevatorRequestBusCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ProcessElevatorRequestBusHandler
 * @package App\BusHandlers
 */
class ProcessElevatorRequestBusHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ProcessElevatorRequestBusHandler constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ProcessElevatorRequestBusCommand $command
     */
    public function handle(ProcessElevatorRequestBusCommand $command)
    {
        $elevatorBank = $command->getElevatorBank();

        $floorsMoved = $elevatorBank->processRequest(
            $command->getOriginFloor(),
            $command->getDestinationFloor()
        );

        $elevatorMovedEvent = new ElevatorMovedEvent(
            $command->getTime(),
            $command->getOriginFloor(),
            $command->getDestinationFloor(),
            $floorsMoved,
            $elevatorBank->getElevators()
        );

        $this->eventDispatcher->dispatch(ElevatorMovedEvent::NAME, $elevatorMovedEvent);
    }

}
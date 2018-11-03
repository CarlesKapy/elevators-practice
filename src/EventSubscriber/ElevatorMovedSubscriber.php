<?php

namespace App\EventSubscriber;


use App\Event\ElevatorMovedEvent;
use App\Logger\CsvLogger;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ElevatorMovedSubscriber
 * @package Subscriber
 */
class ElevatorMovedSubscriber implements EventSubscriberInterface
{
    use LoggerAwareTrait;

    /**
     * ElevatorMovedSubscriber constructor.
     * @param CsvLogger $logger
     */
    public function __construct(CsvLogger $logger)
    {
        $this->setLogger($logger);
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ElevatorMovedEvent::NAME => 'writeLog'
        ];
    }

    /**
     * @param ElevatorMovedEvent $event
     */
    public function writeLog(ElevatorMovedEvent $event): void
    {
        $fields = [
            $event->getTime(),
            $event->getOriginFloor(),
            $event->getDestinationFloor(),
            $event->getCurrentElevatorsFloors(),
            $event->getFloorsMoved(),
            $event->getElevatorsAccumulatedFloors()
        ];

        $this->logger->info(serialize($fields));
    }

}
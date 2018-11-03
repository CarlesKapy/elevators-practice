<?php

namespace App\Logger;


use Psr\Log\LoggerInterface;

/**
 * Class CsvLogger
 * @package App\Logger
 */
class CsvLogger implements LoggerInterface
{
    const FIELD_REQUEST_TIME = "Request time";
    const FIELD_ORIGIN_FLOOR = "Origin floor";
    const FIELD_DESTINATION_FLOOR = "Destination floor";
    const FIELD_ELEVATORS_POSITION = "Elevators position";
    const FIELD_FLOORS_MOVED = "Floors moved";
    const FIELD_ELEVATORS_ACCUMULATED = "Elevators accumulated floors";

    /**
     * @var resource
     */
    private $csvHandler;

    /**
     * CsvLogger constructor.
     * @param string|null $csvPath
     */
    public function __construct(string $csvPath = null)
    {
        if (is_null($csvPath)) {
            $csvPath = "data/reports/report_".date("U").".csv";
        }

        $this->csvHandler = fopen($csvPath, 'w');

        $headerFields = [
            self::FIELD_REQUEST_TIME,
            self::FIELD_ORIGIN_FLOOR,
            self::FIELD_DESTINATION_FLOOR,
            self::FIELD_ELEVATORS_POSITION,
            self::FIELD_FLOORS_MOVED,
            self::FIELD_ELEVATORS_ACCUMULATED,
        ];

        fputcsv($this->csvHandler, $headerFields);

    }

    public function emergency($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        $this->writeToCsv($message, $context);
    }
    
    private function writeToCsv($message, array $context)
    {
        $fields = unserialize($message);

        $strFields = array_map(function ($fieldValue) {
            if (is_array($fieldValue)) {
                return join(" | ", $fieldValue);
            }
            return $fieldValue;
        }, $fields);

        fputcsv($this->csvHandler, $strFields);
    }

}
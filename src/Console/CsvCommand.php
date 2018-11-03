<?php

namespace App\Console;


use App\BusCommand\ProcessElevatorRequestBusCommand;
use App\Entity\ElevatorsBank\ElevatorsBank;
use App\Entity\Elevator\BasicElevator;
use App\Strategy\NearestAndLessUsedElevatorStrategy;
use App\Strategy\NearestElevatorStrategy;

use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class CsvCommand
 * @package App\Console
 */
class CsvCommand extends Command
{
    const CSV_FILE_PATH = "csvFilePath";

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * CsvCommand constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('app:csv')
            ->setDescription('Csv simulation')
            ->setHelp('CSV Elevators control simulation')
            ->addArgument(self::CSV_FILE_PATH, InputArgument::REQUIRED, "Csv Input file path");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csvPath = $input->getArgument(self::CSV_FILE_PATH);

        if (($hCsvFile = fopen($csvPath, 'r')) === FALSE) {
            throw new FileNotFoundException("File $csvPath not found");
        }

        $numOfElevatorsData = fgetcsv($hCsvFile);
        $numOfElevators = $numOfElevatorsData[0];

        $output->writeln("There are $numOfElevators elevators");

        $elevators = new \ArrayIterator();

        foreach(range(1, $numOfElevators) as $n) {

            $reachableFloors = fgetcsv($hCsvFile);
            $strFloors = join(", ", $reachableFloors);

            $output->writeln("Elevator #$n can reach $strFloors floors");

            $elevator = new BasicElevator();
            $elevator->setReachableFloors($reachableFloors);
            $elevators->append($elevator);

        }

        $elevatorsBank = new ElevatorsBank();
        $elevatorsBank->setElevators($elevators);
        $elevatorsBank->setSuitableElevatorSelectionStrategy(new NearestAndLessUsedElevatorStrategy());

        $output->writeln("Processing commands...");

        while(($request = fgetcsv($hCsvFile)) !== FALSE) {

            $time = $request[0];
            $originFloor = $request[1];
            $destinationFloor = $request[2];

            $output->writeln("An elevator has been summoned on $originFloor floor to go to $destinationFloor floor at $time");

            $command = new ProcessElevatorRequestBusCommand($time, $originFloor, $destinationFloor, $elevatorsBank);
            $this->commandBus->handle($command);

        }

        fclose($hCsvFile);
    }

}
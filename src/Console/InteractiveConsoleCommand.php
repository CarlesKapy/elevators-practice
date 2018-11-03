<?php

namespace App\Console;


use App\Entity\ElevatorsBank\ElevatorsBank;
use App\Entity\Elevator\BasicElevator;
use App\Entity\Elevator\IElevator;
use App\Strategy\NearestElevatorStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;


/**
 * Class InteractiveConsoleCommand
 * @package App\Console
 */
class InteractiveConsoleCommand extends Command
{
    const NUM_OF_ELEVATORS  = "numElevators";
    const NUM_OF_FLOORS     = "numFloors";

    protected function configure()
    {
        $this
            ->setName('app:interactive')
            ->setDescription('Interactive console')
            ->setHelp('Interactive console to play Elevator\'s control system')
            ->addArgument(self::NUM_OF_ELEVATORS, InputArgument::REQUIRED, "Number of available elevators")
            ->addArgument(self::NUM_OF_FLOORS, InputArgument::REQUIRED, "Number of building floors");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfFloors = $input->getArgument(self::NUM_OF_FLOORS);
        $numberOfElevators = $input->getArgument(self::NUM_OF_ELEVATORS);

        $availableFloors = range(0, $numberOfFloors);
        $availableElevators = range(1, $numberOfElevators);

        $elevators = new \ArrayIterator();
        foreach($availableElevators as $n) {
            $elevator = new BasicElevator();
            $elevator->setReachableFloors($availableFloors);
            $elevators->append($elevator);
        }

        $elevatorsBank = new ElevatorsBank();
        $elevatorsBank->setElevators($elevators);
        $elevatorsBank->setSuitableElevatorSelectionStrategy(new NearestElevatorStrategy());

        $output->writeln([
            "",
            "===================",
            "Interactive console",
            "===================",
            ""
        ]);

        $output->writeln([
            "",
            "The building has $numberOfFloors floors and $numberOfElevators available elevators, all of them in the lobby",
            ""
        ]);

        $this->renderElevatorsBankState($elevatorsBank, $output);

        $helper = $this->getHelper('question');

        while(true) {
            $questionOriginFloor = new ChoiceQuestion("Please enter the origin floor ", $availableFloors, 0);
            $questionDestinationFloor = new ChoiceQuestion("Please enter the destination floor ", $availableFloors, 0);


            $originFloor = $helper->ask($input, $output, $questionOriginFloor);
            $destinationFloor = $helper->ask($input, $output, $questionDestinationFloor);

            $numberOfFloorsMoved = $elevatorsBank->processRequest($originFloor, $destinationFloor);

            $output->writeln("The elevator has moved $numberOfFloorsMoved floors.");

            $this->renderElevatorsBankState($elevatorsBank, $output);

            $continueQuestion = new ConfirmationQuestion('Continue? (y/n) ', false);
            if (!$helper->ask($input, $output, $continueQuestion)) {
                break;
            }
        }
    }


    /**
     * Renders Control System state as a table
     *
     * @param ElevatorsBank $controlSystem
     * @param OutputInterface $output
     */
    private function renderElevatorsBankState(ElevatorsBank $controlSystem, OutputInterface $output): void
    {
        $table = new Table($output);
        $table->setHeaders(array('# Elevator', '# Floor', 'Accumulated'));

        foreach ($controlSystem->getElevators() as $index => $elevator) {
            /** @var $elevator IElevator */
            $table->addRow([$index, $elevator->getCurrentFloor(), $elevator->getAccumulatedFloors()]);
        }

        $table->render();
    }

}
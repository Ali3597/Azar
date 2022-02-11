<?php

namespace App\Command;

use App\Service\ViewCounter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:view-counter:clean',
    description: 'Deletes all the views in the database and write stats in StatView Repo',
)]
class ViewCounterCleanCommand extends Command
{

    private $viewCounter;


    public function __construct(ViewCounter $viewCounter)
    {
        $this->viewCounter = $viewCounter;
        parent::__construct(null);
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->viewCounter->commandCron();
        $io->success('We deleted the views of the day and update the daily stats yaay');

        return Command::SUCCESS;
    }
}

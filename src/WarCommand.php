<?php

namespace WarCardGame;

use WarCardGame\Game\Context\ConsoleContext;
use WarCardGame\Game\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputOption;

class WarCommand extends Command
{
    protected static $defaultName = 'war';

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var string
     */
    private $playerOneName;

    /**
     * @var string
     */
    private $playerTwoName;

    protected function configure()
    {
        $this
            ->setDescription('This command launch a Game game between two players')
            ->addOption('number', null, InputOption::VALUE_NONE, 'Change the type of package to numeric (1 to 52)')
            ->addOption('discard', 'd', InputOption::VALUE_NONE, 'Discard the card after played')
            ->addOption('no-sleep', 's', InputOption::VALUE_NONE, 'Remove the sleep')
            ->addOption('light-mode', 'l', InputOption::VALUE_NONE, 'Indicate that your console has a light background')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->playerOneName = $this->io->ask('Quel est le nom du premier joueur ?', 'Florian');
        $this->playerTwoName = $this->io->ask('Quel est le nom du second joueur ?', 'Quentin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $context = new ConsoleContext($this->io, $input->getOption('light-mode'));
        $game = new Game($context, $this->playerOneName, $this->playerTwoName, [
            'discard' => $input->getOption('discard'),
            'sleep' => !$input->getOption('no-sleep'),
            'packageType' => $input->getOption('number') ? 'number' : 'classic'
        ]);

        $game->launch();
    }
}
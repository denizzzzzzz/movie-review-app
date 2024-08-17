<?php

namespace Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Application\Seeder\MovieSeeder;

class SeedMoviesCommand extends Command
{
    private $movieSeeder;

    public function __construct(MovieSeeder $movieSeeder)
    {
        parent::__construct();
        $this->movieSeeder = $movieSeeder;
    }

    protected function configure()
    {
        $this->setName('app:seed-movies')
             ->setDescription('Seed the movies table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->movieSeeder->seed();
        $output->writeln('Movies seeded successfully!');
        return Command::SUCCESS;
    }
}
<?php

namespace App\Console\Commands;

use App\InMemoryPersistence;
use App\NanoBotRepository;
use Illuminate\Console\Command;

class PurpleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purple:advent23';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command line implementation of Code Advent Day 23 challenge (Nanobots)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $repository  = NanoBotRepository::loadFromFile(
            app_path('../database/nanobots.data'),
            new InMemoryPersistence()
        );
        $topNano = $repository->findTopNanoBot();
        $inRange = $topNano->inRange($repository);

        echo "Top NanoBot data:\n";
        echo sprintf(" - Within its range: %d\n", $inRange);
        echo sprintf(" - xPos: %d\n", $topNano->getXPos());
        echo sprintf(" - yPos: %d\n", $topNano->getYPos());
        echo sprintf(" - zPos: %d\n", $topNano->getZPos());
        echo sprintf(" - Range: %d\n", $topNano->getRange());
        return true;
    }
}

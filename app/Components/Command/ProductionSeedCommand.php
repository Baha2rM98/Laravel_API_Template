<?php

namespace App\Components\Command;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;

class ProductionSeedCommand extends Command
{
    /**
     * The Seeder instance.
     *
     * @var DatabaseSeeder
     */
    private $seeder;

    /**
     * The Seeder classes should be called.
     *
     * @var array
     */
    protected $seeders = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'production:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds application in production environment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->seeder = new DatabaseSeeder();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->runSeed();
        $this->info('Database seeding in production mode completed successfully.');
        return 0;
    }

    /**
     * Runs the registered seeds.
     *
     * @return void
     */
    private function runSeed()
    {
        $this->seeder->call($this->seeders);
    }
}

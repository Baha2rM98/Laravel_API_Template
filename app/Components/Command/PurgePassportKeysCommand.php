<?php

namespace App\Components\Command;

use Illuminate\Console\Command;

class PurgePassportKeysCommand extends Command
{
    /**
     * The path of passport encryption keys.
     *
     * @var array
     */
    protected $keysPath = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:purge-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purges all passport encryption keys';

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
     * @return int
     */
    public function handle()
    {
        foreach ($this->getKeysPath() as $key) {
            if (!file_exists($key)) {
                $this->line('');
                $this->error('Encryption keys does not exist.');
                return -1;
            }
            @unlink($key);
        }
        $this->info('Passport encryption keys purged successfully.');
        return 0;
    }

    /**
     * Get passport encryption keys path.
     *
     * @return array
     */
    private function getKeysPath()
    {
        if (!empty($this->keysPath)) {
            return $this->keysPath;
        }

        $basePath = storage_path();
        return [
            $basePath . '\oauth-private.key',
            $basePath . '\oauth-public.key',
        ];
    }
}

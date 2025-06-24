<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-permission ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk membuat permission';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info($this->description);
    }
}

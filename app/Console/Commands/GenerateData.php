<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use Database\Seeders\UserSeeder;
use Database\Seeders\MessageSeeder;

class GenerateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:data {totalUsers} {totalMessages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new users and messages';

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

        Artisan::call('db:wipe');

        if($this->argument('totalUsers') <= 1){
            return $this->error('At least one user to chat!');
        }

        Artisan::call('migrate');

        $userSeeder = new UserSeeder();
        $userSeeder->run($this->argument('totalUsers'));
        
        $messageSeeder = new MessageSeeder();
        $messageSeeder->run($this->argument('totalMessages'));

        $this->info('The command was successful!');
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Events\RemainingTimeChanged;
use App\Events\WinnerNumberGenerated;
use Illuminate\Console\Command;

class GameExecutor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start executing the game';

    private $time = 12;

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
    public function handle(): int
    {
        while(true) {
            broadcast(new RemainingTimeChanged($this->time . 's'));

            $this->time--;
            sleep(1);

            if ($this->time === 0) {
                $this->time = 'Waiting to start';
                broadcast(new RemainingTimeChanged($this->time));

                broadcast(new WinnerNumberGenerated(random_int(1, 12)));

                // game start again
                sleep(5);
                $this->time = 5;
            }
        }
    }
}

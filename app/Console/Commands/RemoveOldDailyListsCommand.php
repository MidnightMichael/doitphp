<?php

namespace App\Console\Commands;

use App\TaskLists\TaskListService;
use Illuminate\Console\Command;

class RemoveOldDailyListsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:olddailylists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes previous daily lists';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskListService $taskListService)
    {
        parent::__construct();

        $this->taskListService = $taskListService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->taskListService->removeOldDailyLists();
    }
}

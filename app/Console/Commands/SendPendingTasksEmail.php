<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\SendPendingTasksEmailJob;

class SendPendingTasksEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-pending-tasks-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users with their pending tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            SendPendingTasksEmailJob::dispatch($user);
        }
        $this->info('Daily pending tasks emails have been dispatched successfully to all users.');
    }
}

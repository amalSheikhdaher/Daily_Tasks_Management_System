<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\PendingTasksMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendPendingTasksEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch all users
        $users = User::all();

        // Loop through each user and send email with their pending tasks
        foreach ($users as $user) {
            // Fetch pending tasks specific to the user’s email or user_id (adjust as needed)
            $pendingTasks = Task::where('status', 'Pending')
                                ->where('user_email', $user->email) // Assume tasks have a 'user_email' column
                                ->get();

            // Check if the user has any pending tasks
            if ($pendingTasks->isEmpty()) {
                continue;
            }

            try {
                // Send email to user with pending tasks
                Mail::to($user->email)->send(new PendingTasksMail($user, $pendingTasks));
                Log::info("Email sent to {$user->email}");
            } catch (\Exception $e) {
                Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
            }
        }
    }
}

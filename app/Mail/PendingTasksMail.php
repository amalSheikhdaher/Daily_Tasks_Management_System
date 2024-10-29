<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PendingTasksMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pendingTasks;

    public function __construct($user, $pendingTasks)
    {
        $this->user = $user;
        $this->pendingTasks = $pendingTasks;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pending Tasks Mail',
        );
    }

    public function build()
    {
        return $this->view('emails.pending_tasks')
            ->with([
                'userName' => $this->user->name,
                'tasks' => $this->pendingTasks,
            ]);
    }
}

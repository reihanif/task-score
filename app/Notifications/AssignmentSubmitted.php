<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentSubmitted extends Notification
{
    use Queueable;

    private $assignment;
    private $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($assignment, $task)
    {
        $this->assignment = $assignment;
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('PTGN Notification')
            ->greeting('Assignment Submitted')
            ->line('Assignment submitted by ' . $this->task->assignee->name . ': ' . $this->assignment->subject . $this->task->uuid)
            ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id])));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'from' => $this->task->assignee->name,
            'body' => 'Assignment submitted by <span class="font-semibold text-gray-900 dark:text-white">' . $this->task->assignee->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
            'action' => route('taskscore.assignment.show', ['assignment' => $this->assignment->id]),
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'assignment-submitted';
    }
}

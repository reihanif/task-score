<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentApproved extends Notification
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
            ->greeting('Assignment Approved')
            ->line('Assignment approved by ' . $this->assignment->taskmaster->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid)
            ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id])));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'from' => $this->assignment->taskmaster->name,
            'body' => 'Assignment approved by <span class="font-semibold text-gray-900 dark:text-white">' . $this->assignment->taskmaster->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
            'action' => route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id]),
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'assignment-approved';
    }
}

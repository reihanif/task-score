<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAssignment extends Notification
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'body' => 'New assignment from <span class="font-semibold text-gray-900 dark:text-white">' . $this->assignment->taskmaster->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
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
        return 'new-assignment';
    }
}

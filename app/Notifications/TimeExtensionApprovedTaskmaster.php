<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TimeExtensionApprovedTaskmaster extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Time Extension Approval')
            ->greeting('Time Extension Approval')
            ->line('You have approved the time extension request from ' . $this->task->assignee->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid . '.')
            ->line('Explore the full details by clicking the button below.')
            ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id])));
    }
}

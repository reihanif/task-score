<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAssignmentTaskmaster extends Notification
{
    use Queueable;

    private $assignment;
    private $assignees;

    /**
     * Create a new notification instance.
     */
    public function __construct($assignment, $assignees)
    {
        $this->assignment = $assignment;
        $this->assignees = $assignees;
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
            ->subject('New Assignment Created')
            ->greeting('New Assignment Created')
            ->line('A new assignment has been created with the details below: ')
            ->line('Subject: ' . $this->assignment->subject)
            ->line('Assignee: ' . $this->assignees)
            ->line('Explore the full details by clicking the button below.')
            ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id])));
    }
}

<?php

namespace App\Notifications\TimeExtensions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TimeExtensionRequest extends Notification
{
    use Queueable;

    private $assignment;
    private $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->assignment = $task->assignment;
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $notifiable->isAssignee($this->assignment->id) ? ['mail'] : ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($notifiable->isTaskmaster($this->assignment->id)) {
            return (new MailMessage)
                ->subject('Time Extension Request')
                ->greeting('Time Extension Request')
                ->line('A new request for a time extension has been submitted by ' . $this->task->assignee->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid . '. Please review the details and approve or reject the request promptly.')
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id])));
        }

        if ($notifiable->isAssignee($this->assignment->id)) {
            return (new MailMessage)
                ->subject('Time Extension Request Sent')
                ->greeting('Time Extension Request Sent')
                ->line('Your time extension request has been sent to ' . $this->assignment->taskmaster->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid . '. Please wait for a confirmation')
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id])));
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($notifiable->isTaskmaster($this->assignment->id)) {
            return [
                'from' => $this->task->assignee->name,
                'body' => 'Time extension request from <span class="font-semibold text-gray-900 dark:text-white">' . $this->task->assignee->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
                'action' => route('taskscore.assignment.show', ['assignment' => $this->assignment->id]),
            ];
        }
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'time-extension-request';
    }
}

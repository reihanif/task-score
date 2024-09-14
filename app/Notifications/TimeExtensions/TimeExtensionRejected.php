<?php

namespace App\Notifications\TimeExtensions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TimeExtensionRejected extends Notification
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
        return $notifiable->isTaskmaster($this->assignment->id) ? ['mail'] : ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($notifiable->isAssignee($this->assignment->id)) {
            return (new MailMessage)
                ->subject('Time Extension Rejected')
                ->greeting('Time Extension Rejected')
                ->line('Your time extension request has been rejected by ' . $this->task->latestTimeExtension->approver->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid . '.')
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id])));
        }

        if ($notifiable->isTaskmaster($this->assignment->id)) {
            return (new MailMessage)
                ->subject('Time Extension Rejection')
                ->greeting('Time Extension Rejection')
                ->line('You have rejected the time extension request from ' . $this->task->assignee->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid . '.')
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id])));
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($notifiable->isAssignee($this->assignment->id)) {
            return [
                'from' => $this->task->latestTimeExtension->approver->name,
                'body' => 'Time extension rejected by <span class="font-semibold text-gray-900 dark:text-white">' . $this->task->latestTimeExtension->approver->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
                'action' => route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id]),
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
        return 'time-extension-rejected';
    }
}

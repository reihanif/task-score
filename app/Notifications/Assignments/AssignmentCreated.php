<?php

namespace App\Notifications\Assignments;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentCreated extends Notification
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
        return $notifiable->id == $this->assignment->creator_id ? ['mail'] : ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = new MailMessage();
        $taskmasterAction = url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id]));
        $assigneeAction = url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id]));

        if ($notifiable->id == $this->assignment->creator_id && $notifiable->isTaskmaster($this->assignment->id)) {
            return $mailMessage
                ->subject('New Assignment Created')
                ->greeting('New Assignment Created')
                ->line('A new assignment has been created with the details below: ')
                ->line('Subject: ' . $this->assignment->subject)
                ->line('Category: ' . $this->assignment->type)
                ->line('Assignee: ' . implode(', ', $this->assignment->assignees->pluck('name')->toArray()))
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', $taskmasterAction);
        }

        if ($notifiable->id == $this->assignment->creator_id && $notifiable->isAssignee($this->assignment->id)) {
            return $mailMessage
                ->subject('New Personal Assignment Created')
                ->greeting('New Personal Assignment Created')
                ->line('You have been created a new assignment with the details below: ')
                ->line('Subject: ' . $this->task->uuid . ' ' . $this->assignment->subject . '.')
                ->line('Category: ' . $this->assignment->type)
                ->line('Taskmaster: ' . $this->assignment->taskmaster->name)
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', $assigneeAction);
        }

        if ($notifiable->isTaskmaster($this->assignment->id)) {
            return $mailMessage
                ->subject('Subordinate New Assignment')
                ->greeting('Subordinate Created New Assignment')
                ->line('A new assignment has been created by ' . $this->assignment->creator->name . ' with the details below: ')
                ->line('Subject: ' . $this->task->uuid . ' ' . $this->assignment->subject . '.')
                ->line('Category: ' . $this->assignment->type)
                ->line('Assignee: ' . implode(', ', $this->assignment->assignees->pluck('name')->toArray()))
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', $taskmasterAction);
        }

        if ($notifiable->isAssignee($this->assignment->id)) {
            return $mailMessage
                ->subject('New Assignment')
                ->greeting('New Assignment')
                ->line('You have a new assignment from ' . $this->assignment->creator->name . ': ' . $this->assignment->subject . ' ' . $this->task->uuid . '.')
                ->line('Explore the full details by clicking the button below.')
                ->action('Open Assignment', $assigneeAction);
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
                'from' => $this->assignment->creator->name,
                'body' => 'New Subordinate assignment created by <span class="font-semibold text-gray-900 dark:text-white">' . $this->assignment->creator->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
                'action' => route('taskscore.assignment.show', ['assignment' => $this->assignment->id]),
            ];
        }

        if ($notifiable->isAssignee($this->assignment->id)) {
            return [
                'from' => $this->assignment->creator->name,
                'body' => 'New assignment created by <span class="font-semibold text-gray-900 dark:text-white">' . $this->assignment->creator->name . '</span>: ' . $this->assignment->subject . ' ' . $this->task->uuid,
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
        return 'new-assignment';
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssigneeReminderOverdue extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Action Needed: Overdue Assignment')
            ->greeting('Overdue Assignment')
            ->line('Hi, ' . $notifiable->name)
            ->line('Just a quick reminder – you have an assignment that needs your immediate attention: ' . $this->assignment->subject . ' ' . $this->task->uuid . '. The due date was ' . $this->task->due->format('d F Y, H:i') . ' ' . '(' . $this->task->due->diffForHumans() . ')' . ', so please prioritize its completion as soon as possible to keep your score in good standing.')
            ->line('Explore the full details by clicking the button below.')
            ->action('Open Assignment', url(route('taskscore.assignment.show', ['assignment' => $this->assignment->id, 'task' => $this->task->id])))
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
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssigneeReminder extends Notification
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
            ->subject('Action Needed: Unresolved Assignment')
            ->greeting('Unresolved Assignment')
            ->line('Hi, ' . $notifiable->name)
            ->line('Just a friendly reminder – you have an important assignment pending: ' . $this->assignment->subject . ' ' . $this->task->uuid . '. Please ensure it\'s completed before ' . $this->task->due->format('d F Y, H:i') . ' ' . '(' . $this->task->due->diffForHumans() . ')' . ' to keeping up your good score.')
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

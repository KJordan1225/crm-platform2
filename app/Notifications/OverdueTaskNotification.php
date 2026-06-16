<?php

namespace App\Notifications;

use App\Models\CrmTask;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OverdueTaskNotification extends Notification
{
    use Queueable;

    public function __construct(public CrmTask $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Overdue CRM Task')
            ->line('You have an overdue CRM task.')
            ->line('Task: '.$this->task->title)
            ->line('Due Date: '.$this->task->due_date?->format('m/d/Y'))
            ->action('View Task', route('crm-tasks.show', $this->task));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'overdue_task',
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'due_date' => $this->task->due_date?->toDateString(),
            'message' => 'Task overdue: '.$this->task->title,
            'url' => route('crm-tasks.show', $this->task),
        ];
    }
}

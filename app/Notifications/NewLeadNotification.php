<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification
{
    use Queueable;

    public function __construct(public Lead $lead)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New CRM Lead Assigned')
            ->line('A new lead has been assigned to you.')
            ->line('Lead: '.$this->lead->full_name)
            ->line('Company: '.$this->lead->company)
            ->action('View Lead', route('leads.show', $this->lead));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_lead',
            'lead_id' => $this->lead->id,
            'name' => $this->lead->full_name,
            'company' => $this->lead->company,
            'message' => 'New lead assigned: '.$this->lead->full_name,
            'url' => route('leads.show', $this->lead),
        ];
    }
}

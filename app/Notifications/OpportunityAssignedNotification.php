<?php

namespace App\Notifications;

use App\Models\Opportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpportunityAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(public Opportunity $opportunity)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Opportunity Assigned')
            ->line('A sales opportunity has been assigned to you.')
            ->line('Opportunity: '.$this->opportunity->name)
            ->line('Stage: '.$this->opportunity->stage)
            ->line('Amount: $'.number_format($this->opportunity->amount, 2))
            ->action('View Opportunity', route('opportunities.show', $this->opportunity));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'opportunity_assigned',
            'opportunity_id' => $this->opportunity->id,
            'name' => $this->opportunity->name,
            'stage' => $this->opportunity->stage,
            'amount' => $this->opportunity->amount,
            'message' => 'Opportunity assigned: '.$this->opportunity->name,
            'url' => route('opportunities.show', $this->opportunity),
        ];
    }
}

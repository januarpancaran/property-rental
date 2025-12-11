<?php

namespace App\Notifications;

use App\Models\Maintenance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceCancelledNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Maintenance $maintenance)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
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
            'maintenance_id' => $this->maintenance->id,
            'property_title' => $this->maintenance->property->title,
            'title' => $this->maintenance->title,
            'message' => 'Your maintenance request "' . $this->maintenance->title . '" has been cancelled.',
            'action_url' => url()->route('tenant.maintenances.show', $this->maintenance, false),
        ];
    }
}

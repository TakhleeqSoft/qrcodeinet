<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfflineVendorSubscriptionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('system.email_messages.subscription_request.payment_request'))
            ->greeting(__('system.email_messages.hello',['user' =>$this->attributes['admin_name']]))
            ->line(__('system.email_messages.subscription_request.greeting', ['vendor' => $this->attributes['vendor_name']]))
            ->line('')
            ->line(__('system.email_messages.payment_details'))
            ->line(__('system.email_messages.amount_paid', ['amount' => number_format($this->attributes['payment_amount'], 2)]))
            ->line(__('system.email_messages.payment_method',['payment_method' => $this->attributes['payment_method']]))
            ->line(__('system.email_messages.payment_reference').': '.$this->attributes['payment_reference'])
            ->line(__('system.email_messages.payment_date', ['date' => now()->format('F d, Y')]))
            ->salutation(config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnetimePaymentNotification extends Notification
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
            ->subject(__('system.email_messages.payment_successful.subject'))
            ->greeting(__('system.email_messages.hello', ['user' => $this->attributes['vendor_name']]))
            ->line(__('system.email_messages.payment_successful.message', ['plan_name' => $this->attributes['plan_name']]))
            ->line(__('system.email_messages.payment_details'))
            ->line(__('system.email_messages.plan_name', ['plan_name' => $this->attributes['plan_name']]))
            ->line(__('system.payment_setting.transaction_id') . ': ' . $this->attributes['transaction_id'])
            ->line(__('system.email_messages.amount_paid', ['amount' => number_format($this->attributes['payment_amount'], 2)]))
            ->line(__('system.email_messages.payment_method', ['payment_method' => $this->attributes['payment_method']]))
            ->line(__('system.plans.type') . ': ' . $this->attributes['payment_type'])
            ->line(__('system.email_messages.payment_date', ['date' => $this->attributes['payment_date']->format('F d, Y')]))
            ->line(__('system.email_messages.thank_you_choosing_our_plan', ['plan_name' => $this->attributes['plan_name']]))
            ->line(__('system.email_messages.contact_us'))
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

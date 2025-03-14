<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActionVendorSubscriptionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $name, public string $type = 'approve')
    {
        $this->name = $name;
        $this->type = $type;
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
        $messageObj = (new MailMessage)->greeting(__('system.email_messages.hello', ['user' => $this->name]));
        if ($this->type == 'approve') {
            $messageObj->subject(__('system.email_messages.subscription_approve.subject'))
                ->line(__('system.email_messages.subscription_approve.approve_message'));
        } else {
            $messageObj->subject(__('system.email_messages.subscription_declined.subject'))
                ->line(__('system.email_messages.subscription_declined.declined_message'));
        }

        $messageObj->line(__('system.email_messages.contact_us'))
            ->salutation(config('app.name'));

        return $messageObj;
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

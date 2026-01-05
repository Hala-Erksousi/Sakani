<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Illuminate\Support\Facades\Log;
use Exception;
class AccountVerifiedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
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
        return (new MailMessage)
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
            'title' => 'Your account has been activated',
            'body' => 'Your account has been activated by the admin. Welcome to the Sakani app',
        ];
    }

    public function toFirebase($notifiable)
    {
        $fcmToken = $notifiable->fcm_token; 
        if (!$fcmToken) return;

        try {
            $messaging = app('firebase.messaging');
            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification(FirebaseNotification::create(
                    'Account Activated',
                    'Your account has been activated by the admin. Welcome to the Sakani app.'
                ))
                ->withData([
                    'type' => 'account_verified',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                ]);

            $messaging->send($message);
        } catch (Exception $e) {
            Log::error("FCM Error (Account Activation): " . $e->getMessage());
        }
    }
}

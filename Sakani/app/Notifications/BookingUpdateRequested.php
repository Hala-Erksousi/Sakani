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

class BookingUpdateRequested extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $booking;
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','fcm'];
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
            'booking_id' => $this->booking->id,
            'title'      => 'Request to amend booking',
                'body'       => "The tenant " . $this->booking->user->name . " has requested an amendment to their booking, please review   .",
            ];
    }
     public function toFirebase($notifiable)
    {
        $fcmToken = $notifiable->fcm_token; 
        if (!$fcmToken) 
            return;
        try{
        $messaging = app('firebase.messaging');

        $message = CloudMessage::withTarget('token', $fcmToken)
            ->withNotification(FirebaseNotification::create(
                'Request to amend booking',
                " The tenant " . $this->booking->user->name . " has requested an amendment to their booking."
            ))
            ->withData(['booking_id' => (string)$this->booking->id]);
            $messaging->send($message);
        }catch(Exception $e){
            Log::error('Firebase notification error: '.$e->getMessage());
        }
    }
}

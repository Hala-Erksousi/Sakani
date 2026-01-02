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

class BookingStatusNotification extends Notification
{
    use Queueable;
    protected $booking;
    protected $status;
    public function __construct($booking, $status)
    {
        $this->booking = $booking;
        $this->status = $status;
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
        $messages = $this->getContentByStatus($this->status);
        return [
            'booking_id'  => $this->booking->id,
            'title'       => $messages['title'],
            'body'        => $messages['body']
        ];
    }
    private function getContentByStatus($status)
    {
        switch ($status) {
            case 'Accepted':
                return [
                    'title' => 'Booking Accepted',
                    'body'  => 'The owner has accepted your booking request.',
                ];
            case 'Rejected':
                return [
                    'title' => 'Booking Rejected',
                    'body'  => 'Sorry, your booking request was rejected.',
                ];
            case 'Cancelled':
                return [
                    'title' => 'Booking Cancelled',
                    'body'  => 'Your booking has been cancelled successfully.',
                ];
            default:
                return [
                    'title' => 'Booking Update',
                    'body'  => 'There is an update in your booking status.',
                ];
        }
    }
    public function toFirebase($notifiable)
    {
        $fcmToken = $notifiable->fcm_token; 
        if (!$fcmToken) return;
        try{
        $content = $this->getContentByStatus($this->status);

        $messaging = app('firebase.messaging');

        $message = CloudMessage::withTarget('token', $fcmToken)
            ->withNotification(FirebaseNotification::create(
                $content['title'],
                $content['body']   
            ))
            ->withData([
                'booking_id' => (string)$this->booking->id,
                'status'     => $this->status,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ]);
            $messaging->send($message);
        }catch(Exception $e){
            Log::error('Firebase notification error: '.$e->getMessage());
        }
    }
}

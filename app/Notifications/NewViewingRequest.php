<?php

namespace App\Notifications;

use App\Models\ViewingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewViewingRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $viewingRequest;

    public function __construct(ViewingRequest $viewingRequest)
    {
        $this->viewingRequest = $viewingRequest;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Viewing Request for Your Property')
            ->line('You have received a new viewing request for your property: ' . $this->viewingRequest->property->title)
            ->line('Preferred viewing date: ' . $this->viewingRequest->preferred_date->format('F j, Y g:i A'))
            ->line('From: ' . $this->viewingRequest->user->name)
            ->action('View Request', route('viewing-requests.show', $this->viewingRequest))
            ->line('Thank you for using our platform!');
    }

    public function toArray($notifiable): array
    {
        return [
            'viewing_request_id' => $this->viewingRequest->id,
            'property_id' => $this->viewingRequest->property_id,
            'user_id' => $this->viewingRequest->user_id,
            'preferred_date' => $this->viewingRequest->preferred_date,
            'message' => 'New viewing request for ' . $this->viewingRequest->property->title,
        ];
    }
}
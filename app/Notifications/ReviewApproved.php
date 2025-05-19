<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $review;

    /**
     * Create a new notification instance.
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Review Has Been Approved')
            ->line('Your review for ' . $this->review->property->title . ' has been approved and is now visible to others.')
            ->line('You rated this property ' . $this->review->rating . ' stars.')
            ->action('View Your Review', route('properties.reviews.index', $this->review->property))
            ->line('Thank you for sharing your experience!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'review_id' => $this->review->id,
            'property_id' => $this->review->property_id,
            'property_title' => $this->review->property->title,
            'message' => 'Your review for ' . $this->review->property->title . ' has been approved.',
        ];
    }
}
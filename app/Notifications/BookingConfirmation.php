<?php
// File: app/Notifications/BookingConfirmation.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class BookingConfirmation extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $reservation = $this->reservation;
        
        return (new MailMessage)
            ->subject('Booking Confirmation - ' . $reservation->reservation_number)
            ->greeting('Hello ' . $reservation->guest_name . '!')
            ->line('Thank you for booking with BookYourHotel.')
            ->line('Your reservation has been confirmed.')
            ->line('**Reservation Details:**')
            ->line('Reservation Number: **' . $reservation->reservation_number . '**')
            ->line('Hotel: **' . $reservation->room->hotel->name . '**')
            ->line('Room: **' . $reservation->room->name . '**')
            ->line('Check-in: **' . $reservation->check_in_date->format('d M Y') . '**')
            ->line('Check-out: **' . $reservation->check_out_date->format('d M Y') . '**')
            ->line('Guests: **' . $reservation->number_of_guests . '**')
            ->line('Total Amount: **Rp ' . number_format($reservation->total_price, 0, ',', '.') . '**')
            ->action('View Booking', route('reservations.show', $reservation->id))
            ->line('We look forward to welcoming you!')
            ->line('If you have any questions, please contact us.')
            ->salutation('Best regards, BookYourHotel Team');
    }
}
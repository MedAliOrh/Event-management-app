<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreated extends Notification
{
    use Queueable;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Event Created: ' . $this->event->title)
            ->line('A new event has been created.')
            ->line('Title: ' . $this->event->title)
            ->line('Description: ' . $this->event->description)
            ->line('Location: ' . $this->event->location)
            ->line('Date: ' . $this->event->date)
            ->line('Maximum Participants: ' . $this->event->max_participants)
            ->action('View Event', url('/events/' . $this->event->id));
    }
}
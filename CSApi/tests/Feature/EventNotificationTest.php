<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventCreated;

class EventNotificationTest extends TestCase
{
    public function test_notification_is_sent_when_event_is_created()
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        
        $event = Event::create([
            'title' => 'Test Event',
            'description' => 'Test Description',
            'location' => 'Test Location',
            'date' => now()->addDays(7),
            'max_participants' => 10,
            'status' => 'active',
            'organizer_id' => $admin->id
        ]);

        Notification::assertSentTo(
            [$admin],
            EventCreated::class,
            function ($notification, $channels) use ($event) {
                return $notification->event->id === $event->id;
            }
        );
    }
} 
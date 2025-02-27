<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        
        $events = Event::factory()->count(10)->create([
            'organizer_id' => fn() => $users->random()->id,
            'title' => fn() => 'Event ' . fake()->words(3, true),
            'description' => fn() => fake()->paragraph(),
            'location' => fn() => fake()->address(),
            'date' => fn() => fake()->dateTimeBetween('now', '+2 months'),
            'max_participants' => fn() => fake()->numberBetween(5, 50),
            'status' => 'active',
        ]);

        foreach ($events as $event) {
            $numParticipants = min(rand(1, 3), $users->count());
            $participants = $users->random($numParticipants)->pluck('id');
            $event->participants()->attach($participants);
        }
    }
}
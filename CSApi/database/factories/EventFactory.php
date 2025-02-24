<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'date' => $this->faker->dateTimeBetween('now', '+2 months'),
            'max_participants' => $this->faker->numberBetween(5, 50),
            'status' => 'active',
        ];
    }
}
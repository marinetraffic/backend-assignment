<?php

namespace Database\Factories;

use App\Models\ShipPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use DateTime;

class ShipPositionFactory extends Factory
{
    public function definition()
    {
        return [
            'mmsi' => $this->faker->randomNumber(9, true),
            'status' => $this->faker->numberBetween(0,5),
            'station_id' => $this->faker->numberBetween(1, 10000),
            'speed' => $this->faker->numberBetween(0, 999),
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'course' => $this->faker->numberBetween(1, 999),
            'heading' => $this->faker->numberBetween(1, 999),
            'timestamp' => $this->faker->unixTime(new DateTime)
        ];
    }
}

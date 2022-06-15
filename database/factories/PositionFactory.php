<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $starts_at = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()) ;

        return [
            'mmsi' => $this->faker->randomNumber(9),
            'status' => $this->faker->randomElement([0,1,3,4,5]),
            'station_id' => $this->faker->numberBetween(10, 9999),
            'speed' => $this->faker->numberBetween(0, 999),
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'course' => $this->faker->numberBetween(100, 999),
            'heading' => $this->faker->numberBetween(1, 999),
            'rot' => "",
            'timestamp' => Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addHours( 1)->timestamp,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mmsi' => $this->faker->numberBetween(247039300,247039350),
            'status' => $this->faker->numberBetween(0,10),
            'station' => $this->faker->numberBetween(1,100),
            'speed' => $this->faker->numberBetween(1,100),
            'lon' => $this->faker->longitude(),
            'lat' => $this->faker->latitude(),
            'course' => $this->faker->randomFloat(1),
            'heading' => $this->faker->randomFloat(1),
            'rot' => "",
            'timestamp' => $this->faker->dateTime(now()),
        ];
    }
}

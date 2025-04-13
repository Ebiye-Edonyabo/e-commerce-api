<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $link = Link::inrandomOrder()->first();

        return [
            'order_ref' => 'ORD-' . uniqid(),
            'user_id' => $link->user->id,
            'code' => $link->code,
            'ambassador_email' => $link->user->email,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'zip' => $this->faker->numberBetween(234168, 654783),
            'complete' => 1,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\LikeOcurrence;
use App\Models\Ocurrence;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LikeOcurrence>
 */
class LikeOcurrenceFactory extends Factory
{
    protected $model = LikeOcurrence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'ocurrence_id' => Ocurrence::factory(),
        ];
    }
}

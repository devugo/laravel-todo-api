<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => Str::random(50),
            'user_id' => 1,
            'type' => Str::random(10)
        ];
    }
}

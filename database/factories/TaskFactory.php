<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->unique()->name(),
            'cost' => fake()->randomFloat(2, 0, 100),
            'date_limit' =>  now(),
            'order_of_presentation' => Task::count()+1,
        ];
    }
}

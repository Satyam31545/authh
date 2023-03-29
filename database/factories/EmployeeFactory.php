<?php

namespace Database\Factories;
use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'desigination' => $this->faker->text,
            'salary' => 15,
            'dob' => $this->faker->date,
            'address' => $this->faker->address,
        ];
    }
}

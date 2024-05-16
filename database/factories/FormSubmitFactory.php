<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormSubmit>
 */
class FormSubmitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'dob' => now()->subYears(30)->toDateString(),
            'gender' => 'male',
            'nationality' => 'Saudi',
            'cv' => $this->faker->file(),
            'hr_coordinator_approval' => null,
            'hr_manager_approval' => null
        ];
    }
}

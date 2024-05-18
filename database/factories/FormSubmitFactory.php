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
            'cv' => \Illuminate\Support\Str::random(10) . '.pdf',
            'hr_coordinator_status' => null,
            'hr_manager_status' => null
        ];
    }
}

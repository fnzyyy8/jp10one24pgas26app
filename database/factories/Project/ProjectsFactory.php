<?php

namespace Database\Factories\Project;

use App\Models\Project\Projects;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Projects>
 */
class ProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Projects::class;

    public function definition(): array
    {
        return [
            'project_code' => '112-221-113-331',
            'project_name' => 'Pekerjaan Konstruksi Test',
            'project_number' => '000100.S/PR.01/INT/2026',
            'category' => 'Konstruksi',
            'budget' => 3000000000,
            'isMultipleArea' => false,
            'area' => $this->faker->city(),
            'client' => $this->faker->name(),
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',

        ];
    }
}

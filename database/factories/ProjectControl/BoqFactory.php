<?php

namespace Database\Factories\ProjectControl;

use App\Models\Project\Projects;
use App\Models\ProjectControl\Boq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Boq>
 */
class BoqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Boq::class;

    public function definition(): array
    {
        return [
            'project_id' => Projects::factory(),
            'detailed_area' => 'Detailed Area',
            'isMultipleCustomer' => false
        ];
    }
}

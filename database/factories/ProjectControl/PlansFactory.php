<?php

namespace Database\Factories\ProjectControl;

use App\Models\ProjectControl\Boq;
use App\Models\ProjectControl\Plans;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plans>
 */
class PlansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Plans::class;

    public function definition(): array
    {
        return [
            'boq_id' => Boq::factory(),
            'section' => 'Pekerjaan Persiapan',
            'item_detail' => 'Pembuatan Banner',
            'volume' => 1,
            'unit' => 'ls',
            'unit_price' => 10000,
        ];
    }
}

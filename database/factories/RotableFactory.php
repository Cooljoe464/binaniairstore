<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Rotable;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rotable>
 */
class RotableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rotable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'part_number' => $this->faker->unique()->ean8(),
            'description' => $this->faker->sentence(),
            'serial_number' => $this->faker->unique()->ean13(),
            'quantity_received' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(Status::cases()),
            'airway_bill' => $this->faker->bothify('AWB-########'),
            'supplier_id' => Supplier::factory(),
            'location_id' => ShelfLocation::factory(),
            'received_date' => $this->faker->date(),
        ];
    }
}

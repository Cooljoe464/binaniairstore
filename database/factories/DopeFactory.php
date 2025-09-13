<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Dope;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dope>
 */
class DopeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dope::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'part_number' => $this->faker->ean8(),
            'description' => $this->faker->sentence(),
            'quantity_received' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(Status::cases()),
            'supplier_id' => Supplier::factory(),
            'airway_bill' => $this->faker->bothify('AWB-########'),
            'location_id' => ShelfLocation::factory(),
            'received_by_id' => User::factory(),
            'date' => $this->faker->date(),
        ];
    }
}

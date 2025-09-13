<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tool>
 */
class ToolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tool::class;

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
            'serial_number' => $this->faker->ean13(),
            'quantity_received' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(Status::cases()),
            'calibration_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'supplier_id' => Supplier::factory(),
            'received_by_id' => User::factory(),
            'location_id' => ShelfLocation::factory(),
            'date' => $this->faker->date(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Aircraft;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\Tyre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tyre>
 */
class TyreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tyre::class;

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
            'quantity' => $this->faker->numberBetween(1, 100),
            'aircraft_registration' => Aircraft::inRandomOrder()->first()->registration_number ?? 'N/A',
            'remark' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(Status::cases()),
            'airway_bill' => $this->faker->bothify('AWB-########'),
            'supplier_id' => Supplier::factory(),
            'received_by_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'location_id' => ShelfLocation::factory(),
            'date' => $this->faker->date(),
        ];
    }
}

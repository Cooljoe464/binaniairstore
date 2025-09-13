<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\DangerousGood;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DangerousGood>
 */
class DangerousGoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DangerousGood::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $receivedQuantity = $this->faker->numberBetween(1, 100);

        return [
            'part_number' => $this->faker->ean8(),
            'description' => $this->faker->sentence(),
            'serial_number' => $this->faker->ean13(),
            'received_quantity' => $receivedQuantity,
            'accepted_quantity' => $receivedQuantity,
            'binned_quantity' => $receivedQuantity,
            'ak_reg' => $this->faker->bothify('??-###'),
            'remark' => $this->faker->sentence(),
            'store_officer_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'status' => $this->faker->randomElement(Status::cases()),
            'airway_bill' => $this->faker->bothify('AWB-########'),
            'supplier_id' => Supplier::factory(),
            'location_id' => ShelfLocation::factory(),
            'received_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
        ];
    }
}

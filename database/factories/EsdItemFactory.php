<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Aircraft;
use App\Models\EsdItem;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EsdItemFactory extends Factory
{
    protected $model = EsdItem::class;

    public function definition(): array
    {
        do {
            $partNumber = $this->faker->unique()->ean8();
            $serialNumber = $this->faker->unique()->ean13();
        } while (EsdItem::where('part_number', $partNumber)->where('serial_number', $serialNumber)->exists());

        return [
            'part_number' => $partNumber,
            'description' => $this->faker->sentence(),
            'serial_number' => $serialNumber,
            'quantity' => $this->faker->numberBetween(1, 100),
            'aircraft_registration' => Aircraft::inRandomOrder()->first()->registration_number ?? 'N/A',
            'remark' => $this->faker->sentence(),
            'received_by_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'status' => $this->faker->randomElement(Status::cases()),
            'airway_bill' => $this->faker->bothify('AWB-########'),
            'supplier_id' => Supplier::factory(),
            'location_id' => ShelfLocation::factory(),
            'received_date' => $this->faker->date(),
        ];
    }
}

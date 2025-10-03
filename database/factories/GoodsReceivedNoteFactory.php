<?php

namespace Database\Factories;

use App\Models\GoodsReceivedNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoodsReceivedNoteFactory extends Factory
{
    protected $model = GoodsReceivedNote::class;

    public function definition()
    {
        // Try to get existing users, or create a few if none exist.
        $users = User::all();
        if ($users->count() < 5) {
            User::factory()->count(5)->create();
            $users = User::all();
        }

        $userIds = $users->pluck('id');

        $receivedQuantity = $this->faker->numberBetween(10, 100);
        $acceptedQuantity = $this->faker->numberBetween(5, $receivedQuantity);
        $binnedQuantity = $this->faker->numberBetween(1, $acceptedQuantity);

        return [
            'gr_details' => 'GRN-' . $this->faker->unique()->numberBetween(1000, 9999),
            'gr_date' => $this->faker->dateTimeThisMonth(),
            'gr_type' => $this->faker->randomElement(['Purchase Order', 'Transfer', 'Return']),
            'order_info' => 'PO-' . $this->faker->numberBetween(100, 999),
            'supplier_name' => $this->faker->company,
            'order_details' => 'Order for ' . $this->faker->word,
            'waybill' => $this->faker->bothify('WB-########'),
            'part_number' => $this->faker->bothify('PN-???-####'),
            'description' => $this->faker->sentence,
            'serial_no' => $this->faker->unique()->ean13,
            'received_quantity' => $receivedQuantity,
            'accepted_quantity' => $acceptedQuantity,
            'binned_quantity' => $binnedQuantity,
            'remark' => $this->faker->paragraph,
            'date' => $this->faker->dateTimeThisMonth(),
            'store_officer_id' => $this->faker->randomElement($userIds),
            'aircraft_registration' => null,
            'additional_info' => $this->faker->optional()->sentence,
            'received_by_id' => $this->faker->randomElement($userIds),
            'inspected_by_id' => $this->faker->randomElement($userIds),
            'binned_by_id' => $this->faker->randomElement($userIds),
            'approved_by_id' => $this->faker->randomElement($userIds),
        ];
    }
}

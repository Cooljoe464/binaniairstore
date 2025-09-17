<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requisition;
use App\Models\User;
use App\Models\Aircraft;
use App\Models\Location;
use App\Models\Rotable;
use App\Models\Consumable;
use App\Enums\RequisitionStatus;
use Illuminate\Support\Str;

class RequisitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technicians = User::role('Technician')->get();
        $mds = User::role('MD')->get();
        $storeKeepers = User::role('Store-Manager')->get();
        $aircrafts = Aircraft::all();
        $locations = Location::all();

        // Combine parts from different stores
        $parts = Rotable::all()->concat(Consumable::all());

        if ($technicians->isEmpty() || $parts->isEmpty() || $locations->isEmpty()) {
            $this->command->info('Cannot run RequisitionSeeder: Missing necessary data (technicians, parts, or locations).');
            return;
        }

        for ($i = 1; $i <= 25; $i++) {
            $part = $parts->random();
            $requester = $technicians->random();
            $status = RequisitionStatus::cases()[array_rand(RequisitionStatus::cases())];

            $approved_by_id = null;
            $disbursed_by_id = null;

            if (in_array($status, [RequisitionStatus::APPROVED, RequisitionStatus::DISBURSED, RequisitionStatus::REJECTED])) {
                $approved_by_id = $mds->isNotEmpty() ? $mds->random()->id : null;
            }
            if ($status === RequisitionStatus::DISBURSED) {
                $disbursed_by_id = $storeKeepers->isNotEmpty() ? $storeKeepers->random()->id : null;
            }

            Requisition::create([
                'requisition_no' => 'BGAS-SR-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'part_id' => $part->id,
                'part_type' => get_class($part),
                'aircraft_id' => $aircrafts->isNotEmpty() ? $aircrafts->random()->id : null,
                'serial_number' => ($part instanceof Rotable) ? Str::random(10) : null,
                'quantity_required' => rand(1, 5),
                'quantity_issued' => ($status === RequisitionStatus::DISBURSED) ? rand(1, 5) : 0,
                'stores_batch_number' => ($status === RequisitionStatus::DISBURSED) ? Str::random(8) : null,
                'collectors_name' => $requester->name,
                'additional_notes' => 'This is a seeded requisition.',
                'location_to_id' => $locations->random()->id,
                'requested_by_id' => $requester->id,
                'approved_by_id' => $approved_by_id,
                'disbursed_by_id' => $disbursed_by_id,
                'issued_by_id' => $disbursed_by_id, // Assuming issued by is the same as disbursed by for seeded data
                'status' => $status,
            ]);
        }
    }
}

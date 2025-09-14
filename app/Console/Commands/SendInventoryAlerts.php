<?php

namespace App\Console\Commands;

use App\Models\Consumable;
use App\Models\DangerousGood;
use App\Models\Tool;
use App\Models\User;
use App\Notifications\DueDateNotification;
use App\Notifications\LowStockNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class SendInventoryAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:send-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alerts for low stock and approaching due dates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Sending inventory alerts...');

        $alertableUsers = User::role(['Admin', 'Store-Manager'])->get();

        if ($alertableUsers->isEmpty()) {
            $this->info('No users with Admin or Store-Manager roles found. Skipping alerts.');
            return 0;
        }

        // Due Date Alerts (2 months or less)
        $this->sendDueDateAlertsFor(Consumable::class, $alertableUsers);
        $this->sendDueDateAlertsFor(DangerousGood::class, $alertableUsers);
        $this->sendDueDateAlertsFor(Tool::class, $alertableUsers, 'calibration_date');

        // Low Stock Alerts (quantity < 10)
        $this->sendLowStockAlertsFor(Consumable::class, $alertableUsers);
        $this->sendLowStockAlertsFor(DangerousGood::class, $alertableUsers);
        $this->sendLowStockAlertsFor(Tool::class, $alertableUsers);
        $this->sendLowStockAlertsFor(\App\Models\Rotable::class, $alertableUsers);
        $this->sendLowStockAlertsFor(\App\Models\EsdItem::class, $alertableUsers);
        $this->sendLowStockAlertsFor(\App\Models\Tyre::class, $alertableUsers);
        $this->sendLowStockAlertsFor(\App\Models\Dope::class, $alertableUsers);

        $this->info('Inventory alerts sent successfully.');
        return 0;
    }

    private function sendDueDateAlertsFor($model, $users, $dateColumn = 'due_date')
    {
        $items = $model::where($dateColumn, '<= ', now()->addMonths(2))->get();
        foreach ($items as $item) {
            Notification::send($users, new DueDateNotification($item));
            $this->line('Sent due date alert for ' . class_basename($model) . ': ' . $item->part_number);
        }
    }

    private function sendLowStockAlertsFor($model, $users, $quantityColumn = 'received_quantity', $threshold = 10)
    {
        $items = $model::where($quantityColumn, '< ', $threshold)->get();
        foreach ($items as $item) {
            Notification::send($users, new LowStockNotification($item));
            $this->line('Sent low stock alert for ' . class_basename($model) . ': ' . $item->part_number);
        }
    }
}

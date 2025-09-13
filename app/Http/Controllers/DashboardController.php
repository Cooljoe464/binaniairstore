<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\DangerousGood;
use App\Models\Dope;
use App\Models\EsdItem;
use App\Models\Rotable;
use App\Models\Tool;
use App\Models\Tyre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $lowStockThreshold = 10;

        $lowStockCount = Rotable::where('quantity_received', '< ', $lowStockThreshold)->count()
            + Consumable::where('quantity_received', '< ', $lowStockThreshold)->count()
            + EsdItem::where('quantity_received', '< ', $lowStockThreshold)->count()
            + DangerousGood::where('quantity_received', '< ', $lowStockThreshold)->count()
            + Tyre::where('quantity_received', '< ', $lowStockThreshold)->count()
            + Tool::where('quantity_received', '< ', $lowStockThreshold)->count()
            + Dope::where('quantity_received', '< ', $lowStockThreshold)->count();

        $dueDateThreshold = now()->addMonths(2);

        $dueStockCount = Consumable::where('due_date', '<=', $dueDateThreshold)->count()
            + DangerousGood::where('due_date', '<=', $dueDateThreshold)->count()
            + Tool::where('due_date', '<=', $dueDateThreshold)->count();

        return view('dashboard', [
            'lowStockCount' => $lowStockCount,
            'dueStockCount' => $dueStockCount,
        ]);
    }
}

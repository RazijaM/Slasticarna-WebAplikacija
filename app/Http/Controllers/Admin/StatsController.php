<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Total revenue (exclude cancelled/declined)
        $excludedStatuses = [
            Order::STATUS_OTKAZANA,
            Order::STATUS_ODBIJENA,
        ];

        $totalRevenue = Order::whereNotIn('status', $excludedStatuses)->sum('total');

        // Orders grouped by status
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->orderBy('status')
            ->get()
            ->mapWithKeys(fn ($row) => [$row->status => $row->count])
            ->toArray();

        // Top 5 products sold
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->take(5)
            ->get();

        return view('admin.stats.index', [
            'totalRevenue' => $totalRevenue,
            'ordersByStatus' => $ordersByStatus,
            'topProducts' => $topProducts,
        ]);
    }
}


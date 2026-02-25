<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'statusLogs.changedBy']);

        $statuses = [
            Order::STATUS_KREIRANA,
            Order::STATUS_PRIHVACENA,
            Order::STATUS_ODBIJENA,
            Order::STATUS_U_PRIPREMI,
            Order::STATUS_U_DOSTAVI,
            Order::STATUS_DOSTAVLJENA,
            Order::STATUS_OTKAZANA,
        ];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        $oldStatus = $order->status;
        $newStatus = $data['status'];

        if ($oldStatus === $newStatus) {
            return redirect()
                ->route('admin.orders.show', $order)
                ->with('info', 'Status narudžbe je već postavljen na odabranu vrijednost.');
        }

        $order->update([
            'status' => $newStatus,
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->id(),
            'note' => $data['note'] ?? null,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Status narudžbe je ažuriran.');
    }
}


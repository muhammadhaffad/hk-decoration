<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function view()
    {
        $order = new Order;
        $paid = $order->where('status', 'paid')->count();
        $unpaid = $order->where('status', 'unpaid')->count();
        $expired = $order->where('status', 'expired')->count();
        $failed = $order->where('status', 'failed')->count();
        return view('admin.dashboard', [
            'count' => [
                'paid' => $paid,
                'unpaid' => $unpaid,
                'expired' => $expired,
                'failed' => $failed
            ]
        ]);
    }

    public function income(Request $request)
    {
        $date = $request->validate([
            'year' => 'nullable|numeric|min:1900|max:' . date('Y'),
        ]);

        if (!isset($request->year) && empty($request->year)) {
            $date = [
                'year' => date('Y')
            ];
        }

        $year = $date['year'];

        $startMonth = Carbon::now()->startOfYear()->format('M');
        $endMonth = Carbon::now()->endOfYear()->format('M');
        $period = CarbonPeriod::create($startMonth, '1 month', $endMonth);

        $months = collect($period->toArray())->map(function ($date) {
            return $date->format('F');
        });

        $incomes = collect($period->toArray())->mapWithKeys(function ($date) {
            return [$date->format('F') => 0];
        });

        $inc = Order::select(DB::raw('SUM(total-biayaTransfer) as total, DATE_FORMAT(`tanggalTransaksi`, "%M") as month'))
            ->whereYear('tanggalTransaksi', $year)
            ->groupBy(DB::raw('month(`tanggalTransaksi`)'))
            ->get();

        $inc = $inc->map(
            function ($query) use ($incomes) {
                return $incomes[$query->month] = $query->total;
            }
        );

        return response()->json([
            'incomes' => $incomes,
            'months' => $months
        ]);
    }

    public function order(Request $request)
    {
        $date = $request->validate([
            'year' => 'nullable|numeric|min:1900|max:' . date('Y'),
        ]);

        if (!isset($request->year) && empty($request->year)) {
            $date = [
                'year' => date('Y')
            ];
        }

        $year = $date['year'];

        $startMonth = Carbon::now()->startOfYear()->format('M');
        $endMonth = Carbon::now()->endOfYear()->format('M');
        $period = CarbonPeriod::create($startMonth, '1 month', $endMonth);

        $months = collect($period->toArray())->map(function ($date) {
            return $date->format('F');
        });

        $orders = collect($period->toArray())->mapWithKeys(function ($date) {
            return [$date->format('F') => 0];
        });

        // $inc = Order::select(DB::raw('SUM(total-biayaTransfer) as total, DATE_FORMAT(`tanggalTransaksi`, "%M") as month'))
        //     ->whereYear('tanggalTransaksi', $year)
        //     ->groupBy(DB::raw('month(`tanggalTransaksi`)'))
        //     ->get();

        // $inc = $inc->map(
        //     function ($query) use ($orders) {
        //         return $orders[$query->month] = $query->total;
        //     }
        // );

        $ord = DB::table('orders')
            ->join(
                'orderitems',
                'orderitems.order_kodeSewa',
                '=',
                'orders.kodeSewa'
            )->selectRaw('sum(kuantitas) as kuantitas, DATE_FORMAT(`tanggalTransaksi`, "%M") as month')
            ->whereYear('tanggalTransaksi', $year)
            ->groupBy(DB::raw('month(`tanggalTransaksi`)'))
            ->get();

        $ord = $ord->map(
            function ($q) use ($orders) {
                return $orders[$q->month] = $q->kuantitas;
            }
        );

        return response()->json([
            'incomes' => $orders,
            'months' => $months
        ]);
    }
}
